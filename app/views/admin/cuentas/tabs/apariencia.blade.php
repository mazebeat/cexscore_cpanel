<div class="form-group">
    {{ Form::label('apariencia[logo_header]', 'Imagen Header:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::file('apariencia[logo_header]', ['']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('apariencia[logo_incentivo]', 'Imagen Incentivo:', array('class'=>'col-md-2 control-label')) }}
    <div class="col-sm-10">
        {{ Form::file('apariencia[logo_incentivo]', ['']) }}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('apariencia[color_header]', 'Color Header:', array('class'=>'col-md-4 control-label')) }}
        <div class="col-sm-8">
            {{ Form::color('apariencia[color_header]', Input::old('apariencia[color_header]', '#ffffff'), array('class'=>'form-control', 'placeholders'=>'Color_header')) }}
        </div>
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('apariencia[color_body]', 'Color Body:', array('class'=>'col-md-4 control-label')) }}
        <div class="col-sm-8">
            {{ Form::color('apariencia[color_body]', Input::old('apariencia[color_body]', '#ffffff'), array('class'=>'form-control', 'placeholders'=>'Color_body')) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('apariencia[color_footer]', 'Color Footer:', array('class'=>'col-md-4 control-label')) }}
        <div class="col-sm-8">
            {{ Form::color('apariencia[color_footer]', Input::old('apariencia[color_footer]', '#454545'), array('class'=>'form-control', 'placeholders'=>'Color_footer')) }}
        </div>
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('apariencia[color_opciones]', 'Color Opciones:', array('class'=>'col-md-4 control-label')) }}
        <div class="col-sm-8">
            {{ Form::select2('apariencia[color_opciones]', ['red' => 'Rojo', 'green' => 'Verde', 'blue' => 'Azul', 'grey' => 'Gris', 'orange' => 'Naranjo', 'yellow' => 'Amarillo', 'pink' => 'Rosado', 'purple' => 'Morado'], Input::old('apariencia[color_opciones]', 'orange'), array('class'=>'form-control', 'placeholders'=>'Color Opciones')) }}
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
            {{ Form::color('apariencia[color_text_header]', Input::old('apariencia[color_text_header]', '#0b0b0b'), array('class'=>'form-control', 'placeholders'=>'Color_text_header')) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('apariencia[color_text_body]', 'Color Texto Body:', array('class'=>'col-md-4 control-label')) }}
        <div class="col-sm-8">
            {{ Form::color('apariencia[color_text_body]', Input::old('apariencia[color_text_body]', '#1a1a1a'), array('class'=>'form-control', 'placeholders'=>'Color_text_body')) }}
        </div>
    </div>

    <div class="form-group col-sm-6">
        {{ Form::label('apariencia[color_text_footer]', 'Color Texto Footer:', array('class'=>'col-md-4 control-label')) }}
        <div class="col-sm-8">
            {{ Form::color('apariencia[color_text_footer]', Input::old('apariencia[color_text_footer]', '#ffffff'), array('class'=>'form-control', 'placeholders'=>'Color_text_footer')) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
        {{ Form::label('apariencia[color_instrucciones]', 'Color Instrucciones:', array('class'=>'col-md-4 control-label')) }}
        <div class="col-sm-8">
            {{ Form::color('apariencia[color_instrucciones]', Input::old('apariencia[color_instrucciones]', '#151515'), array('class'=>'form-control', 'placeholders'=>'Color_instrucciones')) }}
        </div>
    </div>
</div>