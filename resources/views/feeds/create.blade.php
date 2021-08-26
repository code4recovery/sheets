@extends('page')

@section('page')

    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Create Feed
            </h1>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid gap-8 pt-8">

            @if (session('error'))
                <div class="bg-red-100 text-red-800 rounded p-4 shadow">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 text-green-800 rounded p-4 shadow">
                    {{ session('success') }}
                </div>
            @endif

            {!! Form::open(['route' => 'feeds.store']) !!}

            <div class="grid gap-5 grid-cols-2">
                <div class="sm:col-span-1 grid gap-1 content-start">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Feed name
                    </label>
                    {!! Form::text('name', old('name'), [
    'id' => 'name',
    'autocomplete' => 'off',
    'placeholder' => 'e.g. Area 24 District 07 Des Moines, IA',
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md',
]) !!}
                </div>

                <div class="sm:col-span-1 grid gap-1 content-start">
                    <label for="website" class="block text-sm font-medium text-gray-700">
                        Website URL
                    </label>
                    {!! Form::url('website', old('website'), [
    'id' => 'website',
    'autocomplete' => 'off',
    'placeholder' => 'e.g. https://aadesmoines.org',
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md',
]) !!}
                </div>

                <div class="grid gap-1 col-span-2">
                    <label for="sheet" class="block text-sm font-medium text-gray-700">
                        Sheet URL
                    </label>

                    {!! Form::url('sheet', old('sheet'), [
    'id' => 'sheet',
    'autocomplete' => 'off',
    'placeholder' => 'e.g. https://docs.google.com/spreadsheets/d/12Ga8uwMG4WJ8pZ_SEU7vNETp_aQZ-2yNVsYDFqIwHyE/edit#gid=0',
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md',
]) !!}

                    <div class="text-sm text-gray-400">
                        The URL you see when you're editing the sheet.
                    </div>
                </div>

                <div class="sm:col-span-1 grid gap-1 content-start">
                    <label for="timezone" class="block text-sm font-medium text-gray-700">
                        Default Timezone
                    </label>
                    {!! Form::select('timezone', ['' => ''] + $timezones, old('timezone'), [
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md',
    'id' => 'timezone',
]) !!}
                    <div class="text-sm text-gray-400">
                        Use this timezone when not specified in the data.
                    </div>
                </div>

                <div class="sm:col-span-1 grid gap-1 content-start">
                    <label for="mapbox" class="block text-sm font-medium text-gray-700">
                        Mapbox Access Token
                    </label>
                    {!! Form::text('mapbox', old('mapbox'), [
    'id' => 'mapbox',
    'autocomplete' => 'off',
    'placeholder' => 'e.g. pk.aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ',
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md',
]) !!}
                    <p class="text-sm text-gray-400">
                        Get a free one at <a href="https://mapbox.com" target="blank"
                            class="text-indigo-500 underline hover:text-indigo-800">
                            mapbox.com</a>.
                    </p>
                </div>

            </div>

            <div class="flex justify-end pt-8">
                <a href="{{ route('feeds.index') }}"
                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>

            {!! Form::close() !!}

        </div>
    </main>

@endsection
