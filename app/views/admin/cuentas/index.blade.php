@extends('layouts.cpanel')

@section('title')
	Todos cuentas
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Cuentas
@endsection

@section('breadcrumb')
	@parent
	<li class="active"><a href="{{ url('admin/cuentas')  }}">Cuenta</a></li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.cuentas.create', 'Agregar Nueva Cuenta', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($cuentas->count())
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
			@foreach ($cuentas as $cliente)
				<tr>
					<td>{{{ $cliente->rut_cliente }}}</td>
					<td>{{{ $cliente->nombre_cliente }}}</td>
					<td>{{{ $cliente->fono_cliente }}}</td>
					<td>{{{ $cliente->correo_cliente }}}</td>
					<td>
						{{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.cuentas.destroy', $cliente->id_cliente))) }}
						{{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
						{{ link_to_route('admin.cuentas.edit', 'Editar', array($cliente->id_cliente), array('class' => 'btn btn-info')) }}
						{{ link_to_action('CuentasController@resumen', 'Resumen', array($cliente->id_cliente), array('class' => 'btn btn-link')) }}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		No se han encontrado cuentas.
	@endif
@endsection
