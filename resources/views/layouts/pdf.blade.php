<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{isset($title) ? $title . ' | ' : '' }}{{ config('app.name') }}</title>

        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@800&amp;family=Inter:wght@400;600&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="msapplication-TileColor" content="#d82827">
        <meta name="theme-color" content="#ffffff">
    </head>

<body class="bg-gray-50">

<div class="container mx-auto p-16">
    {{ $slot }}
</div>

</body>
</html>
