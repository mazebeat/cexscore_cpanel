@extends('layouts.cpanel')

@section('title')
	Todos Pregunta_cabeceras
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Todos Pregunta_cabeceras
@endsection

@section('breadcrumb')
	@parent
	<li class="active">Pregunta_cabeceras</li>
@endsection

@section('content')
	<p>{{ link_to_route('admin.pregunta_cabeceras.create', 'Agregar Nuevo Pregunta_cabecera', null, array('class' => 'btn btn-lg btn-success')) }}</p>

	@if ($pregunta_cabeceras->count())
		<table class="table table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>Descripcion_1</th>
				<th>Descripcion_2</th>
				<th>Descripcion_3</th>
				<th>Numero_pregunta</th>
				<th>Id_pregunta_padre</th>
				<th>Id_encuesta</th>
				<th>Id_categoria</th>
				<th>Id_tipo_respuesta</th>
				<th>Id_estado</th>
					<th>&nbsp;</th>
				</tr>
			</thead>

			<tbody>
				@foreach ($pregunta_cabeceras as $pregunta_cabecera)
					<tr>
						<td>{{{ $pregunta_cabecera->descripcion_1 }}}</td>
					<td>{{{ $pregunta_cabecera->descripcion_2 }}}</td>
					<td>{{{ $pregunta_cabecera->descripcion_3 }}}</td>
					<td>{{{ $pregunta_cabecera->numero_pregunta }}}</td>
					<td>{{{ $pregunta_cabecera->id_pregunta_padre }}}</td>
					<td>{{{ $pregunta_cabecera->id_encuesta }}}</td>
					<td>{{{ $pregunta_cabecera->id_categoria }}}</td>
					<td>{{{ $pregunta_cabecera->id_tipo_respuesta }}}</td>
					<td>{{{ $pregunta_cabecera->id_estado }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.pregunta_cabeceras.destroy', $pregunta_cabecera->id_pregunta_cabecera))) }}
                            {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('admin.pregunta_cabeceras.edit', 'Editar', array($pregunta_cabecera->id_pregunta_cabecera), array('class' => 'btn btn-info')) }}
                    </td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		 No se han encontrado pregunta_cabeceras.
	@endif
@endsection
