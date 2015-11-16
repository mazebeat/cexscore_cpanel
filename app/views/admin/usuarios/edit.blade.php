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

	{{ Form::model($usuario, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.usuarios.update', $usuario->id_usuario))) }}

	{{--<div class="form-group">--}}
	{{--{{ Form::label('username', 'Usuario:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::text('username', Input::old('username'), array('class'=>'form-control', 'placeholder'=>'Usuario')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	{{--<div class="form-group">--}}
	{{--{{ Form::label('password', 'Password:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	<div class="form-group">
		{{ Form::label('nombre_usuario', 'Nombre Completo:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('nombre_usuario', Input::old('nombre_usuario'), array('class'=>'form-control', 'placeholder'=>'Nombre_usuario')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('rut_usuario', 'RUT:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('rut_usuario', Input::old('rut_usuario'), array('class'=>'form-control', 'placeholder'=>'Rut_usuario')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('fecha_nacimiento', 'Fecha Nacimiento:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('date', 'fecha_nacimiento', Input::old('fecha_nacimiento'), array('class'=>'form-control', 'placeholder'=>'Fecha_nacimiento')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('genero_usuario', 'Genero:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('genero_usuario', ['' => '','F' => 'Femenino', 'M' => 'Masculino'], Input::old('genero_usuario'), array('class'=>'form-control', 'placeholder'=>'Genero_usuario')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('correo_usuario', 'Email:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::email('correo_usuario', Input::old('correo_usuario'), array('class'=>'form-control', 'placeholder'=>'Correo_usuario')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('linkedlin_usuario', 'LinkedlIn:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::url('linkedlin_usuario', Input::old('linkedlin_usuario'), array('class'=>'form-control', 'placeholder'=>'Linkedlin_usuario')) }}
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
		{{ Form::label('rol_organizacion_usuario', 'Rol Organización:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('rol_organizacion_usuario', ['null' => '', 'Servicio' => 'Servicio', 'Marketing' => 'Marketing', 'Ventas/Comercial' => 'Ventas/Comercial', 'Finanzas' => 'Finanzas', 'Dirección' => 'Dirección', 'Operaciones' => 'Operaciones'], Input::old('rol_organizacion_usuario'), array('class'=>'form-control')) }}
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
			{{ link_to_route('admin.usuarios.show', 'Cancelar', $usuario->id_usuario, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection

@section('script')
	{{--jQuery RUT--}}
	{{ HTML::script('js/jquery.rut.min.js') }}

	<script>
		(function ($) {
			$("[name='rut_usuario'").rut({
				formatOn: 'change keyup',
				validateOn: 'change keyup'
			});
		})(jQuery);
	</script>
@endsection