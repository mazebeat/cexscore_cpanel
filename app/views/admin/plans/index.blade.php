@extends('layouts.cpanel')

@section('title')
    Todos Planes
@endsection

@section('page-title')
    <i class="fa fa-home fa-fw"></i>Todos Planes
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Planes</li>
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

    <p>{{ link_to_route('admin.plans.create', 'Agregar Nuevo Plan', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if ($plans->count())
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Plan</th>
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($plans as $plan)
                <tr>
                    <td>{{ $plan->descripcion_plan }}</td>
                    <td class="pull-right">
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.plans.destroy', $plan->id_plan))) }}
                        {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('admin.plans.edit', 'Editar', array($plan->id_plan), array('class' => 'btn btn-info')) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $plans->links() }}
    @else
        No se han encontrado plans.
    @endif
@endsection