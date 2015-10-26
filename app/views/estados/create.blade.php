@extends('layouts.cpanel')

@section('title')
	Crear Estado
@endsection

@section('page-title')
	<i class="fa fa-plus fa-fw"></i>Agregar Estado
@endsection

@section('breadcrumb')
	@parent
	<li>Estados</li>
	<li class="active">Agregar</li>
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

	{{ Form::open(array('route' => 'admin.estados.store', 'class' => 'form-horizontal')) }}
		        <div class="form-group">
            {{ Form::label('id_estado', 'Id_estado:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_estado', Input::old('id_estado'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('tipo_estado', 'Tipo_estado:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('tipo_estado', Input::old('tipo_estado'), array('class'=>'form-control', 'placeholder'=>'Tipo_estado')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('descripcion_estado', 'Descripcion_estado:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('descripcion_estado', Input::old('descripcion_estado'), array('class'=>'form-control', 'placeholder'=>'Descripcion_estado')) }}
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