@extends('template')

@section('content')

    <div class="flex min-h-screen bg-gray-100 items-center flex-col gap-2 justify-center">
        <div class="max-w-md mx-auto my-5 grid gap-5 justify-items-center bg-white p-8 border rounded-sm">
            <img src="/logo.png" width="400" height="400" class="block w-16 h-16">
            <h1 class="font-bold text-xl">Google Sheet Importer</h1>
            <div class="grid gap-3">
                <p class="text-center">
                    Great! Your feed has been refreshed at:
                </p>
                <input type="url" value="{{ $feedUrl }}" class="rounded">
            </div>
            <p>You can be redirected after refreshing by passing a <code>redirectTo</code> parameter to this URL.
        </div>
    </div>

@endsection
