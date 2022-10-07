<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class AirtableController extends Controller
{
    //refresh aasfmarin's feed
    public static function aasfmarin()
    {
        //get results from airtable
        $results = self::table('SYNC_tsml', 'TSML_fields');

        //format them in the right format
        $meetings = self::convert($results);

        //prepare data
        Storage::disk('public')->put('aasfmarin.json', response()->json($meetings)->getContent());

        //format them in the right format
        $errors = self::convert($results, true);

        //prepare data
        return view('aasfmarin', compact('errors'));
    }

    //recursive function to get records from Airtable API in batches
    static function table($table, $view = null, $offset = null, $client = null)
    {

        //set up a request handler
        if (!$client) $client = new Client();

        //set up curl request
        $response = $client->get(self::airtableUrl($table, $view, $offset), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('AIRTABLE_KEY'),
                'Accept' => 'application/json',
            ]
        ]);

        //decode json
        $result = json_decode($response->getBody());

        //recursion
        return (empty($result->offset)) ?
            $result->records :
            array_merge(
                $result->records,
                self::table($table, $view, $result->offset, $client)
            );
    }

    //set up url
    private static function airtableUrl($table, $view = null, $offset = null)
    {

        $url = 'https://api.airtable.com/v0/' . env('AIRTABLE_BASE') . '/' . $table;

        $params = [];

        if ($view) {
            $params['view'] = $view;
        }

        //if there's a record offset, append it to the URL and wait for Airtable's API limit
        if ($offset) {
            $params['offset'] = $offset;
            sleep(.2);
        }

        if (count($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    //convert airtable format to meeting guide format
    static function convert($rows, $return_errors = false)
    {
        $meetings = $errors = $new_conference_providers = [];

        $required_fields = ['name', 'day', 'time'];

        $location_fields = ['address', 'city', 'postal_code'];

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        //standard TSML types are defined in Controller.php
        $values = array_merge(self::$tsml_types, [
            'Beginner' => 'BE',
            'Book Study' => 'LIT',
            'Chip Meeting' => 'H',
            'Chips Monthly' => 'H',
            'Chips Weekly' => 'H',
            'Childcare' => 'BA',
            'Speaker Discussion' => 'D',
            'Step Study' => 'ST',
            'Traditions Study' => 'TR',
        ]);

        foreach ($rows as $row) {

            //dd($row->fields);

            $url = $row->fields->{'Open Source Record'}->{'url'};

            //must have each of these fields
            foreach ($required_fields as $field) {
                if (empty(self::getValue($row, $field))) {
                    $errors[] = [
                        'url' => $url,
                        'name' => self::getValue($row, 'Meeting Name'),
                        'issue' => 'empty ' . $field . ' field',
                    ];
                    continue 2;
                }
            }

            //must have one of these fields
            $location = false;
            foreach ($location_fields as $field) {
                if (!empty(self::getValue($row, $field))) $location = true;
            }
            if (!$location) {
                $errors[] = [
                    'url' => $url,
                    'name' => self::getValue($row, 'name'),
                    'issue' => 'no location information',
                ];
                continue;
            }

            //day must be valid
            if (!in_array(self::getValue($row, 'day'), $days)) {
                $errors[] = [
                    'url' => $url,
                    'name' => self::getValue($row, 'name'),
                    'issue' => 'unexpected day',
                    'value' => self::getValue($row, 'day'),
                ];
                continue;
            }

            //types
            $types = [];
            if (!empty($row->fields->types)) {
                $types_array = explode(',', $row->fields->types);
                foreach ($types_array as $value) {
                    $value = trim($value);
                    if (!array_key_exists($value, $values)) {
                        $errors[] = [
                            'url' => $url,
                            'name' => self::getValue($row, 'name'),
                            'issue' => 'unexpected type',
                            'value' => $value,
                        ];
                        continue;
                    }
                    $types[] = $values[$value];
                }
            }

            //hide meetings that are temporarily closed and not online
            if (
                in_array('TC', $types) &&
                empty(self::getValue($row, 'conference_url')) &&
                empty(self::getValue($row, 'conference_phone'))
            ) {
                continue;
            }

            //conference url
            if (!empty(self::getValue($row, 'conference_url'))) {

                $conference_url = parse_url(self::getValue($row, 'conference_url'));
                if (empty($conference_url['host'])) {
                    $errors[] = [
                        'url' => $url,
                        'name' => self::getValue($row, 'name'),
                        'issue' => 'could not parse url',
                        'value' => self::getValue($row, 'conference_url'),
                    ];
                } else {
                    $matches = array_filter(array_keys(self::$tsml_conference_providers), function ($domain) use ($conference_url) {
                        return stripos($conference_url['host'], $domain) !== false;
                    });
                    if (!count($matches)) {
                        $new_conference_providers[] = $conference_url['host'];
                        $errors[] = [
                            'url' => $url,
                            'name' => self::getValue($row, 'name'),
                            'issue' => 'unexpected conference provider',
                            'value' => $conference_url['host'],
                        ];
                    }
                }
            }

            $meetings[] = array_filter([
                'slug' => self::getValue($row, 'slug'),
                'name' => self::getValue($row, 'name'),
                'time' => !empty($row->fields->time) ? date('H:i', strtotime($row->fields->time)) : null,
                'end_time' => !empty($row->fields->source_End_Time) ? date('H:i', strtotime($row->fields->source_End_Time)) : null,
                'day' => array_search(self::getValue($row, 'day'), $days),
                'types' => array_unique($types),
                'conference_url' => self::getValue($row, 'conference_url'),
                'conference_url_notes' => self::getValue($row, 'conference_url_notes'),
                'conference_phone' => self::getValue($row, 'conference_phone'),
                'conference_phone_notes' => self::getValue($row, 'conference_phone_notes'),
                'square' => self::getValue($row, 'square'),
                'venmo' => self::getValue($row, 'venmo'),
                'paypal' => self::getValue($row, 'paypal'),
                'notes' => self::getValue($row, 'notes'),
                'location' => self::getValue($row, 'location'),
                'address' => self::getValue($row, 'address'),
                'city' => self::getValue($row, 'city'),
                'state' => self::getValue($row, 'state'),
                'postal_code' => self::getValue($row, 'postal_code'),
                'country' => self::getValue($row, 'country', 'USA'),
                'region' => self::getValue($row, 'region'),
                'sub_region' => self::getValue($row, 'sub_region'),
                'location_notes' => self::getValue($row, 'location_notes'),
                'timezone' => self::getValue($row, 'timezone'),
                'feedback_url' => self::getValue($row, 'feedback_url'),
                'latitude' => self::getValue($row, 'latitude'),
                'longitude' => self::getValue($row, 'longitude'),
                'url' => 'https://aasfmarin.org/meetings?meeting=' . self::getValue($row, 'slug'),
            ], function ($value) {
                return $value !== null;
            });
        }

        return $return_errors ? $errors : $meetings;
    }

    //airtable values can sometimes be an array
    static function getValue($row, $key, $default = null)
    {
        if (empty($row->fields->{$key})) return $default;
        if (is_array($row->fields->{$key})) return trim($row->fields->{$key}[0]);
        return trim($row->fields->{$key});
    }
}
