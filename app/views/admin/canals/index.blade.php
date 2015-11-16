@extends('layouts.cpanel')

@section('title')
	Todos Canales
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Canales
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Canales</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.canals.create', 'Agregar Nuevo Canal', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($canals->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>Descripción Canal</th>
				<th>Código Canal</th>
				<th>&nbsp;</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($canals as $canal)
				<tr>
					<td>{{{ $canal->descripcion_canal }}}</td>
					<td>{{{ $canal->codigo_canal }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.canals.destroy', $canal->id_canal))) }}
						{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('admin.canals.edit', 'Editar', array($canal->id_canal), array('class' => 'btn btn-info')) }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado canals.
	@endif
@endsection
