@extends('pdf.pdf')

@section('content')
	<div class="row">
		<div class="col-xs-12">
			<h1 class="text-center">Actualización Semanal CExScore by CustomerTrigger</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<p>Cuenta: {{{ $name or 'Default' }}}<br> Semana del {{{ $desde or '17' }}} al {{{ $hasta or '23' }}} de agosto 2015</p>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12">
			<h3>Por Semana</h3>

			<table class="table borderless">
				<thead>
				<th>
				<td></td>
				<td>Última Semana</td>
				<td>Semana Anterior</td>
				<td>Tendencia</td>
				</th>
				</thead>
				<tbody>
				<tr>
					<td>Visitas al sistema de respuesta</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Respuestas efectivas</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Tasa de respuesta
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Promotores %
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Detractores %
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-weight: bold">
					<td>NPS
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Lealtad
					</td>
					<td></td>
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
			<h3>Por Mes</h3>

			<h3>Por Semana</h3>

			<table class="table borderless">
				<thead>
				<th>
				<td></td>
				<td>Último mes (acum)</td>
				<td>Mes Anterior</td>
				<td>Tendencia</td>
				</th>
				</thead>
				<tbody>
				<tr>
					<td>Visitas al sistema de respuesta</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Respuestas efectivas</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Tasa de respuesta
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Promotores %
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Detractores %
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr style="font-weight: bold">
					<td>NPS
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Lealtad
					</td>
					<td></td>
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
	<div class="row">

	</div>
@endsection