@extends('template')

@section('content')

    <div class="flex min-h-screen bg-gray-100 items-center flex-col gap-2 justify-center">
        <div class="max-w-md mx-auto my-5 grid gap-5 justify-items-center bg-white p-8 border rounded-sm">
            <img src="/logo.png" width="400" height="400" class="block w-16 h-16">
            <h1 class="font-bold text-xl">Google Sheet Importer</h1>
            <p class="text-center">Use this service to convert a Google Sheet to a Meeting Guide JSON feed for use in the
                <a href="https://www.aa.org/meeting-guide-app" class="text-blue-700 underline" target="_blank">Meeting Guide
                    app</a> and/or <a href="https://tsml-ui.code4recovery.org" class="text-blue-700 underline"
                    target="_blank">TSML UI</a>.
            </p>
            <form method="post" class="grid gap-1" action="/">
                @csrf
                <label for="sheetUrl">Google Sheet URL</label>
                <div class="flex">
                    <input type="url" name="sheetUrl" id="sheetUrl" class="p-3 rounded-l border-gray-500" required>
                    <button type="submit" class="bg-blue-500 border-blue-700 text-white rounded-r p-3">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
