@extends('layouts.cpanel')

@section('title')
	Todos Plans
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Plans
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Plans</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.plans.create', 'Agregar Nuevo Plan', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($plans->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>Descripción Plan</th>
				<th>&nbsp;</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($plans as $plan)
				<tr>
					<td>{{{ $plan->descripcion_plan }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.plans.destroy', $plan->id_plan))) }}
						{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('admin.plans.edit', 'Editar', array($plan->id_plan), array('class' => 'btn btn-info')) }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado plans.
	@endif
@endsection
