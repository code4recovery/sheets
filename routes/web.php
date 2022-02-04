<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Route::view('/', 'welcome');

Route::post('/', function () {
    $parts = explode('/', request('sheetUrl'));
    if (count($parts) !== 7) return redirect()->back();
    return redirect('/' . $parts[5]);
});

Route::get('oiaa', function () {

    //fetch data
    $rows = Http::get(
        'https://sheets.googleapis.com/v4/spreadsheets/' .
            env('GOOGLE_SHEET_ID') . '/values/A1:Z10000?key=' .
            env('GOOGLE_SHEET_API_KEY')
    )['values'];

    //get columns
    $columns = array_map(function ($column) {
        return Str::slug($column, '_');
    }, array_shift($rows));
    $column_count = count($columns);

    //remove empty rows
    $rows = array_filter($rows, function ($row) {
        return is_array($row) && count($row) && strlen($row[0]);
    });

    //loop through and format rows
    $rows = array_map(function ($row) use ($columns, $column_count) {
        $row = array_map('trim', $row);
        extract(array_combine($columns, array_pad($row, $column_count, null)));
        return compact('name', 'times', 'timezone', 'url', 'phone', 'access_code', 'email', 'types', 'formats', 'notes');
    }, $rows);

    Storage::disk('public')->put('oiaa.json', json_encode($rows));

    return 'done!';
});

Route::get('{sheetId}/{slug?}', function ($sheetId, $redirectTo = false) {
    $feedUrl = generate($sheetId);
    return ($redirectTo) ? redirect($redirectTo) : view('done', compact('feedUrl'));
});

function generate($sheetId)
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
        'BI' => 'Bisexual',
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
        'OUT' => 'Outdoor',
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
        'ST' => 'Step Study',
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
            $sheetId . '/values/A1:ZZ?key=' .
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
    $rows = array_values(array_filter($rows, function ($row) {
        return count($row) && strlen($row[0]);
    }));

    //loop through and format rows
    $rows = array_map(function ($row) use ($columns, $column_count, $fields, $days, $types) {
        $row = array_map('trim', $row);
        $row = array_combine($columns, array_pad($row, $column_count, null));

        if (!empty($row['time'])) {
            $row['time'] = date('H:i', strtotime($row['time']));
        }

        if (!empty($row['end_time'])) {
            $row['end_time'] = date('H:i', strtotime($row['end_time']));
        }

        if (!empty($row['day']) && in_array($row['day'], $days)) {
            $row['day'] = array_search($row['day'], $days);
        }

        if (!empty($row['city']) && empty($row['formatted_address'])) {
            $address = [$row['city']];
            if (!empty($row['state'])) {
                if (!empty($row['postal_code'])) {
                    array_push($address, $row['state'] . ' ' . $row['postal_code']);
                } else {
                    array_push($address, $row['state']);
                }
            }
            if (!empty($row['address'])) {
                array_unshift($address, $row['address']);
            }
            if (!empty($row['country'])) {
                array_push($address, $row['country']);
            }
            $row['formatted_address'] = implode(', ', $address);
        }

        if (!empty($row['types'])) {
            $row['types'] = explode(',', $row['types']);
            $row['types'] = array_map('trim', $row['types']);
            $row['types'] = array_map('htmlentities', $row['types']);
            $row['types'] = array_values(array_filter($row['types'], function ($type) use ($types) {
                return array_key_exists($type, $types) || in_array($type, $types);
            }));
            $row['types'] = array_map(function ($type) use ($types) {
                return array_key_exists($type, $types) ? $types[$type] : $type;
            }, $row['types']);

            //automatically apply "digital basket" type
            $row['types'] = array_filter($row['types'], function ($type) {
                return $type !== 'DB';
            });
            if (!empty($row['venmo']) || !empty($row['paypal']) || !empty($row['square'])) {
                array_push($row['types'], 'DB');
            }

            //either speaker or discussion
            if (in_array('SP', $row['types']) && in_array('D', $row['types'])) {
                $row['types'] = array_filter($row['types'], function ($type) {
                    return $type !== 'SP';
                });
            }

            $row['types'] = array_values($row['types']);
        }

        if (!empty($row['latitude'])) {
            $row['latitude'] = floatval($row['latitude']);
        }

        if (!empty($row['longitude'])) {
            $row['longitude'] = floatval($row['longitude']);
        }

        $keys = array_filter(array_keys($row), function ($key)  use ($row, $fields) {
            return in_array($key, $fields) && $row[$key] !== '';
        });

        return array_intersect_key($row, array_flip($keys));
    }, $rows);

    Storage::disk('public')->put($sheetId . '.json', json_encode($rows));

    return env('APP_URL') . '/storage/' . $sheetId . '.json';
}
