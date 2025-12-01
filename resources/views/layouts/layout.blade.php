<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title')</title>
    <!--Bootstrap stylesheet-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icon stylesheet-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }

        .card-registration .select-arrow {
            top: 13px;
        }

        .gradient-custom {
            /* fallback for old browsers */
            background: #CEF3ED;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to bottom right, #CEF3ED, #DEF7F3);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to bottom right, #CEF3ED, #DEF7F3);
        }

        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }

        .card-registration .select-arrow {
            top: 13px;
        }

        .scale-animate {
            transition: transform 0.3s ease-in-out;
        }

        .scale-animate:hover {
            transform: scale(1.03);
        }

        .hand-pointer:hover {
            cursor: pointer
        }

        .info-box {
            position: relative;
            overflow: hidden;
            color: #fff;
            border-radius: .5rem;
            padding: 30px;
            margin-bottom: 30px;
            height: 100%;
            background-color: #5B9279;
        }

        .info-box .icon {
            position: absolute;
            top: 50%;
            right: 20px;
            font-size: 60px;
            opacity: 0.2;
            transform: translateY(-50%)
        }

        .info-box a {
            color: #fff;
            text-decoration: underline;
        }

        .autocomplete-wrapper {
            position: relative;
        }

        .autocomplete-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 2000;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        .autocomplete-item.active {
            background: #f1f1f1;
        }

        .autocomplete-item {
            cursor: pointer;
        }

        .autocomplete-list.show {
            display: block;
        }

        .rao-office-item {
            text-decoration: none;
            cursor: pointer;
        }

        .rao-office-item:hover {
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body style="background-color: #FDF0D5">
    @include('partials.header') <!--Add header file-->

    <section>@yield('content')</section>

    <!--Add sectional content dynamic for each page file-->
    @include('partials.footer') <!--Add footer file-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="{{ asset('helper.js') }}"></script>
</body>

</html>
