<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Icons -->
    <!-- link rel="icon" href="/images/favicon.ico" type="image/x-icon" -->
    <!-- link rel="apple-touch-icon" href="/images/app_icon.png" / -->
    <!-- link rel="apple-touch-icon-precomposed" href="/images/app_icon.png" / -->
    <!-- link rel="shortcut icon" sizes="128x128" href="/images/favicon.ico"->
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/frontend/app.css') }}">

</head>
<body >
    <div id="app">
        <app />
    </div>

    <script src="{{ asset('js/frontend/app.js') }}"></script>
</body>
</html>
