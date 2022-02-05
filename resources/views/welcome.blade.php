@extends('template')

@section('content')

    <h1>{{ env('APP_NAME') }}</h1>

    <p class="lead">
        Use this service to convert a Google Sheet to a Meeting Guide JSON feed for use in the
        <a href="https://www.aa.org/meeting-guide-app" target="_blank">
            Meeting Guide app
        </a>
        and/or <a href="https://tsml-ui.code4recovery.org" target="_blank">TSML UI</a>.
    </p>

    <form method="post" action="/" class="d-flex flex-column">
        @csrf
        <label class="form-label fw-bold" for="sheetUrl">Google Sheet URL</label>
        <input type="url" name="sheetUrl" id="sheetUrl" class="form-control"
            placeholder="https://docs.google.com/spreadsheets/d/12Ab34Cd56Ef…" required>
        <div class="text-center my-3">
            <button type="submit" class="btn btn-primary btn-lg px-4">Import</button>
        </div>
    </form>

    <p class="mt-5">
        Need a place to start? Duplicate <a
            href="https://docs.google.com/spreadsheets/d/12Ga8uwMG4WJ8pZ_SEU7vNETp_aQZ-2yNVsYDFqIwHyE/edit#gid=0">this
            Google Sheet</a> that is the data source for <a href="https://aasanjose.org/meetings">AA San Jose's
            meeting list</a>.
    </p>

    <p class="mb-4">
        More information is available on the
        <a href="https://github.com/code4recovery/sheets" target="_blank">
            project page on Github</a>. To get help, please
        <a href="https://github.com/code4recovery/sheets/issues" target="_blank">file an issue</a>.
    </p>

    <p class="text-center">
        <a href="https://code4recovery.org" target="_blank">
            <img src="/logo.svg" width="100" height="100" alt="Code for Recovery" />
        </a>
    </p>

@endsection
