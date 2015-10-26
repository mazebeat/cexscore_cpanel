@extends('layouts.cpanel')

@section('title')
	Ver Momento Encuesta
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Momento Encuesta
@endsection

@section('breadcrumb')
	@parent
	<li>Momentoencuesta</li>
	<li class="active">Ver</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.momentoencuesta.index', 'Volver a Momento Encuesta', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th>Momento</th>
			<th>Descripción Momento</th>
		</tr>
		</thead>
		<tbody>
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
		</tbody>
	</table>
@endsection