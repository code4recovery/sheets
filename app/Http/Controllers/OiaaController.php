<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OiaaController extends Controller
{
    // regenerate oiaa feed
    public static function oiaa()
    {
        $response = Http::get(env('OIAA_FEED_URL'));

        if ($response->failed()) {
            return 'failed!';
        }

        $rows = $response->json();

        if (!count($rows)) {
            return 'empty!';
        }

        Storage::disk('public')->put('oiaa.json', json_encode($rows));

        return 'done!';
    }
}
