{{ Form::model($cliente, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.cuentas.update', $cliente->id_cliente))) }}

<div class="form-group">
	{{ Form::label('rut_cliente', 'Plan:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::select('id_plan', Plan::lists('descripcion_plan', 'id_plan'), Input::old('id_plan'), array('class'=>'form-control', 'placeholder'=>'Rut_cliente')) }}
	</div>
</div>

{{ Form::input('hidden', 'accion', 'update.plan', array('class'=>'form-control')) }}

<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>

	<div class="col-sm-10">
		{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
	</div>
</div>

{{ Form::close() }}