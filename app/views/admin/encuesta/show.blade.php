@extends('layouts.cpanel')

@section('title')
    Ver Encuestum
@endsection

@section('page-title')
    <i class="fa fa-eye fa-fw"></i>Ver Encuesta
@endsection

@section('breadcrumb')
    @parent
    <li>Encuesta</li>
    <li class="active">Ver</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.encuesta.index', 'Volver a encuesta', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
            <th>Título</th>
            <th>Subtítulo</th>
            <th>Descripción</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $encuestum->titulo }}</td>
            <td>{{ $encuestum->slogan }}</td>
            <td>{{ $encuestum->description }}</td>
            <td class="pull-right">
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.encuesta.destroy', $encuestum->id_encuestum))) }}
                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                {{ link_to_route('admin.encuesta.edit', 'Editar', array($encuestum->id_encuesta), array('class' => 'btn btn-info')) }}
            </td>
        </tr>
        </tbody>
    </table>
@endsection