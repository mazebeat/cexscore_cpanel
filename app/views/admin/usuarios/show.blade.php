@extends('layouts.cpanel')

@section('title')
	Ver Usuario
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Usuario
@endsection

@section('breadcrumb')
	@parent
	<li>Usuarios</li>
	<li class="active">Ver</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.usuarios.index', 'Volver a usuarios', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th>Usuario</th>
			<th>Nombre Usuario</th>
			<th>RUT Usuario</th>
			<th>Correo Usuario</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>{{{ $usuario->usuario }}}</td>
			<td>{{{ $usuario->nombre_usuario }}}</td>
			<td>{{{ $usuario->rut_usuario }}}</td>
			<td>{{{ $usuario->correo_usuario }}}</td>
			<td>
				{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.usuarios.destroy', $usuario->id_usuario))) }}
				{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
				{{ link_to_route('admin.usuarios.edit', 'Editar', array($usuario->id_usuario), array('class' => 'btn btn-info')) }}
			</td>
		</tr>
		</tbody>
	</table>
@endsection