@extends('layouts.cpanel')

@section('title')
	Ver Canal
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Canal
@endsection

@section('breadcrumb')
	@parent
	<li>Canals</li>
	<li class="active">Ver</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.canals.index', 'Volver a canals', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th>Descripción Canal</th>
			<th>Código Canal</th>
		</tr>
		</thead>
		<tbody>
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
		</tbody>
	</table>
@endsection