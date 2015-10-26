@extends('layouts.cpanel')

@section('title')
	Ver Sector
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Sector
@endsection

@section('breadcrumb')
	@parent
	<li>Sectors</li>
	<li class="active">Ver</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.sectors.index', 'Volver a sectors', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th>Descripción Sector</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>{{{ $sector->descripcion_sector }}}</td>
			<td>
				{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.sectors.destroy', $sector->id_sector))) }}
				{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
				{{ link_to_route('admin.sectors.edit', 'Editar', array($sector->id_sector), array('class' => 'btn btn-info')) }}
			</td>
		</tr>
		</tbody>
	</table>
@endsection