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
	{{ Form::label('usuario[email]', 'Email:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::email('usuario[email]', Input::old('usuario[email]'), array('class'=>'form-control', 'placeholder'=>'Correo', 'required')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[fecha_nacimiento]', 'Fecha Nacimiento:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::input('date', 'usuario[fecha_nacimiento]', Input::old('usuario[fecha_nacimiento]'), array('id'=> 'usuarioFechaNacimiento', 'class'=>'form-control', 'placeholder'=>'Fecha Nacimiento', 'data-mask', 'min' => '1979-12-31', 'max' => Carbon::now()->toDateString())) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[genero]', 'Genero:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::select2('usuario[genero]', ['' => '','F' => 'Femenino', 'M' => 'Masculino'], Input::old('usuario[genero]'), array('class'=>'form-control', 'placeholder'=>'Genero_usuario')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[linkedlin]', 'LinkedIn:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::url('usuario[linkedlin]', Input::old('linkedlin]'), array('class'=>'form-control', 'placeholder'=>'LinkedIn Usuario')) }}
	</div>
</div>

<div class="form-group">
	{{ Form::label('usuario[rol_organizacion]', 'Rol Organización:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::select2('usuario[rol_organizacion]', ['null' => '', 'Servicio' => 'Servicio', 'Marketing' => 'Marketing', 'Ventas/Comercial' => 'Ventas/Comercial', 'Finanzas' => 'Finanzas', 'Dirección' => 'Dirección', 'Operaciones' => 'Operaciones'], Input::old('usuario[rol_organizacion]'), array('class'=>'form-control')) }}
	</div>
</div>

{{ Form::input('hidden', 'usuario[id_cliente]', Input::old('usuario[id_cliente]', Auth::user()->cliente->id_cliente), array('class'=>'form-control')) }}