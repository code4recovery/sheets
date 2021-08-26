@extends('page')

@section('page')

    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                My Feeds
            </h1>
            <a href="{{ route('feeds.create') }}"
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create Feed
            </a>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 grid gap-8">

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

            @if ($user->feeds->isEmpty())
                <div class="bg-gray-50 border px-6 py-12 text-lg text-center rounded">
                    No feeds yet. Get started by creating one.
                </div>
            @else
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Website
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Meetings
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Refreshed
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Refresh</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($user->feeds as $feed)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('feeds.show', $feed->slug) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            {{ $feed->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium hidden sm:table-cell">
                                        <a href="{{ $feed->website }}" target="_blank"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            {{ $feed->website }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                                        {{ number_format($feed->meetings) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                                        {{ $feed->refreshed_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('feeds.refresh', $feed->slug) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Refresh</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

@endsection
