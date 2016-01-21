@extends('layouts.cpanel')

@section('title')
    Todas Encuestas
@endsection

@section('page-title')
    <i class="fa fa-home fa-fw"></i>Todas Encuestas
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Encuesta</li>
@endsection

@section('content')
    {{--	<p>{{ link_to_route('admin.encuesta.create', 'Agregar Nueva Encuesta', null, array('class' => 'btn btn-lg btn-success')) }}</p>--}}

    @if ($encuesta->count())
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th style="width: 5%;">Título</th>
                <th style="width: 5%;">Subtítulo</th>
                <th style="width: 70%;">Descripción</th>
                <th style="width: 20%;">&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($encuesta as $encuestum)
                <tr>
                    <td>{{ $encuestum->titulo }}</td>
                    <td>{{ $encuestum->slogan }}</td>
                    <td>{{ str_limit($encuestum->description, $limit = 80, $end = '...') }}</td>
                    <td class="pull-right">
                        {{--{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.encuesta.destroy', $encuestum->id_encuesta))) }}--}}
                        {{--{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}--}}
                        {{--{{ Form::close() }}--}}
                        {{ link_to_route('admin.encuesta.edit', 'Editar', array($encuestum->id_encuesta), array('class' => 'btn btn-info')) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        No se han encontrado encuesta.
    @endif
@endsection
