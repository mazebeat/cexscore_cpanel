@extends('layouts.cpanel')

@section('title')
	Todos Periodos
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Periodos
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
					<th>Id_periodo</th>
				<th>Periodo</th>
				<th>Meta</th>
				<th>Mes</th>
				<th>Anio</th>
				<th>Id_cliente</th>
					<th>&nbsp;</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($periodos as $periodo)
					<tr>
						<td>{{{ $periodo->id_periodo }}}</td>
					<td>{{{ $periodo->periodo }}}</td>
					<td>{{{ $periodo->meta }}}</td>
					<td>{{{ $periodo->mes }}}</td>
					<td>{{{ $periodo->anio }}}</td>
					<td>{{{ $periodo->id_cliente }}}</td>
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
	@else
		 No se han encontrado periodos.
	@endif
@endsection
