@extends('layouts.cpanel')

@section('title')
    Ver Region
@endsection

@section('page-title')
    <i class="fa fa-eye fa-fw"></i>Ver Region
@endsection

@section('breadcrumb')
    @parent
    <li>Regions</li>
    <li class="active">Ver</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.regions.index', 'Volver a regions', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
            <th>Región</th>
            <th>País</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $region->descripcion_region }}</td>
            <td>{{ array_get($paises, $region->id_pais) }}</td>
            <td class="pull-right">
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.regions.destroy', $region->id_region))) }}
                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                {{ link_to_route('admin.regions.edit', 'Editar', array($region->id_region), array('class' => 'btn btn-info')) }}
            </td>
        </tr>
        </tbody>
    </table>
@endsection