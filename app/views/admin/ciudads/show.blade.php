@extends('layouts.cpanel')

@section('title')
    Ver Ciudad
@endsection

@section('page-title')
    <i class="fa fa-eye fa-fw"></i>Ver Ciudad
@endsection

@section('breadcrumb')
    @parent
    <li>Ciudades</li>
    <li class="active">Ver</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.ciudads.index', 'Volver a Ciudades', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
            <th>Ciudad</th>
            <th>Región</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $ciudad->descripcion_ciudad }}</td>
            <td>{{ array_get($regiones, $ciudad->id_region) }}</td>
            <td class="pull-right">
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.ciudads.destroy', $ciudad->id_ciudad))) }}
                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                {{ link_to_route('admin.ciudads.edit', 'Editar', array($ciudad->id_ciudad), array('class' => 'btn btn-info')) }}
            </td>
        </tr>
        </tbody>
    </table>
@endsection