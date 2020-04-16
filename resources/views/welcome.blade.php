<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://rawgithub.com/darkskyapp/skycons/master/skycons.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.18.1" defer></script>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>Weather App</title>
</head>
<body class="bg-blue-200 flex justify-center pt-16">
    <div id="app">
        <weather-app></weather-app>
    </div>
</body>
</html>
