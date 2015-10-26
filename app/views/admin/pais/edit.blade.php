@extends('layouts.cpanel')

@section('title')
	Editar Pais
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Pais
@endsection

@section('breadcrumb')
	@parent
	<li>Pais</li>
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

	{{ Form::model($pais, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.pais.update', $pais->id_pais))) }}

	<div class="form-group">
		{{ Form::label('descripcion_pais', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_pais', Input::old('descripcion_pais'), array('class'=>'form-control', 'placeholder'=>'Descripcion_pais')) }}
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.pais.show', 'Cancelar', $pais->id_pais, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection