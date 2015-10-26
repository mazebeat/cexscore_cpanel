@extends('layouts.cpanel')

@section('title')
	Editar Encuesta
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Encuesta
@endsection

@section('breadcrumb')
	@parent
	<li>Encuesta</li>
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

	{{ Form::model($encuestum, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.encuesta.update', $encuestum->id_encuesta))) }}

	<div class="form-group">
		{{ Form::label('titulo', 'Título:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('titulo', Input::old('titulo'), array('class'=>'form-control', 'placeholder'=>'T&iacute;tulo')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('slogan', 'Subtítulo:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('slogan', Input::old('slogan'), array('class'=>'form-control', 'placeholder'=>'Eslogan')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('description', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=>'Descripci&oacute;n')) }}
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.encuesta.show', 'Cancelar', $encuestum->id_encuesta, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection