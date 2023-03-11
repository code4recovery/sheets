<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script>
        function setColorMode(dark) {
            document.documentElement.setAttribute('data-bs-theme', dark ? 'dark' : 'light');
        }
        setColorMode(window.matchMedia("(prefers-color-scheme: dark)").matches);
        window
            .matchMedia("(prefers-color-scheme: dark)")
            .addEventListener("change", function(e) {
                setColorMode(e.matches);
            });
    </script>
    <title>{{ env('APP_NAME') }}</title>
</head>

<body>
    <main class="container my-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                @yield('content')

            </div>
        </div>
    </main>
</body>

</html>
