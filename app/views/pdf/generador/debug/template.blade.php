<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="pdf">
        <meta name="author" content="mazebeat">
        <title>@yield('title')</title>

        <link href="{{ public_path('css/bootstrap.css') }}" rel="stylesheet">
        {{--<link href="{{ url('css/bootstrap.css') }}" rel="stylesheet">--}}

        <style type="text/css">
            body{
                font-family: Arial, sans-serif;
            }

            html, body {
                height: 100%;
                /*zoom: 90%;*/
                /*zoom:0.78124;*/
            }

            .wrapper {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                margin: 0 auto -142px;
            }

            footer {
                position: fixed;
                bottom: 50px;
                width: 100%;
            }

            .borderless tr td {
                border: none !important;
                padding: 0px !important;
            }
        </style>
        @yield('style')
    </head>

    <body style="border:0; margin: 0;">
    <div id="wrap">
        <div class="container">
            @yield('content')
        </div>
        <div class="clearfix"></div>
    </div>

    </body>
</html>
