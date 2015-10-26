@extends('layouts.cpanel')

@section('title')
	Crear Usuario
@endsection

@section('page-title')
	<i class="fa fa-plus fa-fw"></i>Agregar Usuario
@endsection

@section('breadcrumb')
	@parent
	<li>Usuarios</li>
	<li class="active">Agregar</li>
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

	{{ Form::open(array('route' => 'admin.usuarios.store', 'class' => 'form-horizontal')) }}

	<div class="form-group">
		{{ Form::label('nombre_usuario', 'Nombre:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('nombre_usuario', Input::old('nombre_usuario'), array('class'=>'form-control', 'placeholder'=>'Nombre')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Contraseña:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('fecha_nacimiento', 'Fecha Nacimiento:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('fecha_nacimiento', Input::old('fecha_nacimiento'), array('class'=>'form-control', 'placeholder'=>'Fecha Nacimiento')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('edad_usuario', 'Edad:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('number', 'edad_usuario', Input::old('edad_usuario'), array('class'=>'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('genero_usuario', 'Genero:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('genero_usuario', ['' => '', 'F' => 'Femenino', 'M' => 'Masculino'], Input::old('genero_usuario'), array('class'=>'form-control', 'placeholder'=>'Genero')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('correo_usuario', 'Correo:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::email('correo_usuario', Input::old('correo_usuario'), array('class'=>'form-control', 'placeholder'=>'Correo')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('rut_usuario', 'RUT:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('rut_usuario', Input::old('rut_usuario'), array('class'=>'form-control', 'placeholder'=>'RUT')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('desea_correo_usuario', 'Desea Correo?:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('desea_correo_usuario', ['' => '', '0' => 'No', '1' => 'Sí'],  Input::old('desea_correo_usuario'), array('class'=>'form-control', 'placeholder'=>'Desea Correo?')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('id_tipo_usuario', 'Tipo Usuario:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('id_tipo_usuario', Input::old('id_tipo_usuario'), array('class'=>'form-control', 'placeholder'=>'Tipo Usuario')) }}
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Crear', array('class' => 'btn btn-lg btn-primary')) }}
		</div>
	</div>
	{{ Form::close() }}
@endsection