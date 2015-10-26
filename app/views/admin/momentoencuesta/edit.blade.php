@extends('layouts.cpanel')

@section('title')
	Editar Momento Encuesta
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Momento Encuesta
@endsection

@section('breadcrumb')
	@parent
	<li>Momento Encuesta</li>
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

	{{ Form::model($momentoencuestum, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.momentoencuesta.update', $momentoencuestum->id_momento_encuesta))) }}

	<div class="form-group">
		{{ Form::label('id_momento', 'Momento:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('id_momento', $moments, Input::old('id_momento'), array('class'=>'form-control')) }}
		</div>
	</div>

	{{--<div class="form-group">--}}
	{{--		{{ Form::label('id_encuesta', 'Id_encuesta:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{ Form::input('hidden', 'id_encuesta', Input::old('id_encuesta'), array('class'=>'form-control')) }}
	{{--</div>--}}
	{{--</div>--}}

	<div class="form-group">
		{{ Form::label('descripcion_momento', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_momento', Input::old('descripcion_momento'), array('class'=>'form-control', 'placeholder'=>'Descripción Momento')) }}
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.momentoencuesta.show', 'Cancelar', $momentoencuestum->id_momento_encuesta, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection