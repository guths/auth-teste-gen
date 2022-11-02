<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        
    </head>
    <body class="antialiased">
        <div id="app"></div>

        @vite(["resources/css/app.css",
                "resources/css/bootstrap.min.css",
                "resources/scss/app.scss",
                "resources/js/app.js",
                "resources/js/bootstrap.min.js"])
    </body>
</html>
