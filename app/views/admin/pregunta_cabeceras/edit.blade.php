@extends('layouts.cpanel')

@section('title')
	Editar Pregunta_cabecera
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Pregunta_cabecera
@endsection

@section('breadcrumb')
	@parent
	<li>Pregunta_cabeceras</li>
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

	{{ Form::model($pregunta_cabecera, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.pregunta_cabeceras.update', $pregunta_cabecera->id_pregunta_cabecera))) }}

	        <div class="form-group">
            {{ Form::label('descripcion_1', 'Descripcion_1:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('descripcion_1', Input::old('descripcion_1'), array('class'=>'form-control', 'placeholder'=>'Descripcion_1')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('descripcion_2', 'Descripcion_2:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('descripcion_2', Input::old('descripcion_2'), array('class'=>'form-control', 'placeholder'=>'Descripcion_2')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('descripcion_3', 'Descripcion_3:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('descripcion_3', Input::old('descripcion_3'), array('class'=>'form-control', 'placeholder'=>'Descripcion_3')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('numero_pregunta', 'Numero_pregunta:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('numero_pregunta', Input::old('numero_pregunta'), array('class'=>'form-control', 'placeholder'=>'Numero_pregunta')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('id_pregunta_padre', 'Id_pregunta_padre:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_pregunta_padre', Input::old('id_pregunta_padre'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('id_encuesta', 'Id_encuesta:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_encuesta', Input::old('id_encuesta'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('id_categoria', 'Id_categoria:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_categoria', Input::old('id_categoria'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('id_tipo_respuesta', 'Id_tipo_respuesta:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_tipo_respuesta', Input::old('id_tipo_respuesta'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('id_estado', 'Id_estado:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_estado', Input::old('id_estado'), array('class'=>'form-control')) }}
            </div>
        </div>


	<div class="form-group">
	    <label class="col-sm-2 control-label">&nbsp;</label>
	    <div class="col-sm-10">
	      {{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
	      {{ link_to_route('admin.pregunta_cabeceras.show', 'Cancelar', $pregunta_cabecera->id_pregunta_cabecera, array('class' => 'btn btn-lg btn-default')) }}
	    </div>
	</div>

	{{ Form::close() }}
@endsection