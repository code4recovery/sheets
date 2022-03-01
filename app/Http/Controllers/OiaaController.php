<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OiaaController extends Controller
{
    //regenerate oiaa feed
    public static function oiaa()
    {
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
    }
}
