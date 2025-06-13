<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cargo Pulse — биржа грузоперевозок онлайн</title>
        <meta name="description" content="Cargo Pulse — удобное веб-приложение для быстрого подбора грузов и транспорта. Экономьте время и деньги на перевозках!" />
        <link rel="icon" href="/favicon.ico" sizes="any">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @routes
        @vite(['resources/js/app.js', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>
