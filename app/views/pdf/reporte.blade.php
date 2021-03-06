@extends('pdf.pdf')

@section('title')
    Reporte Semanal
@endsection

@section('style')
    <style>
        .tendence {
            color: green;
        }

        .tendence.neg {
            color: red;
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
    <div class="row">
        <div class="col-xs-12">
            <h3 class="text-left"><img class="text-left" src="{{ public_path('image/customertrigger/logocustomer.png') }}"/> Actualización Semanal CExScore by CustomerTrigger</h3>
        </div>
    </div>
    <br></br>
    <div class="row">
        <div class="col-xs-12">
            <p>Cuenta: <strong>{{ strtoupper($account->nombre_cliente) }}</strong></p>

            <p>{{ $dateRange  }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-right" id="WeekTitle">
            <h3 class="text-left">Por Semana</h3>
        </div>
        <div class="col-xs-12" id="WeekReport">
            {{ HTML::reportTable($account, 'week') }}
        </div>
        <div class="col-xs-12 text-right" id="MonthTitle">
            <h3 class="text-left">Por Mes</h3>
        </div>
        <div class="col-xs-12" id="MonthReport">
            {{ HTML::reportTable($account, 'month') }}
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <p>Puede visualizar las estadísticas y tendencias generales en <a href="http://www.cex.org:8080/CExScore">&nbsp;Panel CustomerExperience Score</a></p>
        </div>
    </div>
@endsection

@section('footer')
    <footer class="row" style="font-size: small;">
        <p class="text-center">
        <address class="text-center">
            <a href="http://www.customertrigger.com/termino-de-uso-politicas-de-privacidad-customerexperience-score/" target="_blank">T&eacute;rminos de Uso</a> |
            <a href="http://www.customertrigger.com/termino-de-uso-politicas-de-privacidad-customerexperience-score/" target="_blank">Pol&iacute;tica de Privacidad</a> |
            <a href="http://www.customertrigger.com/customer-experience-score/" target="_blank">Nuestra Soluci&oacute;n</a> |
            <a href="http://www.customertrigger.com/registro-zona-de-recursos/" target="_blank">Zona de Recursos</a> <br> Desarrollado por &copy;
            <a href="http://customertrigger.com/" target="_blank">CustomerTrigger S.A.</a>&nbsp;{{ Carbon::now()->year }}<br> Direcci&oacute;n Comercial: Fanor Velasco No.85, Piso 9, Santiago |
            Direcci&oacute;n Legal: Sotero Del R&iacute;o 508, Oficina 826, Santiago<br>
            <abbr title="Tel&eacute;fono">T:</abbr> <a href="tel:+56222198993">+562 22 198 993</a> | <a href="http://customertrigger.com/" target="_blank">http://www.customertrigger.com</a> |
            <a href="mailto:ayuda@customertrigger.com">ayuda@customertrigger.com</a>
        </address>
        </p>
    </footer>
@endsection
