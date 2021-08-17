<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Controllers\FeedController;


Route::get('/', function () {
    if (Auth::check()) {
        return view('home', ['user' => Auth::user()]);
    }
    return view('welcome');
});

Route::resource('feeds', FeedController::class);

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {

    //todo what if this fails
    $profile = Socialite::driver('google')->user();

    //create or update user info
    $user = User::firstOrNew(['email' => $profile->email]);
    $user->name = $profile->name;
    $user->avatar = $profile->avatar;
    $user->locale = $profile->user['locale'];
    $user->google_id = $profile->id;
    $user->token = $profile->token;
    //$profile->refreshToken,
    //$profile->expiresIn,
    $user->save();

    //log user in
    Auth::login($user);

    return redirect('/');
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
        return strlen($row[0]);
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

Route::get('aasanjose', function () {

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

    $sheet_id = '12Ga8uwMG4WJ8pZ_SEU7vNETp_aQZ-2yNVsYDFqIwHyE';

    //fetch data
    $rows = Http::get(
        'https://sheets.googleapis.com/v4/spreadsheets/' .
            $sheet_id . '/values/A1:ZZ?key=' .
            env('GOOGLE_SHEET_API_KEY')
    )['values'];

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

    Storage::disk('public')->put('aasanjose.json', json_encode($rows));

    return 'done!';
});
