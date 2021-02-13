<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather app</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0" defer></script>
    <script src="/js/app.js" defer></script>
</head>

<body class="bg-blue-200">
    <div id="app" class="flex justify-center pt-16">
        <weather-app></weather-app>
    </div>
</body>

</html>