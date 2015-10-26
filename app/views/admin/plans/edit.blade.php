@extends('layouts.cpanel')

@section('title')
	Editar Plan
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Plan
@endsection

@section('breadcrumb')
	@parent
	<li><a href="{{ URL::previous() }}">Planes</a></li>
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

	{{ Form::model($plan, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.plans.update', $plan->id_plan))) }}

	{{--<div class="form-group">--}}
	{{--{{ Form::label('id_plan', 'Id_plan:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{ Form::input('hidden', 'id_plan', Input::old('id_plan'), array('class'=>'form-control')) }}
	{{--</div>--}}
	{{--</div>--}}

	<div class="form-group">
		{{ Form::label('descripcion_plan', 'Descripción Plan:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_plan', Input::old('descripcion_plan'), array('class'=>'form-control', 'placeholders'=>'Descripcion_plan')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('cantidad_encuestas_plan', 'Cantidad Encuestas:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('number', 'cantidad_encuestas_plan', Input::old('cantidad_encuestas_plan'), array('class'=>'form-control', 'minmax' =>  Config::get('config.cpanel.numberLimit') )) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('cantidad_usuarios_plan', 'Cantidad Usuarios:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('number', 'cantidad_usuarios_plan', Input::old('cantidad_usuarios_plan'), array('class'=>'form-control', 'minmax' =>  Config::get('config.cpanel.numberLimit') )) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('cantidad_momentos_plan', 'Cantidad Momentos:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::number('cantidad_momentos_plan', Input::old('cantidad_momentos_plan'), null, array('class'=>'form-control', 'minmax' =>  Config::get('config.cpanel.numberLimit') )) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('optin_plan', 'Opt-IN:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::checkbox('optin_plan', Input::old('optin_plan'), false, array('class'=>'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('descarga_datos_plan', 'Descarga Datos:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::checkbox('descarga_datos_plan', Input::old('descarga_datos_plan', false), false, array('class'=>'form-control')) }}
		</div>
	</div>

	{{--<div class="form-group">--}}
	{{--{{ Form::label('id_estado', 'Id_estado:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{--{{ Form::input('number', 'id_estado', Input::old('id_estado'), array('class'=>'form-control')) }}--}}
	{{--</div>--}}
	{{--</div>--}}

	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.plans.show', 'Cancelar', $plan->id_plan, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection