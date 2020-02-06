<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
        <title>Laravel</title>
    </head>
    <body>
        <div id="app">
            <audio-player></audio-player>
        </div>
    </body>
    <script src="js/app.js"></script>
</html>
