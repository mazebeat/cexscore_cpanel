@extends('layouts.cpanel')

@section('title')
	Editar Usuario
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Usuario
@endsection

@section('breadcrumb')
	@parent
	<li>Usuarios</li>
	<li class="active">Editar</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-2">
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						{{ implode('', $errors->all('<li class="error">:message</li>')) }}
					</ul>
				</div>
			@endif
		</div>
	</div>

	{{ Form::model($csusuario, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.csusuarios.update', $csusuario->id_usuario))) }}

	{{--<div class="form-group">--}}
	{{--{{ Form::label('usuario', 'Usuario:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::text('usuario', Input::old('usuario'), array('class'=>'form-control', 'placeholder'=>'Usuario', 'readonly')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group">--}}
	{{--{{ Form::label('password', 'Password:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	<div class="form-group">
		{{ Form::label('nombre', 'Nombre Completo:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('nombre', Input::old('nombre'), array('class'=>'form-control', 'placeholder'=>'Nombre_usuario')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('rut', 'RUT:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('rut', Input::old('rut'), array('class'=>'form-control', 'placeholder'=>'Rut_usuario')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('fecha_nacimiento', 'Fecha Nacimiento:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('date', 'fecha_nacimiento', Input::old('fecha_nacimiento'), array('class'=>'form-control', 'placeholder'=>'Fecha_nacimiento')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('genero', 'Genero:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('genero', ['' => '','F' => 'Femenino', 'M' => 'Masculino'], Input::old('genero'), array('class'=>'form-control', 'placeholder'=>'Genero_usuario')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::email('email', Input::old('email'), array('class'=>'form-control', 'placeholder'=>'Correo_usuario')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('linkedlin', 'LinkedlIn:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::url('linkedlin', Input::old('linkedlin'), array('class'=>'form-control', 'placeholder'=>'Linkedlin_usuario')) }}
		</div>
	</div>

	{{--<div class="form-group">--}}
	{{--{{ Form::label('desea_correo_usuario', 'Desea_correo_usuario:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::text('desea_correo_usuario', Input::old('desea_correo_usuario'), array('class'=>'form-control', 'placeholder'=>'Desea_correo_usuario')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group">--}}
	{{--{{ Form::label('responsable_usuario', 'Responsable_usuario:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::text('responsable_usuario', Input::old('responsable_usuario'), array('class'=>'form-control', 'placeholder'=>'Responsable_usuario')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	<div class="form-group">
		{{ Form::label('rol_organizacion', 'Rol Organización:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('rol_organizacion', ['null' => '', 'Servicio' => 'Servicio', 'Marketing' => 'Marketing', 'Ventas/Comercial' => 'Ventas/Comercial', 'Finanzas' => 'Finanzas', 'Dirección' => 'Dirección', 'Operaciones' => 'Operaciones'], Input::old('rol_organizacion'), array('class'=>'form-control')) }}
		</div>
	</div>

	{{--<div class="form-group">--}}
	{{--{{ Form::label('id_tipo_usuario', 'Id_tipo_usuario:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::input('number', 'id_tipo_usuario', Input::old('id_tipo_usuario', 3), array('class'=>'form-control')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group">--}}
	{{--{{ Form::label('id_cliente', 'Id_cliente:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{ Form::input('hidden', 'id_cliente', Input::old('id_cliente', Auth::user()->cliente->id_cliente), array('class'=>'form-control')) }}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group">--}}
	{{--{{ Form::label('id_encuesta', 'Id_encuesta:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::input('number', 'id_encuesta', Input::old('id_encuesta'), array('class'=>'form-control')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.csusuarios.show', 'Cancelar', $csusuario->id_usuario, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection