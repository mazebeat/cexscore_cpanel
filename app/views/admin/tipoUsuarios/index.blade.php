@extends('layouts.cpanel')

@section('title')
	Todos TipoUsuarios
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos TipoUsuarios
@endsection

@section('breadcrumb')
	@parent
	<li class="active">TipoUsuarios</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.tipoUsuarios.create', 'Agregar Nuevo TipoUsuario', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($tipoUsuarios->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>Descripcion_tipo_cliente</th>
					<th>&nbsp;</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($tipoUsuarios as $tipoUsuario)
					<tr>
						<td>{{{ $tipoUsuario->descripcion_tipo_cliente }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.tipoUsuarios.destroy', $tipoUsuario->id_tipoUsuario))) }}
                            {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('admin.tipoUsuarios.edit', 'Editar', array($tipoUsuario->id_tipoUsuario), array('class' => 'btn btn-info')) }}
                    </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		 No se han encontrado tipoUsuarios.
	@endif
@endsection
