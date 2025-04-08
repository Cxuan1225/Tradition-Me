<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'TraditionMe')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="icon" href="{{ asset('Logo-removebg.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('Logo-removebg.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('Logo-removebg.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('Logo-removebg.png') }}">
    <link rel="stylesheet" href="{{ asset('enduser/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('enduser/style.css') }}">
    <script src="https://kit.fontawesome.com/3ca8b804f1.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">
    {{-- Swiper.js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <!-- script -->
    <script src="{{ asset('enduser/js/modernizr.js') }}"></script>
    @livewireStyles
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true"
    tabindex="0">
    @php
        $layout = Session::get('view_layout', 'layouts.end_user.app');
    @endphp
    @include('layouts/end_user/svg')
    @include('layouts/end_user/navbar')
    @yield('content')
    @yield('scripts')
    @include('layouts/end_user/footer')
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('enduser/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('enduser/js/plugins.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    @livewireScripts
    @livewireChartsScripts
</body>

</html>
