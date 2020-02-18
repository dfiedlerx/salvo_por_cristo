<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="https://kit.fontawesome.com/554cc3467f.js" crossorigin="anonymous"></script>
        <title>Somente as Escrituras</title>
    </head>
    <body>
        <div id="app">
            <playlist></playlist>
        </div>
    </body>
    <script src="js/app.js"></script>
</html>
