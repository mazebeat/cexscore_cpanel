{{ Form::model($cliente, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.cuentas.update', $cliente->id_cliente))) }}

{{ Form::input('hidden', 'accion', 'update.skin', array('class'=>'form-control')) }}

<div class="form-group">
	{{ Form::label('logo_header', 'Imágen Header:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::file('logo_header', ['required']) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('logo_incentivo', 'Imágen Incentivo:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::file('logo_incentivo', ['required']) }}
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('color_header', 'Color Header:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('color_header', Input::old('color_header'), array('class'=>'form-control', 'placeholders'=>'Color_header')) }}
		</div>
	</div>

	<div class="form-group col-sm-6">
		{{ Form::label('color_body', 'Color Body:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('color_body', Input::old('color_body'), array('class'=>'form-control', 'placeholders'=>'Color_body')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('color_footer', 'Color Footer:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('color_footer', Input::old('color_footer'), array('class'=>'form-control', 'placeholders'=>'Color_footer')) }}
		</div>
	</div>

	<div class="form-group col-sm-6">
		{{ Form::label('color_opciones', 'Color Opciones:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::select('color_opciones', ['red' => 'Rojo', 'green' => 'Verde', 'blue' => 'Azul', 'grey' => 'Gris', 'orange' => 'Naraja', 'yellow' => 'Amarillo', 'pink' => 'Rosado', 'purple' => 'Morado'], Input::old('color_opciones'), array('class'=>'form-control', 'placeholders'=>'Color Opciones')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('color_boton', 'Color Botón:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('color_boton', Input::old('color_boton'), array('class'=>'form-control', 'placeholders'=>'Color_boton')) }}
		</div>
	</div>

	<div class="form-group col-sm-6">
		{{ Form::label('color_text_header', 'Color Texto Header:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('color_text_header', Input::old('color_text_header'), array('class'=>'form-control', 'placeholders'=>'Color_text_header')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('color_text_body', 'Color Texto Body:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('color_text_body', Input::old('color_text_body'), array('class'=>'form-control', 'placeholders'=>'Color_text_body')) }}
		</div>
	</div>

	<div class="form-group col-sm-6">
		{{ Form::label('color_text_footer', 'Color Texto Footer:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('color_text_footer', Input::old('color_text_footer'), array('class'=>'form-control', 'placeholders'=>'Color_text_footer')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('color_instrucciones', 'Color Instrucciones:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('color_instrucciones', Input::old('color_instrucciones'), array('class'=>'form-control', 'placeholders'=>'Color_instrucciones')) }}
		</div>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">&nbsp;</label>

	<div class="col-sm-10">
		{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
	</div>
</div>

{{ Form::close() }}