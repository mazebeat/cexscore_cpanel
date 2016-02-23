<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>@yield('title')</title>

    <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet">

    @yield('style')
</head>
<body style="background-color: #fff!important;">
<header class="container user" style="background-color:inherit;">
    @yield('header')
</header>
<main class="container user">
    @yield('content')
</main>
<footer class="container user">
    @yield('footer')
</footer>

{{HTML::script('https://code.jquery.com/jquery-1.11.0.min.js') }}
<script src="{{ public_path('js/icheck.min.js') }}"></script>

@yield('script')
</body>
</html>