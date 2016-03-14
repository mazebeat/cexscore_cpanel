@extends('pdf.generador.template')

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
            <div class="col-xs-4">@include("pdf.generador.tarjeta_side")</div>
            <div class="col-xs-4">@include("pdf.generador.tarjeta_side")</div>
            <div class="col-xs-4">@include("pdf.generador.tarjeta_side")</div>
            <div class="col-xs-4">@include("pdf.generador.tarjeta_side")</div>
        </div>
        <div class="row">
            <div class="col-xs-4">@include("pdf.generador.tarjeta_side")</div>
            <div class="col-xs-4">@include("pdf.generador.tarjeta_side")</div>
            <div class="col-xs-4">@include("pdf.generador.tarjeta_side")</div>
            <div class="col-xs-4">@include("pdf.generador.tarjeta_side")</div>
        </div>
    </div>
@endsection