@extends('layouts.cpanel')

@section('title')
	Todos Momento Encuesta
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Momento Encuesta
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Momento Encuesta</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.momentoencuesta.create', 'Agregar Nuevo Momento Encuesta', null, array('class' => 'btn btn-lg btn-success')) }}</p>
	
	@if ($momentoencuesta->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>Momento</th>
				<th>Descripción Momento</th>
				<th>&nbsp;</th>
			</tr>
			</thead>
			
			<tbody>
			@foreach ($momentoencuesta as $momentoencuestum)
				<tr>
					<td>{{{ $momentoencuestum->id_momento }}}</td>
					<td>{{{ $momentoencuestum->descripcion_momento }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.momentoencuesta.destroy', $momentoencuestum->id_momento_encuesta))) }}
						{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('admin.momentoencuesta.edit', 'Editar', array($momentoencuestum->id_momento_encuesta), array('class' => 'btn btn-info')) }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado momentos de encuesta.
	@endif
@endsection
