@extends('template')

@section('content')
    <h1>
        Feed Refreshed ✅
    </h1>

    <pre class="rounded bg-dark text-light p-3 mt-3 mb-4 overflow-scroll">{{ $feedUrl }}</pre>

    <p><a href="{{ $feedUrl }}" target="_blank"
            class="btn btn-outline-primary d-inline-flex align-items-center gap-2 justify-content-start">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                <path fill-rule="evenodd"
                    d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
            </svg>
            Open in new tab
        </a></p>

    <p>You can bookmark this page so you don't need to fill out the form every time.</p>

    @if ($errors)
        <div class="mb-3">
            <p>Note: the importer encountered {{ count($errors) }} unexpected values:</p>
            @foreach ($errors as $error)
                <p class="m-0">In row {{ $error['index'] }}, {{ $error['error'] }}
                    <code>{{ implode(', ', $error['value']) }}</code>
                </p>
            @endforeach
        </div>
    @endif

    <p>You can be redirected after refreshing by passing a <code>redirectTo</code> parameter to this URL.</p>

    <p>Feeds that are not refreshed within 30 days will be removed automatically.</p>
@endsection
