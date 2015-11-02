@extends('layouts.cpanel')

@section('title')
	Todos Usuarios
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Usuarios
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Usuarios</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.usuarios.create', 'Agregar Nuevo Usuario', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if(isset($message) && $message != '')
		<div class="alert alert-info">
			<ul>
				{{{ $message }}}
			</ul>
		</div>
	@endif

	@if ($usuarios->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>Usuario</th>
				<th>Nombre Usuario</th>
				<th>RUT Usuario</th>
				<th>Correo Usuario</th>
				<th>&nbsp;</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($usuarios as $usuario)
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
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'POST', 'url' => array('admin/usuarios/resetPassword', $usuario->id_usuario)))}}
						{{ Form::submit('Reset Password', array('class' => 'btn btn-link')) }}
						{{ Form::close() }}
						{{--						<a href="{{ url('/admin/usuarios/resetPassword', array($usuario->id_usuario)) }}" class="bnt btn-link">Reset Password</a>--}}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado usuarios.
	@endif
@endsection
