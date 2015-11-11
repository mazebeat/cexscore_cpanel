<div class="form-group">
	{{ Form::label('apariencia[logo_header]', 'Imágen Header:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::file('apariencia[logo_header]', ['required']) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('apariencia[logo_incentivo]', 'Imágen Incentivo:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::file('apariencia[logo_incentivo]', ['required']) }}
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_header]', 'Color Header:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('apariencia[color_header]', Input::old('apariencia[color_header]'), array('class'=>'form-control', 'placeholders'=>'Color_header')) }}
		</div>
	</div>

	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_body]', 'Color Body:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('apariencia[color_body]', Input::old('apariencia[color_body]'), array('class'=>'form-control', 'placeholders'=>'Color_body')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_footer]', 'Color Footer:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('apariencia[color_footer]', Input::old('apariencia[color_footer]'), array('class'=>'form-control', 'placeholders'=>'Color_footer')) }}
		</div>
	</div>

	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_opciones]', 'Color Opciones:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::select('apariencia[color_opciones]', ['red' => 'Rojo', 'green' => 'Verde', 'blue' => 'Azul', 'grey' => 'Gris', 'orange' => 'Naranjo', 'yellow' => 'Amarillo', 'pink' => 'Rosado', 'purple' => 'Morado'], Input::old('apariencia[color_opciones]'), array('class'=>'form-control', 'placeholders'=>'Color Opciones')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_boton]', 'Color Botón:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('apariencia[color_boton]', Input::old('apariencia[color_boton]'), array('class'=>'form-control', 'placeholders'=>'Color_boton')) }}
		</div>
	</div>

	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_text_header]', 'Color Texto Header:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('apariencia[color_text_header]', Input::old('apariencia[color_text_header]'), array('class'=>'form-control', 'placeholders'=>'Color_text_header')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_text_body]', 'Color Texto Body:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('apariencia[color_text_body]', Input::old('apariencia[color_text_body]'), array('class'=>'form-control', 'placeholders'=>'Color_text_body')) }}
		</div>
	</div>

	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_text_footer]', 'Color Texto Footer:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('apariencia[color_text_footer]', Input::old('apariencia[color_text_footer]'), array('class'=>'form-control', 'placeholders'=>'Color_text_footer')) }}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group col-sm-6">
		{{ Form::label('apariencia[color_instrucciones]', 'Color Instrucciones:', array('class'=>'col-md-4 control-label')) }}
		<div class="col-sm-8">
			{{ Form::color('apariencia[color_instrucciones]', Input::old('apariencia[color_instrucciones]'), array('class'=>'form-control', 'placeholders'=>'Color_instrucciones')) }}
		</div>
	</div>
</div>

{{--<div class="row">--}}
	{{--<div class="form-group">--}}
		{{--{{ Form::label('apariencia[desea_captura_datos]', 'Desea Capturar Datos?:', array('class'=>'col-md-2 control-label')) }}--}}
		{{--<div class="col-sm-10">--}}
			{{--<div class="checkbox">--}}
				{{--<label>--}}
					{{--{{ Form::checkbox('apariencia[desea_captura_datos]', Input::old('apariencia[desea_captura_datos]'), false, array('class'=>'form-control')) }}--}}
				{{--</label>--}}
			{{--</div>--}}
		{{--</div>--}}
	{{--</div>--}}
{{--</div>--}}