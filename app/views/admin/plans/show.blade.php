@extends('layouts.cpanel')

@section('title')
	Ver Plan
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Plan
@endsection

@section('breadcrumb')
	@parent
	<li><a href="{{ URL::previous() }}">Planes</a></li></li>
	<li class="active">Ver</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.plans.index', 'Volver a planes', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

	<table class="table table-striped table-condensed table-hover">
		<thead>
		<tr>
			<th>Descripción Plan</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>{{{ $plan->descripcion_plan }}}</td>
			<td>
				{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.plans.destroy', $plan->id_plan))) }}
				{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
				{{ Form::close() }}
				{{ link_to_route('admin.plans.edit', 'Editar', array($plan->id_plan), array('class' => 'btn btn-info')) }}
			</td>
		</tr>
		</tbody>
	</table>
@endsection