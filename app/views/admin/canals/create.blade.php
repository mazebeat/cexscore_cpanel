@extends('layouts.cpanel')

@section('title')
	Crear Canal
@endsection

@section('page-title')
	<i class="fa fa-plus fa-fw"></i>Agregar Canal
@endsection

@section('breadcrumb')
	@parent
	<li>Canals</li>
	<li class="active">Agregar</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-2">
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul class="list-unstyled">
						{{ implode('', $errors->all('<li class="error">:message</li>')) }}
					</ul>
				</div>
			@endif
		</div>
	</div>

	{{ Form::open(array('route' => 'admin.canals.store', 'class' => 'form-horizontal')) }}

	<div class="form-group">
		{{ Form::label('descripcion_canal', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_canal', Input::old('descripcion_canal'), array('class'=>'form-control', 'placeholder'=>'Descripcion_canal')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('codigo_canal', 'Código:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('codigo_canal', Input::old('codigo_canal'), array('class'=>'form-control', 'placeholder'=>'Codigo_canal')) }}
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