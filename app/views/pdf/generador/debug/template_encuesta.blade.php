<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"/>
        <title>@yield('title')</title>

        {{--LATEST COMPILED AND MINIFIED CSS--}}
        {{--<link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet">--}}
        <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">

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

                {{HTML::script('//code.jquery.com/jquery-1.11.0.min.js') }}
                {{-- HTML::script('//code.jquery.com/ui/1.11.0/jquery-ui.min.js  ') --}}
                {{--<script src="{{ public_path('js/bootstrap.min.js') }}"></script>--}}
                {{--<script src="{{ public_path('plugins/formvalidation/js/formValidation.min.js') }}"></script>
                <script src="{{ public_path('plugins/formvalidation/js/framework/bootstrap.min.js') }}"></script>--}}
                {{--<script src="{{ public_path('js/icheck.min.js') }}"></script>--}}
                <script src="{{ url('js/icheck.min.js') }}"></script>
                {{--<script src="{{ public_path('js/select2.min.js') }}"></script>--}}
                {{--<script src="{{ public_path('js/select2_locale_es.js') }}"></script>--}}
                {{--<script src="{{ public_path('js/jquery.rut.min.js') }}"></script>--}}
                {{--<script src="{{ public_path('js/frontend.js') }}"></script>--}}

        @yield('script')
        <a href="#" id="go-top" role="button" title="Click para ir al comienzo!" data-toggle="tooltip" data-placement="left"><i class="fa fa-chevron-circle-up fa-3x"></i></a>
    </body>
</html>