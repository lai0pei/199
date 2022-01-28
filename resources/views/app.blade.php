<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class=" m-auto">
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
    <body class="font-sans antialiased h-full bg-bgImg">
        @inertia
    </body>
</html>
<style>
html{
 max-width: 38rem;
}
body{
    scrollbar-width: none;
    background : no-repeat;
    background-position: center top;
    background-color : rgb(26,27,32);
}
body::-webkit-scrollbar {
  display: none; /* for Chrome, Safari, and Opera */
}

</style>
