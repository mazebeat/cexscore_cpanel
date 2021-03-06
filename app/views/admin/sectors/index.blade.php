@extends('layouts.cpanel')

@section('title')
    Sectores
@endsection

@section('page-title')
    <i class="fa fa-home fa-fw"></i>Sectores
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Sectores</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <p>{{ link_to_route('admin.sectors.create', 'Agregar Nuevo Sector', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if ($sectors->count())
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Descripción Sector</th>
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($sectors as $sector)
                <tr>
                    <td>{{ $sector->descripcion_sector }}</td>
                    <td class="pull-right">
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.sectors.destroy', $sector->id_sector))) }}
                        {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('admin.sectors.edit', 'Editar', array($sector->id_sector), array('class' => 'btn btn-info')) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $sectors->links() }}
    @else
        No se han encontrado sectors.
    @endif
@endsection
