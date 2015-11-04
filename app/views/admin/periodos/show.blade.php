@extends('layouts.cpanel')

@section('title')
	Ver Periodo
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Periodo
@endsection

@section('breadcrumb')
	@parent
	<li>Periodos</li>
	<li class="active">Ver</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.periodos.index', 'Volver a periodos', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th>Periodo</th>
			<th>Meta</th>
			<th>Mes</th>
			<th>Año</th>
			<th>Cliente</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>{{{ $periodo->periodo }}}</td>
			<td>{{{ $periodo->meta }}}</td>
			<td>{{{ $periodo->mes }}}</td>
			<td>{{{ $periodo->anio }}}</td>
			<td>{{{ Cliente::find($periodo->id_cliente)->nombre_cliente }}}</td>
			<td>
				{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.periodos.destroy', $periodo->id_periodo))) }}
				{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
				{{ link_to_route('admin.periodos.edit', 'Editar', array($periodo->id_periodo), array('class' => 'btn btn-info')) }}
			</td>
		</tr>
		</tbody>
	</table>
@endsection