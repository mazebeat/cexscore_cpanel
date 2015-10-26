@extends('layouts.cpanel')

@section('title')
	Crear TipoUsuario
@endsection

@section('page-title')
	<i class="fa fa-plus fa-fw"></i>Agregar TipoUsuario
@endsection

@section('breadcrumb')
	@parent
	<li>TipoUsuarios</li>
	<li class="active">Agregar</li>
@endsection

@section('content')
	<div class="row">
	    <div class="col-md-10 col-md-offset-2">
	        <h1>Crear TipoUsuario</h1>
	        @if ($errors->any())
	            <div class="alert alert-danger">
	                <ul>
	                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
	                </ul>
	            </div>
	        @endif
	    </div>
	</div>

	{{ Form::open(array('route' => 'admin.tipoUsuarios.store', 'class' => 'form-horizontal')) }}
		        <div class="form-group">
            {{ Form::label('descripcion_tipo_cliente', 'Descripcion_tipo_cliente:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('descripcion_tipo_cliente', Input::old('descripcion_tipo_cliente'), array('class'=>'form-control', 'placeholder'=>'Descripcion_tipo_cliente')) }}
            </div>
        </div>

		<div class="form-group">
		    <label class="col-sm-2 control-label">&nbsp;</label>
		    <div class="col-sm-10">
				{{ Form::submit('Create', array('class' => 'btn btn-lg btn-primary')) }}
		    </div>
		</div>
	{{ Form::close() }}
@endsection