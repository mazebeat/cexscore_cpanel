@extends('layouts.cpanel')

@section('title')
	Editar TipoUsuario
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar TipoUsuario
@endsection

@section('breadcrumb')
	@parent
	<li>TipoUsuarios</li>
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

	{{ Form::model($tipoUsuario, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.tipoUsuarios.update', $tipoUsuario->id_tipoUsuario))) }}

	        <div class="form-group">
            {{ Form::label('descripcion_tipo_cliente', 'Descripcion_tipo_cliente:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('descripcion_tipo_cliente', Input::old('descripcion_tipo_cliente'), array('class'=>'form-control', 'placeholder'=>'Descripcion_tipo_cliente')) }}
            </div>
        </div>


	<div class="form-group">
	    <label class="col-sm-2 control-label">&nbsp;</label>
	    <div class="col-sm-10">
	      {{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
	      {{ link_to_route('admin.tipoUsuarios.show', 'Cancelar', $tipoUsuario->id_tipoUsuario, array('class' => 'btn btn-lg btn-default')) }}
	    </div>
	</div>

	{{ Form::close() }}
@endsection