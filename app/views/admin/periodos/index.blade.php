@extends('layouts.cpanel')

@section('title')
	Periodos
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Periodos
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Periodos</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.periodos.create', 'Agregar Nuevo Periodo', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($periodos->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>Periodo</th>
				<th>Meta</th>
				<th>Mes</th>
				<th>Año</th>
				<th>Cliente</th>
				<th>&nbsp;</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($periodos as $periodo)
				<tr>
					<td>{{ $periodo->periodo }}</td>
					<td>{{ $periodo->meta }}</td>
					<td>{{ $periodo->mes }}</td>
					<td>{{ $periodo->anio }}</td>
					<td>{{ isset(Cliente::find($periodo->id_cliente)->nombre_cliente) ? Cliente::find($periodo->id_cliente)->nombre_cliente : '' }}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.periodos.destroy', $periodo->id_periodo))) }}
						{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('admin.periodos.edit', 'Editar', array($periodo->id_periodo), array('class' => 'btn btn-info')) }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		{{ $periodos->links() }}
	@else
		No se han encontrado periodos.
	@endif
@endsection
