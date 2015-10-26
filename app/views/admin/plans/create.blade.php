@extends('layouts.cpanel')

@section('title')
	Crear Plan
@endsection

@section('page-title')
	<i class="fa fa-plus fa-fw"></i>Agregar Plan
@endsection

@section('breadcrumb')
	@parent
	<li><a href="{{ URL::previous() }}">Planes</a></li>
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

	{{ Form::open(array('route' => 'admin.plans.store', 'class' => 'form-horizontal')) }}

	<div class="form-group">
		{{ Form::label('descripcion_plan', 'Descripción Plan:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_plan', Input::old('descripcion_plan'), array('class'=>'form-control', 'placeholders'=>'Descripcion_plan')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('cantidad_encuestas_plan', 'Cantidad Encuestas:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('number', 'cantidad_encuestas_plan', Input::old('cantidad_encuestas_plan', 0), array('class'=>'form-control', 'minmax' =>  Config::get('config.cpanel.numberLimit') )) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('cantidad_usuarios_plan', 'Cantidad Usuarios:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('number', 'cantidad_usuarios_plan', Input::old('cantidad_usuarios_plan', 0), array('class'=>'form-control', 'minmax' =>  Config::get('config.cpanel.numberLimit') )) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('cantidad_momentos_plan', 'Cantidad Momentoss:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::number('cantidad_momentos_plan', Input::old('cantidad_momentos_plan', 0), null, array('class'=>'form-control', 'minmax' =>  Config::get('config.cpanel.numberLimit') )) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('optin_plan', 'Opt-IN:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::checkbox('optin_plan', Input::old('optin_plan', false), false, array('class'=>'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('descarga_datos_plan', 'Descarga Datos:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::checkbox('descarga_datos_plan', Input::old('descarga_datos_plan', false), false, array('class'=>'form-control')) }}
		</div>
	</div>

	{{--<div class="form-group">--}}
	{{--		{{ Form::label('id_estado', 'Id_estado:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{ Form::hidden('id_estado', 1, array('class'=>'form-control')) }}
	{{--</div>--}}
	{{--</div>--}}

	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Crear', array('class' => 'btn btn-lg btn-primary')) }}
		</div>
	</div>
	{{ Form::close() }}
@endsection