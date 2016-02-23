<style>
    .respuesta {
        border-bottom-style: dotted;
        border-width: 1px;
    }
</style>
<p>Y para terminar, por favor complete con los siguientes datos:</p>
<article class="">
    <div class="row">
        {{ \Form::label('rut', 'RUT:', array('class' => 'col-xs-3 control-label')) }}
        <div class="col-xs-9 respuesta">
            &nbsp;
        </div>
    </div>
    <div class="row">
        {{ \Form::label('name', 'Nombre:', array('class' => 'col-xs-3 control-label')) }}
        <div class="col-xs-9 respuesta">
            &nbsp;
        </div>
    </div>
    <div class="row">
        {{ \Form::label('age', 'Fecha de Nacimiento:', array('class' => 'col-xs-3 control-label')) }}
        <div class="col-xs-9 respuesta">
            &nbsp;
        </div>
    </div>
    <div class="row">

        <div class="col-xs-3">
            {{ \Form::label('gender', "G&eacute;nero", array('class' => 'control-label')) }} &nbsp;(m/f)<strong>:</strong>
        </div>
        <div class="col-xs-9 respuesta">
            &nbsp;
        </div>

    </div>
    <div class="row">
        {{ \Form::label('email', 'E-Mail:', array('class' => 'col-xs-3 control-label')) }}
        <div class="col-xs-9 respuesta">
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10">
            <div class="checkbox">
                <label>{{ \Str::hes('No quiero recibir información vía e-mail') }}&nbsp;&nbsp;{{ Form::checkbox('wish_email', 1, false, array('class' => 'form-control')) }}                </label>
            </div>
        </div>
    </div>
</article>