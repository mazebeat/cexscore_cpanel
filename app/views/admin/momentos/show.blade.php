@extends('layouts.cpanel')

@section('title')
	Ver Momento
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Momento
@endsection

@section('breadcrumb')
	@parent
	<li>Momentos</li>
	<li class="active">Ver</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.momentos.index', 'Volver a momentos', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th>Descripción Momento</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>{{{ $momento->descripcion_momento }}}</td>
			<td>
				{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.momentos.destroy', $momento->id_momento))) }}
				{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
				{{ link_to_route('admin.momentos.edit', 'Editar', array($momento->id_momento), array('class' => 'btn btn-info')) }}
			</td>
		</tr>
		</tbody>
	</table>
@endsection