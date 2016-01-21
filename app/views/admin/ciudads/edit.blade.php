@extends('layouts.cpanel')

@section('title')
    Editar Ciudad
@endsection

@section('page-title')
    <i class="fa fa-pencil fa-fw"></i>Editar Ciudad
@endsection

@section('breadcrumb')
    @parent
    <li>Ciudads</li>
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

    {{ Form::model($ciudad, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.ciudads.update', $ciudad->id_ciudad))) }}


    <div class="form-group">
        {{ Form::label('descripcion_ciudad', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('descripcion_ciudad', Input::old('descripcion_ciudad'), array('class'=>'form-control', 'placeholder'=>'Descripcion_ciudad')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('id_region', 'Regíon:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('id_region', $regiones, Input::old('id_region'), array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        <div class="col-sm-10">
            {{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
            {{ link_to_route('admin.ciudads.show', 'Cancelar', $ciudad->id_ciudad, array('class' => 'btn btn-lg btn-default')) }}
        </div>
    </div>

    {{ Form::close() }}
@endsection