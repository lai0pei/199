<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="max-w-screen-sm m-auto">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', '开元199') }}</title>
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>

    </head>
    <body class="font-sans antialiased h-full bg-bgImg bg-fixed">
        @inertia
    </body>
</html>
<style>
body{
    scrollbar-width: none;
}
body::-webkit-scrollbar {
  display: none; /* for Chrome, Safari, and Opera */
}

</style>
