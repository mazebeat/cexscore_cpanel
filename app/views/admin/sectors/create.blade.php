@extends('layouts.cpanel')

@section('title')
	Crear Sector
@endsection

@section('page-title')
	<i class="fa fa-plus fa-fw"></i>Agregar Sector
@endsection

@section('breadcrumb')
	@parent
	<li>Sector</li>
	<li class="active">Agregar</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-2">
			<h1>Crear Sector</h1>
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						{{ implode('', $errors->all('<li class="error">:message</li>')) }}
					</ul>
				</div>
			@endif
		</div>
	</div>

	{{ Form::open(array('route' => 'admin.sectors.store', 'class' => 'form-horizontal')) }}
	<div class="form-group">
		{{ Form::label('descripcion_sector', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_sector', Input::old('descripcion_sector'), array('class'=>'form-control', 'placeholder'=>'Descripción sector')) }}
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