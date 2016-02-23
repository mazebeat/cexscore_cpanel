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
            <div class="col-xs-12">
                <img src="{{public_path($apariencia['logo_header'])}}" alt="Logo" style="max-height: 90px;">
                <h4>CONOCER TU EXPERIENCIA ES PARTE DE NUESTRO NEGOCIO</h4>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-xs-12">
                <p>Ingresa con tu celular al código QR o a la página<br/>
                    <a href="{{url($url['given'])}}" style="font-size:20pt;">{{url($url['given'])}}</a> <br/>
                    y contesta nuestra encuesta de 4 preguntas</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-xs-12">
                <img src="{{public_path($URLrutaQR)}}" alt="Codigo QR" style="width: 180px;">
            </div>
        </div>
    </div>
@endsection