{{ Form::model($cliente, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.cuentas.update', $cliente->id_cliente))) }}

{{ Form::input('hidden', 'accion', 'update.moments', array('class'=>'form-control')) }}

@foreach($momentoencuestum as $key => $value)
	<div class="form-group">
		{{ Form::label('momentos['.$key.'][id_momento]', 'Momento ' . ($key + 1) . ':', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('hidden', 'momentos['.$key.'][id_encuesta]', Input::old('momentos['.$key.'][id_encuesta]', trim($value->id_encuesta)), array('class'=>'form-control')) }}
			{{ Form::input('hidden', 'momentos['.$key.'][id_momento]', Input::old('momentos['.$key.'][id_momento]', trim($value->id_momento)), array('class'=>'form-control')) }}
{{--			{{ Form::text('momentos['.$key.'][descripcion_momento]', Input::old('momentos['.$key.'][descripcion_momento]', trim($value->pivot->descripcion_momento)), array('class'=>'form-control')) }}--}}
			{{ Form::text('momentos['.$key.'][descripcion_momento]', Input::old('momentos['.$key.'][descripcion_momento]', trim($value->descripcion_momento)), array('class'=>'form-control')) }}
		</div>
	</div>
@endforeach
<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>

	<div class="col-sm-10">
		{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
	</div>
</div>

{{ Form::close() }}