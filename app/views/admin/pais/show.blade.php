@extends('layouts.cpanel')

@section('title')
    Ver Pais
@endsection

@section('page-title')
    <i class="fa fa-eye fa-fw"></i>Ver Pai
@endsection

@section('breadcrumb')
    @parent
    <li>Pais</li>
    <li class="active">Ver</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.pais.index', 'Volver a pais', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
            <th>País</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $pais->descripcion_pais }}</td>
            <td class="pull-right">
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.pais.destroy', $pais->id_pais))) }}
                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                {{ link_to_route('admin.pais.edit', 'Editar', array($pais->id_pais), array('class' => 'btn btn-info')) }}
            </td>
        </tr>
        </tbody>
    </table>
@endsection