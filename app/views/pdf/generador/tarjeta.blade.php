@extends('pdf.generador.template')

@section('title')
    Tarjeta de presentaci&oacute;n
@endsection

@section('style')

@endsection

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        function init() {
        }
    </script>
@endsection

@section('content')
    <div class="">
        <div class="row text-center">
            {{--<img src="{{url($apariencia['logo_header'])}}" alt="Logo" style="width: 150px;">--}}
            <img src="{{public_path($apariencia['logo_header'])}}" alt="Logo" style="max-height: 90px;">
            <h4>
                CONOCER TU EXPERIENCIA ES PARTE DE NUESTRO NEGOCIO
            </h4>
        </div>

        <div class="row text-center">
            Ingresa con tu celular al código QR o a la página<br />

            <a href="{{url($url['given'])}}" style="font-size:20pt;">{{url($url['given'])}}</a> <br />

            y contesta nuestra encuesta de 4 preguntas
        </div>
        <div class="row">

            <div class="col-xs-12 text-center">
                {{--<img src="{{url($URLrutaQR)}}" alt="Codigo QR" style="width: 150px;">--}}
                <img src="{{public_path($URLrutaQR)}}" alt="Codigo QR" style="width: 180px;">
            </div>
        </div>
    </div>
@endsection