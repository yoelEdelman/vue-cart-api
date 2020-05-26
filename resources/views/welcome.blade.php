<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel E-commerce API</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        @if (env('APP_ENV') === 'local')
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @else
            <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        @endif
    </head>
    <body>
        <div id="app">
            <Index></Index>
        </div>
        @if (env('APP_ENV') === 'local')
            <script src="{{ asset('js/app.js') }}"></script>
        @else
            <script src="{{ secure_asset('js/app.js') }}"></script>
        @endif

    </body>
</html>
