@extends('layouts.cpanel')

@section('title')
    Todos País
@endsection

@section('page-title')
    <i class="fa fa-home fa-fw"></i>Todos País
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pais</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.pais.create', 'Agregar Nuevo Pais', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if ($pais->count())
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>País</th>
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($pais as $pai)
                <tr>
                    <td>{{ $pai->descripcion_pais }}</td>
                    <td class="pull-right">
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.pais.destroy', $pai->id_pai))) }}
                        {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('admin.pais.edit', 'Editar', array($pai->id_pais), array('class' => 'btn btn-info')) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        No se han encontrado pais.
    @endif
@endsection
