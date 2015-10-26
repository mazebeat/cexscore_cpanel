@extends('layouts.cpanel')

@section('title')
	Crear Momento Encuesta
@endsection

@section('page-title')
	<i class="fa fa-plus fa-fw"></i>Agregar Momento Encuesta
@endsection

@section('breadcrumb')
	@parent
	<li>Momento Encuesta</li>
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

	{{ Form::open(array('route' => 'admin.momentoencuesta.store', 'class' => 'form-horizontal')) }}
	<div class="form-group">
		{{ Form::label('id_momento', 'Momento:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('id_momento', $moments, Input::old('id_momento'), array('class'=>'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('descripcion_momento', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_momento', Input::old('descripcion_momento'), array('class'=>'form-control', 'placeholder'=>'Descripción Momento')) }}
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