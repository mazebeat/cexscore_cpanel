@extends('layouts.cpanel')

@section('title')
	Ver TipoUsuario
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver TipoUsuario
@endsection

@section('breadcrumb')
	@parent
	<li>TipoUsuarios</li>
	<li class="active">Ver</li>
@endsection

@section('content')
<p>{{ link_to_route('admin.tipoUsuarios.index', 'Volver a tipoUsuarios', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped table-condensed table-hover">
	<thead>
		<tr>
			<th>Descripcion_tipo_cliente</th>
		</tr>
	</thead>
    <tbody>
		<tr>
			<td>{{{ $tipoUsuario->descripcion_tipo_cliente }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.tipoUsuarios.destroy', $tipoUsuario->id_tipoUsuario))) }}
                            {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('admin.tipoUsuarios.edit', 'Editar', array($tipoUsuario->id_tipoUsuario), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>
@endsection