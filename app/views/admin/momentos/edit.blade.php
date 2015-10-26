@extends('layouts.cpanel')

@section('title')
	Editar Momento
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Momento
@endsection

@section('breadcrumb')
	@parent
	<li>Momentos</li>
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

	{{ Form::model($momento, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.momentos.update', $momento->id_momento))) }}

	<div class="form-group">
		{{ Form::label('descripcion_momento', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_momento', Input::old('descripcion_momento'), array('class'=>'form-control', 'placeholder'=>'Descripcion_momento')) }}
		</div>
	</div>

	{{--<div class="form-group">--}}
	{{--		{{ Form::label('id_estado', 'Id_estado:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{ Form::input('hidden', 'id_estado', 1, array('class'=>'form-control')) }}
	{{--</div>--}}
	{{--</div>--}}


	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.momentos.show', 'Cancelar', $momento->id_momento, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection