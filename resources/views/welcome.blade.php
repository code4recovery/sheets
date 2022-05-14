@extends('template')

@section('content')
    <h1>{{ env('APP_NAME') }}</h1>

    <p class="lead">
        Convert a Google Sheet to a JSON feed for use in the
        <a href="https://www.aa.org/meeting-guide-app" target="_blank">Meeting Guide app</a>
        and/or <a href="https://tsml-ui.code4recovery.org" target="_blank">TSML UI</a>.
    </p>

    @if (session('error'))
        <div class="alert alert-danger">
            @isset(session('error')['status'])
                @if (session('error')['status'] === 'PERMISSION_DENIED')
                    Set the sheet’s sharing settings to <code>Anyone with the link</code> &rarr;
                    <code>Viewer</code>
                @else
                    An error occured with the following status:
                    <code>{{ session('error')['status'] }}</code>
                @endif
            @else
                An error occured with the following message:
                <pre class="mt-1 mb-0">{{ print_r(session('error'), true) }}</pre>
            @endisset
        </div>
    @endif

    <form method="post" action="/" class="d-flex flex-column mb-5">
        @csrf
        <label class="form-label fw-bold" for="sheetUrl">Google Sheet URL</label>
        <input type="url" name="sheetUrl" id="sheetUrl" class="form-control" value="{{ session('sheetUrl') }}"
            placeholder="https://docs.google.com/spreadsheets/d/12Ab34Cd56Ef…" required>
        <div class="text-center my-3">
            <button type="submit" class="btn btn-primary btn-lg px-4">Import</button>
        </div>
    </form>

    <h2 class="h3">Not sure where to begin?</h2>
    <ol>
        <li>Open
            <a href="https://docs.google.com/spreadsheets/d/12Ga8uwMG4WJ8pZ_SEU7vNETp_aQZ-2yNVsYDFqIwHyE/edit#gid=0"
                target="_blank">San Jose's Google Sheet</a>.
        </li>
        <li>Sign into Google if you aren't already</li>
        <li>Make a copy at File > Make a copy</li>
        <li>Fill in your own data</li>
        <li>Set <code>Share</code> settings to <code>Anyone with the Link</code> &rarr; <code>Viewer</code></li>
        <li>Paste the new sheet’s URL into the form above</li>
    </ol>

    <p class="mb-4">
        More information is available on the
        <a href="https://github.com/code4recovery/sheets" target="_blank">project page on Github</a>. To get help, please
        <a href="https://github.com/code4recovery/sheets/issues" target="_blank">file an issue</a>.
    </p>

    <p class="text-center">
        <a href="https://code4recovery.org" target="_blank" class="d-inline-block">
            <img src="/logo.svg" width="100" height="100" alt="Code for Recovery" />
        </a>
    </p>
@endsection
