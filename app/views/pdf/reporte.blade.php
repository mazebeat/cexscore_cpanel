@extends('pdf.pdf')

@section('title')
	[title]
@endsection

@section('content')
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<h2 class="text-center" style="background-color: #3366FF; color: #ffffff; padding: 10px;">Actualización Semanal CExScore by CustomerTrigger</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<p>Cuenta: <strong>{{{ $account or 'TRIAL'  }}}</strong><br> {{{ $date_range or 'Semana del 17 al 23 de agosto 2015' }}}</p>
		</div>
		<div class="col-xs-12">
			<h4>Por Semana</h4>
		</div>
		<div class="col-xs-10 col-xs-offset-1">
			{{ HTML::reportTable('week') }}
			<table class="table">
				<thead>
				<tr>
					<th class="col-xs-6"></th>
					<th class="col-xs-2">Última Semana</th>
					<th class="col-xs-2">Semana Anterior</th>
					<th class="col-xs-2">Tendencia</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>Visitas al sistema de respuesta</td>
					<td>14</td>
					<td>21</td>
					<td>-50%</td>
				</tr>
				<tr>
					<td>Respuestas efectivas</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Tasa de respuesta</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Promotores %</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Detractores %</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-weight: bold">
					<td>NPS</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Lealtad</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<p>Puede visualizar las estadísticas y tendencias generales en Panel CExScore (link)</p>
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
			<a href="http://customertrigger.com/" target="_blank">CustomerTrigger S.A.</a>{{{ Carbon::now()->year }}}<br> Direcci&oacute;n Comercial: Fanor Velasco No.85, Piso 9, Santiago | Direcci&oacute;n Legal: Sotero Del R&iacute;o 508, Oficina 826, Santiago<br>
			<abbr title="Tel&eacute;fono">T:</abbr> <a href="tel:+56222198993">+562 22 198 993</a> | <a href="http://customertrigger.com/" target="_blank">http://www.customertrigger.com</a> |
			<a href="mailto:ayuda@customertrigger.com">ayuda@customertrigger.com</a>
		</address>
		</p>
	</footer>
@endsection

@section('script')
@endsection