@extends('pdf.generador.template')

@section('title')
    Tarjeta de presentaci&oacute;n
@endsection

@section('style')
    <style>
        h3 {
            font-size: 28px;
        }
    </style>
@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
@endsection

@section('content')
    <div>
        <div class="row">
            {{--<div class="col-xs-6 col-md-6">--}}
                {{--@include("pdf.generador.display_side")--}}
            {{--</div>--}}
            {{--<div class="col-xs-6 col-md-6 ">--}}
                {{--@include("pdf.generador.display_side")--}}
            {{--</div>--}}

            <div class="col-xs-12 col-md-12">
            @include("pdf.generador.display_side")
            </div>
        </div>
    </div>
@endsection