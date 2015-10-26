@extends('layouts.cpanel')

@section('title')
	Editar Apariencium
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Apariencium
@endsection

@section('breadcrumb')
	@parent
	<li>Apariencia</li>
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

	{{ Form::model($apariencium, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.apariencia.update', $apariencium->id_apariencium))) }}

	        <div class="form-group">
            {{ Form::label('id_apariencia', 'Id_apariencia:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_apariencia', Input::old('id_apariencia'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('logo_header', 'Logo_header:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('logo_header', Input::old('logo_header'), array('class'=>'form-control', 'placeholder'=>'Logo_header')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('logo_incentivo', 'Logo_incentivo:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('logo_incentivo', Input::old('logo_incentivo'), array('class'=>'form-control', 'placeholder'=>'Logo_incentivo')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_header', 'Color_header:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_header', Input::old('color_header'), array('class'=>'form-control', 'placeholder'=>'Color_header')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_body', 'Color_body:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_body', Input::old('color_body'), array('class'=>'form-control', 'placeholder'=>'Color_body')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_footer', 'Color_footer:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_footer', Input::old('color_footer'), array('class'=>'form-control', 'placeholder'=>'Color_footer')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_boton', 'Color_boton:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_boton', Input::old('color_boton'), array('class'=>'form-control', 'placeholder'=>'Color_boton')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_opciones', 'Color_opciones:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_opciones', Input::old('color_opciones'), array('class'=>'form-control', 'placeholder'=>'Color_opciones')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_text_header', 'Color_text_header:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_text_header', Input::old('color_text_header'), array('class'=>'form-control', 'placeholder'=>'Color_text_header')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_text_body', 'Color_text_body:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_text_body', Input::old('color_text_body'), array('class'=>'form-control', 'placeholder'=>'Color_text_body')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_text_footer', 'Color_text_footer:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_text_footer', Input::old('color_text_footer'), array('class'=>'form-control', 'placeholder'=>'Color_text_footer')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('color_instrucciones', 'Color_instrucciones:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('color_instrucciones', Input::old('color_instrucciones'), array('class'=>'form-control', 'placeholder'=>'Color_instrucciones')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('desea_captura_datos', 'Desea_captura_datos:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'desea_captura_datos', Input::old('desea_captura_datos'), array('class'=>'form-control')) }}
            </div>
        </div>


	<div class="form-group">
	    <label class="col-sm-2 control-label">&nbsp;</label>
	    <div class="col-sm-10">
	      {{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
	      {{ link_to_route('admin.apariencia.show', 'Cancelar', $apariencium->id_apariencium, array('class' => 'btn btn-lg btn-default')) }}
	    </div>
	</div>

	{{ Form::close() }}
@endsection