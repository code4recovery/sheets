<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OiaaController;
use App\Http\Controllers\AirtableController;

Route::view('/', 'welcome');

Route::post('/', function () {
    $parts = explode('/', request('sheetUrl'));
    if (count($parts) !== 7) return redirect()->back();
    return redirect('/' . $parts[5]);
});

Route::get('oiaa', [OiaaController::class, 'oiaa']);

Route::get('aasfmarin', [AirtableController::class, 'aasfmarin']);

Route::get('{sheetId}', function ($sheetId, $redirectTo = false) {
    $redirectTo = request('redirectTo');
    $response = Controller::generate($sheetId);
    if (!empty($response['error'])) {
        return redirect()->back()->with('error', $response['error'])->with('sheetUrl', 'https://docs.google.com/spreadsheets/d/' . $sheetId . '/edit#gid=0');
    }
    return ($redirectTo) ? redirect($redirectTo) : view('done', $response);
});
