@extends('layouts.cpanel')

@section('title')
	Crear País
@endsection

@section('page-title')
	<i class="fa fa-plus fa-fw"></i>Agregar País
@endsection

@section('breadcrumb')
	@parent
	<li>País</li>
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

	{{ Form::open(array('route' => 'admin.pais.store', 'class' => 'form-horizontal')) }}
	<div class="form-group">
		{{ Form::label('descripcion_pais', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_pais', Input::old('descripcion_pais'), array('class'=>'form-control', 'placeholder'=>'Descripci&oacute;n')) }}
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