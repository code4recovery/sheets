@extends('template')

@section('content')

    <h1>
        Feed Refreshed ✅
    </h1>

    <pre class="rounded bg-dark text-light p-3 mt-3 mb-4 overflow-scroll">{{ $feedUrl }}</pre>

    <p>Bookmark this page so you don't need to fill out the form every time.</p>

    <p>You can be redirected after refreshing by passing a <code>redirectTo</code> parameter to this URL.</p>

    <p>Feeds that are not refreshed within 30 days will be removed automatically.</p>

@endsection
