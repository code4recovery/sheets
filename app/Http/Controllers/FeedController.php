<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Feed;
use DateTime;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('feeds.index', [
            'feeds' => Feed::all(),
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get list of timezones with common ones grouped at the top
        $n_america_tz = ['America/New_York', 'America/Chicago', 'America/Denver', 'America/Los_Angeles'];
        $world_tz = array_diff(timezone_identifiers_list(), $n_america_tz);
        $timezones = [
            'North America' => array_combine($n_america_tz, $n_america_tz),
            'World' => array_combine($world_tz, $world_tz),
        ];

        return view('feeds.create', [
            'user' => Auth::user(),
            'timezones' => $timezones,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //examine sheet URL
        $parts = explode('/', $request->sheet);
        if (
            count($parts) !== 7
            || $parts[2] !== 'docs.google.com'
            || $parts[3] !== 'spreadsheets'
            || $parts[4] !== 'd'
            || !Str::startsWith($parts[6], 'edit#gid=')
        ) {
            return redirect()->back()->withInput()->with('error', 'Sheet URL does not look right!');
        }

        //create entry
        $feed = new Feed();
        $feed->name = $request->name;
        $feed->slug = Str::slug($request->name);
        $feed->timezone = $request->timezone;
        $feed->website = $request->website;
        $feed->spreadsheet_id = $parts[5];
        $feed->sheet_id = substr($parts[6], 8);

        //fetch data
        $json = self::generate($feed->spreadsheet_id, $feed->slug);
        if ($json['status'] === 'error') {
            return redirect()->back()->withInput()->with('error', 'Could not fetch data! The sheet permissions should be set to "anyone with the link can view."');
        }

        $feed->meetings = $json['count'];
        $feed->refreshed_at = new DateTime();

        //wait for success to create entry
        $feed->save();

        return redirect()->route('feeds.index')->with('success', 'Feed created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function refresh($feed_id)
    {
        $feed = Feed::find($feed_id);
        $json = self::generate($feed->spreadsheet_id, $feed->slug);
        if ($json['status'] === 'error') {
            return redirect()->back()->with('error', 'Could not fetch data! The sheet permissions should be set to "anyone with the link can view."');
        }
        $feed->refreshed_at = new DateTime();
        $feed->meetings = $json['count'];
        $feed->save();
        return redirect()->back()->with('success', 'Feed refreshed.');
    }

    public static function generate($spreadsheet_id, $slug)
    {
        $fields = [
            'time',
            'end_time',
            'day',
            'name',
            'location',
            'formatted_address',
            'region',
            'sub_region',
            'types',
            'notes',
            'location_notes',
            'group',
            'district',
            'sub_district',
            'website',
            'venmo',
            'square',
            'paypal',
            'email',
            'phone',
            'group_notes',
            'conference_url',
            'conference_url_notes',
            'conference_phone',
            'conference_phone_notes',
            'slug',
            'updated',
            'latitude',
            'longitude'
        ];

        $types = array_flip([
            '11' => '11th Step Meditation',
            '12x12' => '12 Steps & 12 Traditions',
            'ABSI' => 'As Bill Sees It',
            'BA' => 'Babysitting Available',
            'B' => 'Big Book',
            'H' => 'Birthday',
            'BRK' => 'Breakfast',
            'CAN' => 'Candlelight',
            'CF' => 'Child-Friendly',
            'C' => 'Closed',
            'AL-AN' => 'Concurrent with Al-Anon',
            'AL' => 'Concurrent with Alateen',
            'XT' => 'Cross Talk Permitted',
            'DR' => 'Daily Reflections',
            'DB' => 'Digital Basket',
            'D' => 'Discussion',
            'DD' => 'Dual Diagnosis',
            'EN' => 'English',
            'FF' => 'Fragrance Free',
            'FR' => 'French',
            'G' => 'Gay',
            'GR' => 'Grapevine',
            'HE' => 'Hebrew',
            'NDG' => 'Indigenous',
            'ITA' => 'Italian',
            'JA' => 'Japanese',
            'KOR' => 'Korean',
            'L' => 'Lesbian',
            'LIT' => 'Literature',
            'LS' => 'Living Sober',
            'LGBTQ' => 'LGBTQ',
            'MED' => 'Meditation',
            'M' => 'Men',
            'N' => 'Native American',
            'BE' => 'Newcomer',
            'O' => 'Open',
            'OUT' => 'Outdoor Meeting',
            'POC' => 'People of Color',
            'POL' => 'Polish',
            'POR' => 'Portuguese',
            'P' => 'Professionals',
            'PUN' => 'Punjabi',
            'RUS' => 'Russian',
            'A' => 'Secular',
            'SEN' => 'Seniors',
            'ASL' => 'Sign Language',
            'SM' => 'Smoking Permitted',
            'S' => 'Spanish',
            'SP' => 'Speaker',
            'ST' => 'Step Meeting',
            'TR' => 'Tradition Study',
            'TC' => 'Location Temporarily Closed',
            'T' => 'Transgender',
            'X' => 'Wheelchair Access',
            'XB' => 'Wheelchair-Accessible Bathroom',
            'W' => 'Women',
            'Y' => 'Young People',
        ]);

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        //fetch data
        $response = Http::get(
            'https://sheets.googleapis.com/v4/spreadsheets/' .
                $spreadsheet_id . '/values/A1:ZZ?key=' .
                env('GOOGLE_SHEET_API_KEY')
        );

        if (!$response->successful()) {
            return ['status' => 'error'];
        }

        $rows = $response['values'];

        //get columns
        $columns = array_map(function ($column) {
            return Str::slug($column, '_');
        }, array_shift($rows));
        $column_count = count($columns);

        //remove empty rows
        $rows = array_filter($rows, function ($row) {
            return strlen($row[0]);
        });

        //loop through and format rows
        $rows = array_map(function ($row) use ($columns, $column_count, $fields, $days, $types) {
            $row = array_map('trim', $row);
            $row = array_combine($columns, array_pad($row, $column_count, null));

            if ($row['time']) {
                $row['time'] = date('H:i', strtotime($row['time']));
            }

            if ($row['end_time']) {
                $row['end_time'] = date('H:i', strtotime($row['end_time']));
            }

            if (in_array($row['day'], $days)) {
                $row['day'] = array_search($row['day'], $days);
            }

            if ($row['types']) {
                $row['types'] = explode(',', $row['types']);
                $row['types'] = array_map('trim', $row['types']);
                $row['types'] = array_map('htmlentities', $row['types']);
                $row['types'] = array_values(array_filter($row['types'], function ($type) use ($types) {
                    return array_key_exists($type, $types);
                }));
                $row['types'] = array_map(function ($type) use ($types) {
                    return $types[$type];
                }, $row['types']);
            }

            if ($row['latitude']) {
                $row['latitude'] = floatval($row['latitude']);
            }

            if ($row['longitude']) {
                $row['longitude'] = floatval($row['longitude']);
            }

            $keys = array_filter(array_keys($row), function ($key)  use ($row, $fields) {
                return in_array($key, $fields) && $row[$key] !== '';
            });

            return array_intersect_key($row, array_flip($keys));
        }, $rows);

        //return $rows;

        Storage::disk('public')->put($slug . '.json', json_encode($rows));

        return [
            'status' => 'ok',
            'feed_url' => env('APP_URL') . '/storage/' . $slug . '.json',
            'count' => count($rows),
        ];
    }
}
