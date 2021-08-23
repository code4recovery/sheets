@extends('page')

@section('page')

    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                {{ $feed->name }}
            </h1>
            <a href="{{ route('feeds.edit', $feed->slug) }}"
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit Feed
            </a>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-8 pt-8">

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

            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Website
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="{{ $feed->website }}" target="_blank"
                            class="text-indigo-500 underline hover:text-indigo-900">
                            {{ $feed->website }}
                        </a>
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Resources
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="{{ 'https://docs.google.com/spreadsheets/d/' . $feed->spreadsheet_id . '/edit#gid=' . $feed->sheet_id }}"
                            target="_blank" class="text-indigo-500 underline hover:text-indigo-900">Sheet</a>
                        • 
                        <a href="{{ $feed_url }}" target="_blank"
                            class="text-indigo-500 underline hover:text-indigo-900">Feed</a>
                        • 
                        <a href="{{ 'https://pdf.code4recovery.org/?json=' . $feed_url }}" target="_blank"
                            class="text-indigo-500 underline hover:text-indigo-900">PDF</a>
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Default Timezone
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $feed->timezone }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Meetings
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ number_format($feed->meetings) }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Last Refresh
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $feed->refreshed_at->diffForHumans() }}
                        •
                        <a href="{{ route('feeds.refresh', $feed->slug) }}"
                            class="text-indigo-500 underline hover:text-indigo-900">refresh now
                        </a>
                    </dd>
                </div>
                <div class="sm:col-span-1">

                </div>
                <div class=" sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">
                        TSML UI Embed Code
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {!! Form::textarea('sample', $embed_code, [
    'class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md font-mono bg-gray-100',
    'rows' => 5,
]) !!}
                    </dd>
                </div>
            </dl>

        </div>
    </main>

@endsection
