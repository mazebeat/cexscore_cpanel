@extends('layouts.cpanel')

@section('title')
	Editar Sector
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Sector
@endsection

@section('breadcrumb')
	@parent
	<li>Sectors</li>
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

	{{ Form::model($sector, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.sectors.update', $sector->id_sector))) }}

	<div class="form-group">
		{{ Form::label('descripcion_sector', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_sector', Input::old('descripcion_sector'), array('class'=>'form-control', 'placeholder'=>'Descripcion_sector')) }}
		</div>
	</div>


	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.sectors.show', 'Cancelar', $sector->id_sector, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection