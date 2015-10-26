@extends('layouts.cpanel')

@section('title')
	Editar Cliente
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Cliente
@endsection

@section('breadcrumb')
	@parent
	<li>Clientes</li>
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

	{{ Form::model($cliente, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.clientes.update', $cliente->id_cliente))) }}

	<div class="form-group">
		{{ Form::label('rut_cliente', 'RUT:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('rut_cliente', Input::old('rut_cliente'), array('class'=>'form-control', 'placeholder'=>'Rut_cliente')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('nombre_cliente', 'Nombre:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('nombre_cliente', Input::old('nombre_cliente'), array('class'=>'form-control', 'placeholder'=>'Nombre')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('fono_cliente', 'Fono:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('fono_cliente', Input::old('fono_cliente'), array('class'=>'form-control', 'placeholder'=>'Fono')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('correo_cliente', 'Correo:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('correo_cliente', Input::old('correo_cliente'), array('class'=>'form-control', 'placeholder'=>'Correo')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('codigo_postal', 'Código Postal:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('codigo_postal', Input::old('codigo_postal'), array('class'=>'form-control', 'placeholder'=>'Código Postal', 'required')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('direccion_cliente', 'Dirección:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('direccion_cliente', Input::old('direccion_cliente'), array('class'=>'form-control', 'placeholder'=>'Dirección')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('id_ciudad', 'Ciudad:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('id_ciudad', $ciudads, Input::old('id_ciudad'), array('class'=>'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('id_sector', 'Sector Empresarial:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('id_sector', $sectors, Input::old('id_sector'), array('class'=>'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('id_plan', 'Plan:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('id_plan', $plans, Input::old('id_plan'), array('class'=>'form-control')) }}
		</div>
	</div>

	{{--<div class="form-group">--}}
	{{--		{{ Form::label('id_encuesta', 'Encuesta:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
	{{ Form::hidden('id_encuesta', Input::old('id_encuesta'), array('class'=>'form-control')) }}
	{{--</div>                     --}}
	{{--</div>--}}

	<div class="form-group">
		{{ Form::label('id_estado', 'Estado:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::select('id_estado', ['1' => 'Activado', '2' => 'Desactivado'], Input::old('id_estado'), array('class'=>'form-control')) }}
		</div>
	</div>


	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.clientes.show', 'Cancelar', $cliente->id_cliente, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>

	{{ Form::close() }}
@endsection