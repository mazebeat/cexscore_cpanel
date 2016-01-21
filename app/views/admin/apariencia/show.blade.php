@extends('layouts.cpanel')

@section('title')
    Ver Apariencium
@endsection

@section('page-title')
    <i class="fa fa-eye fa-fw"></i>Ver Apariencium
@endsection

@section('breadcrumb')
    @parent
    <li>Apariencia</li>
    <li class="active">Ver</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.apariencia.index', 'Volver a apariencia', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

    <table class="table table-striped table-condensed table-hover">
        <thead>
        <tr>
            <th>Id_apariencia</th>
            <th>Logo_header</th>
            <th>Logo_incentivo</th>
            <th>Color_header</th>
            <th>Color_body</th>
            <th>Color_footer</th>
            <th>Color_boton</th>
            <th>Color_opciones</th>
            <th>Color_text_header</th>
            <th>Color_text_body</th>
            <th>Color_text_footer</th>
            <th>Color_instrucciones</th>
            <th>Desea_captura_datos</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $apariencium->id_apariencia }}</td>
            <td>{{ $apariencium->logo_header }}</td>
            <td>{{ $apariencium->logo_incentivo }}</td>
            <td>{{ $apariencium->color_header }}</td>
            <td>{{ $apariencium->color_body }}</td>
            <td>{{ $apariencium->color_footer }}</td>
            <td>{{ $apariencium->color_boton }}</td>
            <td>{{ $apariencium->color_opciones }}</td>
            <td>{{ $apariencium->color_text_header }}</td>
            <td>{{ $apariencium->color_text_body }}</td>
            <td>{{ $apariencium->color_text_footer }}</td>
            <td>{{ $apariencium->color_instrucciones }}</td>
            <td>{{ $apariencium->desea_captura_datos }}</td>
            <td class="pull-right">
                {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.apariencia.destroy', $apariencium->id_apariencium))) }}
                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                {{ link_to_route('admin.apariencia.edit', 'Editar', array($apariencium->id_apariencium), array('class' => 'btn btn-info')) }}
            </td>
        </tr>
        </tbody>
    </table>
@endsection