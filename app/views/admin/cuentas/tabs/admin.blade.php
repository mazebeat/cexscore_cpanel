<div class="form-group">
	{{ Form::label('usuario[nombre_usuario]', 'Nombres:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('usuario[nombre_usuario]', Input::old('nombre_usuario]'), array('class'=>'form-control', 'placeholder'=>'Nombres', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[apellido_usuario]', 'Apellidos:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('usuario[apellido_usuario]', Input::old('apellido_usuario]'), array('class'=>'form-control', 'placeholder'=>'Apellidos', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[correo_usuario]', 'Email:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::email('usuario[correo_usuario]', Input::old('usuario[correo_usuario]'), array('class'=>'form-control', 'placeholder'=>'Correo', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[fecha_nacimiento]', 'Fecha Nacimiento:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::input('date', 'fecha_nacimiento', Input::old('fecha_nacimiento'), array('id'=> 'usuarioFechaNacimiento', 'class'=>'form-control', 'placeholder'=>'Fecha Nacimiento', 'data-mask', 'min' => '1979-12-31', 'max' => Carbon::now()->toDateString())) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[genero_usuario]', 'Genero:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::select('usuario[genero_usuario]', ['' => '','F' => 'Femenino', 'M' => 'Masculino'], Input::old('usuario[genero_usuario]'), array('class'=>'form-control', 'placeholder'=>'Genero_usuario')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[linkedlin_usuario]', 'LinkedlIn:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::url('usuario[linkedlin_usuario]', Input::old('linkedlin_usuario]'), array('class'=>'form-control', 'placeholder'=>'Linkedlin_usuario')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[rol_organizacion_usuario]', 'Rol Organización:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::select('usuario[rol_organizacion_usuario]', ['0' => '', '1' => 'Servicio', '2' => 'Marketing', '3' => 'Ventas/Comercial', '4' => 'Finanzas', '5' => 'Dirección', '6' => 'Operaciones'], Input::old('usuario[rol_organizacion_usuario]'), array('class'=>'form-control')) }}
	</div>
</div>

{{ Form::input('hidden', 'usuario[id_cliente]', Input::old('usuario[id_cliente]', Auth::user()->cliente->id_cliente), array('class'=>'form-control')) }}