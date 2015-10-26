@extends('layouts.cpanel')

@section('title')
	Todos Momentos
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Momentos
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Momentos</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.momentos.create', 'Agregar Nuevo Momento', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($momentos->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>Descripción Momento</th>
				<th>&nbsp;</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($momentos as $momento)
				<tr>
					<td>{{{ $momento->descripcion_momento }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.momentos.destroy', $momento->id_momento))) }}
						{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('admin.momentos.edit', 'Editar', array($momento->id_momento), array('class' => 'btn btn-info')) }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado momentos.
	@endif
@endsection
