<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
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

    //loop through and format rows
    $rows = array_map(function ($row) use ($columns, $column_count) {
        extract(array_combine($columns, array_pad($row, $column_count, null)));
        return compact('name', 'times', 'timezone', 'url', 'phone', 'access_code', 'email', 'types', 'formats', 'notes');
    }, $rows);

    Storage::disk('public')->put('oiaa.json', json_encode($rows));

    return 'done!';
});
