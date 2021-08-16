@extends('template')

@section('content')

<div class="max-w-xl mx-auto my-5 grid gap-5 justify-items-center">
    <img src="/logo.png" width="400" height="400" class="block w-16 h-16">
    <h1 class="font-bold text-xl">Feed Manager</h1>
    <p class="text-center">Turn your AA meeting listings in Google Sheets into JSON feeds for the Meeting Guide app and TSML-UI.</p>
    <a href="/auth/redirect" class="bg-blue-500 text-white px-5 py-2 mt-5 rounded-sm">Sign in with Google</a>
</div>

@endsection