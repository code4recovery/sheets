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

Route::get('puget-sound', function () {
    $redirectTo = request('redirectTo');
    list($d54, $d54warnings) = Controller::fetch('15ABWfNki5wWyufgoC3V3EZZ_DRGmAbz3SecoFBND1yY');
    list($pscso, $pscsowarnings) = Controller::fetch('13W4lBuRWKpnHNOC_3wTXI5anLVOkyvMmyn4Wvqx1z3c');
    $rows = array_merge($d54, $pscso);
    $warnings = array_merge($d54warnings, $pscsowarnings);
    $response = Controller::generate($rows, $warnings, 'puget-sound.json');
    if (!empty($response['error'])) {
        return redirect()->back()->with('error', $response['error'])->with('sheetUrl', 'https://docs.google.com/spreadsheets/d/' . $sheetId . '/edit#gid=0');
    }
    return ($redirectTo && !count($response['warnings'])) ? redirect($redirectTo) : view('done', $response);
});

Route::get('{sheetId}', function ($sheetId, $redirectTo = false) {
    $redirectTo = request('redirectTo');
    list($rows, $warnings) = Controller::fetch($sheetId);
    $response = Controller::generate($rows, $warnings, $sheetId . '.json');
    if (!empty($response['error'])) {
        return redirect()->back()->with('error', $response['error'])->with('sheetUrl', 'https://docs.google.com/spreadsheets/d/' . $sheetId . '/edit#gid=0');
    }
    return ($redirectTo && !count($response['warnings'])) ? redirect($redirectTo) : view('done', $response);
});
