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
		<div class="col-xs-10 col-xs-offset-1">
			<h2 class="text-center" style="background-color: #3366FF; color: #ffffff; padding: 10px;">Actualización Semanal CExScore by CustomerTrigger</h2>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-xs-12">
			<p>Cuenta: <strong>{{{ strtoupper($account->nombre_cliente) }}}</strong></p>

			<p>{{{ $dateRange  }}}</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 text-center">
			<h3>Por Semana</h3>
		</div>
		<div class="col-xs-12">
			{{ HTML::reportTable($account, 'week') }}
		</div>
		<div class="col-xs-12 text-center">
			<h3>Por Mes</h3>
		</div>
		<div class="col-xs-12">
			{{ HTML::reportTable($account, 'month') }}
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<p>Puede visualizar las estadísticas y tendencias generales en <a href="#">Panel CExScore</a></p>
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
			<a href="http://customertrigger.com/" target="_blank">CustomerTrigger S.A.</a> {{{ Carbon::now()->year }}}<br> Direcci&oacute;n Comercial: Fanor Velasco No.85, Piso 9, Santiago | Direcci&oacute;n Legal: Sotero Del R&iacute;o 508, Oficina 826, Santiago<br>
			<abbr title="Tel&eacute;fono">T:</abbr> <a href="tel:+56222198993">+562 22 198 993</a> | <a href="http://customertrigger.com/" target="_blank">http://www.customertrigger.com</a> |
			<a href="mailto:ayuda@customertrigger.com">ayuda@customertrigger.com</a>
		</address>
		</p>
	</footer>
@endsection