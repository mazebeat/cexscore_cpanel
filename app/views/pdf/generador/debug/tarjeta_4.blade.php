@extends('pdf.generador.debug.template')

@section('title')
    Tarjeta de presentaci&oacute;n
@endsection

@section('style')
    <style>
        div.container.tarjeta > div.row > div.col-xs-4{
            width: 295px;
            height: 466px;
            padding:25px;
            border: 1px solid black;
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
    <div class="container tarjeta">
        <div class="row">
            <div class="col-xs-4">@include("pdf.generador.debug.tarjeta")</div>
            <div class="col-xs-4">@include("pdf.generador.debug.tarjeta")</div>
            <div class="col-xs-4">@include("pdf.generador.debug.tarjeta")</div>
            <div class="col-xs-4">@include("pdf.generador.debug.tarjeta")</div>
        </div>
        <div class="row">
            <div class="col-xs-4">@include("pdf.generador.debug.tarjeta")</div>
            <div class="col-xs-4">@include("pdf.generador.debug.tarjeta")</div>
            <div class="col-xs-4">@include("pdf.generador.debug.tarjeta")</div>
            <div class="col-xs-4">@include("pdf.generador.debug.tarjeta")</div>
        </div>
        {{--<div class="row">
            <div class="col-xs-6" style="width: 6cm;height: 9.5cm; margin-right: 5cm;margin-bottom:10cm;border: 1px solid black;">
                @include("pdf.generador.debug.tarjeta")
            </div>
            <div class="col-xs-6" style="width: 295px;height: 466px;padding:25px;border: 1px solid black;">
                @include("pdf.generador.debug.tarjeta")
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6" style="width: 170px;height: 269px;">
                @include("pdf.generador.debug.tarjeta")
            </div>
            <div class="col-xs-6" style="width: 170px;height: 269px;" >
                @include("pdf.generador.debug.tarjeta")
            </div>
        </div>--}}
    </div>
@endsection