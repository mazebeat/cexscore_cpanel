@extends('layouts.cpanel')

@section('title')
	Editar Canal
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Canal
@endsection

@section('breadcrumb')
	@parent
	<li>Canals</li>
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

	{{ Form::model($canal, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.canals.update', $canal->id_canal))) }}


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
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.canals.show', 'Cancelar', $canal->id_canal, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection