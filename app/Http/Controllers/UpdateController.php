<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Feed;
use App\Models\User;
use DateTime;

class UpdateController extends Controller
{
    /**
     * Display the meeting update form
     *
     * @return \Illuminate\Http\Response
     */
    public function form($feed, $slug)
    {
        $feed = Feed::firstOrFail('slug', $feed);
        $meetings = Storage::disk('public')->get($feed->slug . '.json');
        $meetings = array_filter(json_decode($meetings), function ($meeting) use ($slug) {
            return $meeting->slug === $slug;
        });
        if (!count($meetings)) abort(404);
        return view('update.form', [
            'feed' => $feed,
            'meeting' => array_values($meetings)[0],
        ]);
    }

    public function send($feed, $slug)
    {
        return $feed . '/' . $slug;
    }
}
