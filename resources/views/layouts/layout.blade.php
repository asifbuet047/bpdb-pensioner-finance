<!DOCTYPE html>
<html lang="en">

<head>
    @viteReactRefresh
    @vite('resources/js/app.jsx')
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title')</title>
    <!--Bootstrap stylesheet-->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- Bootstrap icon stylesheet-->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> --}}

</head>

<body style="background-color: #FDF0D5">

    @include('partials.header') <!--Add header file-->


    <section>@yield('content')</section>

    <!--Add sectional content dynamic for each page file-->
    @include('partials.footer') <!--Add footer file-->

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>

</html>
