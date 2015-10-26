@extends('layouts.cpanel')

@section('title')
	Ver Estado
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Ver Estado
@endsection

@section('breadcrumb')
	@parent
	<li>Estados</li>
	<li class="active">Ver</li>
@endsection

@section('content')
<p>{{ link_to_route('admin.estados.index', 'Volver a estados', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped table-condensed table-hover">
	<thead>
		<tr>
			<th>Id_estado</th>
				<th>Tipo_estado</th>
				<th>Descripcion_estado</th>
		</tr>
	</thead>
    <tbody>
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
	</tbody>
</table>
@endsection