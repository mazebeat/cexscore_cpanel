@extends('layouts.cpanel')

@section('title')
    Crear Región
@endsection

@section('page-title')
    <i class="fa fa-plus fa-fw"></i>Agregar Región
@endsection

@section('breadcrumb')
    @parent
    <li>Regiones</li>
    <li class="active">Agregar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <h1>Crear Región</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{ Form::open(array('route' => 'admin.regions.store', 'class' => 'form-horizontal')) }}
    <div class="form-group">
        {{ Form::label('descripcion_region', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('descripcion_region', Input::old('descripcion_region'), array('class'=>'form-control', 'placeholder'=>'Descripcion_region')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('id_pais', 'País:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('id_pais', $paises, Input::old('id_pais'), array('class'=>'form-control')) }}
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