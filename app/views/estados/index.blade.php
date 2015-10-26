@extends('layouts.cpanel')

@section('title')
	Todos Estados
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Estados
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Estados</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.estados.create', 'Agregar Nuevo Estado', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($estados->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>Id_estado</th>
				<th>Tipo_estado</th>
				<th>Descripcion_estado</th>
					<th>&nbsp;</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($estados as $estado)
					<tr>
						<td>{{{ $estado->id_estado }}}</td>
					<td>{{{ $estado->tipo_estado }}}</td>
					<td>{{{ $estado->descripcion_estado }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.estados.destroy', $estado->id_estado))) }}
                            {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('admin.estados.edit', 'Editar', array($estado->id_estado), array('class' => 'btn btn-info')) }}
                    </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		 No se han encontrado estados.
	@endif
@endsection
