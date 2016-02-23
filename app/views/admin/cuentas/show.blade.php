@extends('layouts.cpanel')

@section('title')
    Ver Cliente
@endsection

@section('page-title')
    <i class="fa fa-eye fa-fw"></i>Ver Cliente
@endsection

@section('breadcrumb')
    @parent
    <li class=""><a href="{{ url('admin/cuentas')  }}">Cuentas</a></li>
    <li class="active">Ver</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.cuentas.index', 'Volver a cuentas', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
            <th>RUT</th>
            <th>Nombre</th>
            <th>Fono</th>
            <th>Web Site</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $cliente->rut_cliente }}</td>
            <td>{{ $cliente->nombre_cliente }}</td>
            <td>{{ $cliente->fono_fijo_cliente }}</td>
            <td>{{ $cliente->correo_cliente }}</td>
            <td class="pull-right">
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.cuentas.destroy', $cliente->id_cliente))) }}
                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                {{ link_to_route('admin.cuentas.edit', 'Editar', array($cliente->id_cliente), array('class' => 'btn btn-info')) }}
            </td>
        </tr>
        </tbody>
    </table>
@endsection