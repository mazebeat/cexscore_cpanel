@extends('layouts.cpanel')

@section('title')
	Todas las Ciudades
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todas las Ciudades
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Ciudades</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.ciudads.create', 'Agregar Nueva Ciudad', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($ciudads->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				{{--<th>Región</th>--}}
				<th>Descripción Ciudad</th>
				<th>&nbsp;</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($ciudads as $ciudad)
				<tr>
					{{--					<td>{{{ $ciudad->id_region }}}</td>--}}
					<td>{{{ $ciudad->descripcion_ciudad }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.ciudads.destroy', $ciudad->id_ciudad))) }}
						{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('admin.ciudads.edit', 'Editar', array($ciudad->id_ciudad), array('class' => 'btn btn-info')) }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado ciudads.
	@endif
@endsection
