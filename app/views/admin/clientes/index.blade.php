@extends('layouts.cpanel')

@section('title')
	Todos Clientes
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Clientes
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Clientes</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.clientes.create', 'Agregar Nuevo Cliente', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($clientes->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>RUT</th>
				<th>Nombre</th>
				<th>Fono</th>
				<th>Correo</th>
				<th>&nbsp;</th>
			</tr>
			</thead>

			<tbody>
			@foreach ($clientes as $cliente)
				<tr>
					<td>{{{ $cliente->rut_cliente }}}</td>
					<td>{{{ $cliente->nombre_cliente }}}</td>
					<td>{{{ $cliente->fono_cliente }}}</td>
					<td>{{{ $cliente->correo_cliente }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.clientes.destroy', $cliente->id_cliente))) }}
						{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('admin.clientes.edit', 'Editar', array($cliente->id_cliente), array('class' => 'btn btn-info')) }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado clientes.
	@endif
@endsection
