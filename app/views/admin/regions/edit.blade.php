@extends('layouts.cpanel')

@section('title')
	Editar Region
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Región
@endsection

@section('breadcrumb')
	@parent
	<li>Regions</li>
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

	{{ Form::model($region, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.regions.update', $region->id_region))) }}

	<div class="form-group">
		{{ Form::label('descripcion_region', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('descripcion_region', Input::old('descripcion_region'), array('class'=>'form-control', 'placeholder'=>'Descripcion_region')) }}
		</div>
	</div>

	{{--<div class="form-group">--}}
	{{--		{{ Form::label('id_pais', 'Pais:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{ Form::hidden('number', 'id_pais', Input::old('id_pais'), array('class'=>'form-control')) }}
	{{--</div>--}}
	{{--</div>--}}


	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.regions.show', 'Cancelar', $region->id_region, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection