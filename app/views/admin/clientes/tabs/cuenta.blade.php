<div class="form-group">
	{{ Form::label('cliente[rut_cliente]', 'RUT:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('cliente[rut_cliente]', Input::old('cliente[rut_cliente]'), array('id' => 'rut_cliente', 'class'=>'form-control', 'placeholders'=>'Rut Cliente', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[nombre_cliente]', 'Nombre Empresa:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('cliente[nombre_cliente]', Input::old('cliente[nombre_cliente]'), array('class'=>'form-control', 'placeholders'=>'Nombre Cliente', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[nombre_legal_cliente]', 'Nombre Legal:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('cliente[nombre_legal_cliente]', Input::old('cliente[nombre_legal_cliente]'), array('class'=>'form-control', 'placeholders'=>'Nombre Legal', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('id_sector', 'Sector Empresarial:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::select2('cliente[id_sector]', $sectors,Input::old('id_sector'), array('class'=>'form-control')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[fono_fijo_cliente]', 'Fono Fijo:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('cliente[fono_fijo_cliente]', Input::old('cliente[fono_fijo_cliente]'), array('class'=>'form-control', 'placeholders'=>'+56 9 2123 4567', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[fono_celular_cliente]', 'Fono Celular:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('cliente[fono_celular_cliente]', Input::old('cliente[fono_celular_cliente]'), array('class'=>'form-control', 'placeholders'=>'+56 9 9123 4567', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[correo_cliente]', 'Email:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::email('cliente[correo_cliente]', Input::old('cliente[correo_cliente]'), array('class'=>'form-control', 'placeholders'=>'Correo Cliente', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[codigo_postal_cliente]', 'Código Postal:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('cliente[codigo_postal_cliente]', Input::old('cliente[codigo_postal_cliente]'), array('class'=>'form-control', 'placeholders'=>'Código Postal', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[pais]', 'Pais:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::select2('cliente[pais]', $pais, Input::old('cliente[pais'), array('id' => 'fieldPais', 'class'=>'form-control' , 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[region]', 'Regi&oacute;n:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10 fieldRegion">
		{{ Form::select2('cliente[region]', [], Input::old('cliente[region]'), array('id' => 'fieldRegion','class'=>'form-control' , 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[id_ciudad]', 'Ciudad:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10 fieldCiudad">
		{{ Form::select2('cliente[id_ciudad]', [], Input::old('cliente[id_ciudad]'), array('id' => 'fieldCiudad', 'class'=>'form-control' , 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('cliente[direccion_cliente]', 'Direcci&oacute;n:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('cliente[direccion_cliente]', Input::old('cliente[direccion_cliente]'), array('id' => 'fieldCiudad', 'class'=>'form-control', 'placeholders'=>'Direcci&oacute;n Cliente' , 'required')) }}
	</div>
</div>