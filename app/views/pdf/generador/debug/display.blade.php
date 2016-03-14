@extends('pdf.generador.debug.template')

@section('title')
    Display de presentaci&oacute;n
@endsection

@section('style')
    <style>
        /*html, body {
            height: 100%;
            zoom: 90%;
        }*/
        div.container.display > div.row > div.col-xs-6{
            width: 588px;
            height: 931px;
            padding:25px;
            /*border: 1px solid #ccc;*/
            /*margin-right: 25px;*/
        }
    </style>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        function init() {
        }
    </script>
@endsection

@section('content')
    <div class="container display">
        <div class="row">
            <div class="col-xs-6">
                @include("pdf.generador.debug.display_side")
            </div>

            <div class="col-xs-6">
                @include("pdf.generador.debug.display_side")
            </div>
            {{--<div class="col-xs-12 col-md-12">
                @include("pdf.generador.debug.display_side")
            </div>--}}
        </div>
    </div>
@endsection