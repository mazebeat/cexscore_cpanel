@extends('layouts.cpanel')

@section('title')
    Todas Regiones
@endsection

@section('page-title')
    <i class="fa fa-home fa-fw"></i>Todas las Regiones
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Regiones</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.regions.create', 'Agregar Nueva Región', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if ($regions->count())
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Región</th>
                <th>País</th>
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($regions as $region)
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
            @endforeach
            </tbody>
        </table>

        {{ $regions->links() }}
    @else
        No se han encontrado regions.
    @endif
@endsection
