{{ Form::model($cliente, array('id' => 'form-moments', 'class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.cuentas.update', $cliente->id_cliente))) }}

{{ Form::input('hidden', 'accion', 'update.moments', array('class'=>'form-control')) }}

@foreach($momentoencuestum as $key => $value)
    <div class="form-group momento" data-id="{{ $key }}">
        {{ Form::label('momentos['.$key.'][id_momento]', 'Momento ' . ($key + 1) . ':', array('class'=>'col-xs-2 col-md-2 control-label')) }}
        <div class="col-xs-9 col-sm-9">
            {{ Form::input('hidden', 'momentos['.$key.'][id_encuesta]', Input::old('momentos['.$key.'][id_encuesta]', trim($value->id_encuesta)), array('class'=>'form-control')) }}
            {{ Form::input('hidden', 'momentos['.$key.'][id_momento]', Input::old('momentos['.$key.'][id_momento]', trim($value->id_momento)), array('class'=>'form-control')) }}
            {{ Form::text('momentos['.$key.'][descripcion_momento]', Input::old('momentos['.$key.'][descripcion_momento]', trim($value->descripcion_momento)), array('class'=>'form-control col-xs-10')) }}
        </div>
        <div class="col-xs-1 col-sm-1">
            <a href="{{ URL::route('admin.cuentas.destroy', ['id' => $cliente->id_cliente]) }}" data-toggle="tooltip" data-accion="delete.moments" data-moment="{{ trim($value->id_momento) }}" data-delete="{{ csrf_token() }}" title="Eliminar"
               class="btn btn-default pull-right"><i class="fa fa-trash-o"></i></a>
        </div>
    </div>
@endforeach

<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>

    <div class="col-sm-10">
        <input type="button" class="btn btn-lg btn-info pull-right" value="Agregar" id="addMoments"/>
        {{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
    </div>
</div>

{{ Form::close() }}

<!-- The template for adding new field -->
<div class="form-group momento hide" id="optionTemplate">
    {{ Form::label('momentos[?][id_momento]', 'Momento ?+1 :', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-9">
        {{ Form::input('hidden', 'id_encuesta', $cliente->encuesta->first()->id_encuesta, array('class'=>'form-control')) }}
        {{ Form::input('hidden', 'id_momento', null, array('class'=>'form-control')) }}
        {{ Form::text('descripcion_momento', null, array('class'=>'form-control')) }}
    </div>
    <div class="col-sm-1">
    </div>
</div>

<script>

</script>