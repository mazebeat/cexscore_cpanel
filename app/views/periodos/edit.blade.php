@extends('layouts.cpanel')

@section('title')
	Editar Periodo
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Periodo
@endsection

@section('breadcrumb')
	@parent
	<li>Periodos</li>
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

	{{ Form::model($periodo, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.periodos.update', $periodo->id_periodo))) }}

	        <div class="form-group">
            {{ Form::label('id_periodo', 'Id_periodo:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_periodo', Input::old('id_periodo'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('periodo', 'Periodo:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('periodo', Input::old('periodo'), array('class'=>'form-control', 'placeholder'=>'Periodo')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('meta', 'Meta:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'meta', Input::old('meta'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('mes', 'Mes:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'mes', Input::old('mes'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('anio', 'Anio:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'anio', Input::old('anio'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('id_cliente', 'Id_cliente:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'id_cliente', Input::old('id_cliente'), array('class'=>'form-control')) }}
            </div>
        </div>


	<div class="form-group">
	    <label class="col-sm-2 control-label">&nbsp;</label>
	    <div class="col-sm-10">
	      {{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
	      {{ link_to_route('admin.periodos.show', 'Cancelar', $periodo->id_periodo, array('class' => 'btn btn-lg btn-default')) }}
	    </div>
	</div>

	{{ Form::close() }}
@endsection