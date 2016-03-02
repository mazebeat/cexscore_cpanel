@extends('layouts.cpanel')

@section('title')
    Encuestas
@endsection

@section('page-title')
    <i class="fa fa-home fa-fw"></i>Encuestas
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Encuesta</li>
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

    @if ($encuesta->count())
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th style="width: 5%;">Título</th>
                <th style="width: 70%;">Descripción</th>
                <th style="width: 20%;">&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($encuesta as $encuestum)
                <tr>
                    <td>{{ $encuestum->titulo }}</td>
                    <td>{{ str_limit($encuestum->description, $limit = 80, $end = '...') }}</td>
                    <td class="pull-right">
                        {{ link_to_route('admin.encuesta.edit', 'Editar', array($encuestum->id_encuesta), array('class' => 'btn btn-info')) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $encuesta->links() }}
    @else
        No se han encontrado encuesta.
    @endif
@endsection
