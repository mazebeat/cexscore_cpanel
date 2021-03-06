{{ Form::model($cliente, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.cuentas.update', $cliente->id_cliente))) }}

{{ Form::input('hidden', 'accion', 'update.account', array('class'=>'form-control')) }}
<div class="form-group">
    {{ Form::label('rut_cliente', 'RUT:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::text('rut_cliente', Input::old('rut_cliente', $cliente->rut_cliente), array('id' => 'rut_cliente', 'class'=>'form-control', 'placeholders'=>'Rut Cliente', 'required', 'readonly')) }}
        {{ Form::hidden('id_estado', Input::old('id_estado', 1), array('class'=>'form-control', 'placeholders'=>'Rut Cliente', 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('nombre_cliente', 'Nombre Empresa:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::text('nombre_cliente', Input::old('nombre_cliente', $cliente->nombre_cliente), array('class'=>'form-control', 'placeholders'=>'Nombre Cliente', 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('nombre_legal_cliente', 'Nombre Legal:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::text('nombre_legal_cliente', Input::old('nombre_legal_cliente', $cliente->nombre_legal_cliente), array('class'=>'form-control', 'placeholders'=>'Nombre Legal', '')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('id_sector', 'Sector Empresarial:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::select2('id_sector', $sectors, Input::old('id_sector', $cliente->id_sector), array('id'=> 'id_sector', 'class'=>'form-control', 'required')) }}
        {{ Form::hidden('id_encuesta', Input::old('id_encuesta', $cliente->encuesta->id_encuesta), array('id'=> 'id_encuesta', 'class'=>'form-control', 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('fono_fijo_cliente', 'Fono Fijo:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::number('fono_fijo_cliente', null, Input::old('fono_fijo_cliente', $cliente->fono_fijo_cliente), array('class'=>'form-control', 'placeholders'=>'+56 9 2123 4567', '', 'minmax' =>false)) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('fono_celular_cliente', 'Fono Celular:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::number('fono_celular_cliente', null, Input::old('fono_celular_cliente', $cliente->fono_celular_cliente), array('class'=>'form-control', 'placeholders'=>'+56 9 9123 4567', '', 'minmax' =>false)) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('correo_cliente', 'Web Site:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::url('correo_cliente', Input::old('correo_cliente', $cliente->correo_cliente), array('class'=>'form-control', 'placeholders'=>'Correo Cliente')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('codigo_postal_cliente', 'Código Postal:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::number('codigo_postal_cliente', Input::old('codigo_postal_cliente', $cliente->codigo_postal_cliente), null, array('class'=>'form-control', 'placeholders'=>'Código Postal', '', 'minmax' => false)) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('id_pais', 'País:', array('class'=>'col-md-2 control-label ')) }}
    <div class="col-sm-10">
        {{ Form::select2('id_pais', $pais, Input::old('id_pais', $cliente->id_pais), array('id' => 'fieldPais', 'class'=>'form-control' , 'required')) }}
    </div>
</div>

<div class="form-group fieldRegion" style="{{ (is_null($idregion) ? 'display:none;' : '') }}">
    {{ Form::label('region', 'Regi&oacute;n:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::select2('region', $regions, Input::old('region', $idregion), array('id' => 'fieldRegion','class'=>'form-control' , 'required')) }}
    </div>
</div>

<div class="form-group fieldCiudad" style="{{ (is_null($idregion) ? 'display:none;' : '') }}">
    {{ Form::label('id_ciudad', 'Ciudad:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::select2('id_ciudad', $ciudads, Input::old('id_ciudad', $cliente->id_ciudad), array('id' => 'fieldCiudad', 'class'=>'form-control '  . (is_null($cliente->id_pais) ? 'hidden' : '')  , 'required')) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('direccion_cliente', 'Direcci&oacute;n:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::text('direccion_cliente', Input::old('direccion_cliente'), array('id' => '', 'class'=>'form-control', 'placeholders'=>'Direcci&oacute;n Cliente' , 'required')) }}
        {{ Form::hidden('id_plan', Input::old('id_plan'), array('class'=>'form-control')) }}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>

    <div class="col-sm-10">
        {{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
    </div>
</div>

{{ Form::close() }}