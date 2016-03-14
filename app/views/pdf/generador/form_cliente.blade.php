{{--<article class="col-md-offset-2 col-lg-offset-2 col-xs-12 col-sm-12 col-md-8 col-lg-8">--}}
<article class="col-xs-12 datos_personales" style="margin-top:40px;">
	<p style="font-size: 15px;">Y para terminar, por favor complete con los siguientes datos:</p>

	<div class="row">
		{{ \Form::label('rut', 'RUT:', array('class' => 'col-xs-5 control-label')) }}
		<div class="col-xs-7 respuesta">
			&nbsp;
		</div>
	</div>
	{{-- Rut Message Container --}}
	<div class="messageContainer"></div>
	<div class="row">
		{{ \Form::label('name', 'Nombre:', array('class' => 'col-xs-5 control-label')) }}
		<div class="col-xs-7 respuesta">
			&nbsp;
		</div>
	</div>
	{{-- Name Message Container --}}
	<div class="messageContainer"></div>
	<div class="row">
		{{ \Form::label('age', 'Fecha de Nacimiento:', array('class' => 'col-xs-5 control-label')) }}
		<div class="col-xs-7 respuesta">
			&nbsp;
		</div>
	</div>
	{{-- Age Message Container --}}
	<div class="messageContainer"></div>
	<div class="row">
		<div class="col-xs-5">
			{{ \Form::label('gender', 'G&eacute;nero', array('class' => 'control-label')) }}
			<label for="gender" class="control-label">&nbsp;M/F<strong>:</strong></label>
		</div>
		<div class="col-xs-7 respuesta">
			&nbsp;
		</div>
	</div>
	{{-- Genero Message Container --}}
	<div class="messageContainer"></div>
	<div class="row">
		{{ \Form::label('email', 'E-Mail:', array('class' => 'col-xs-5 control-label')) }}
		<div class="col-xs-7 respuesta">
			&nbsp;
		</div>
	</div>
	{{-- Mail Message Container --}}
	<div class="messageContainer"></div>
	<div class="row">
		<!--<div class="col-sm-10">-->
		<div class="checkbox">
			<div class="col-xs-5">
				{{ \Str::hes('No quiero recibir información vía e-mail') }}
			</div>
			<div class="col-xs-7" style="padding-left: 0;">
				{{ Form::checkbox('wish_email', 1, false, array('class' => 'form-control')) }}
			</div>
			{{--<label>
                {{ \Str::hes('No quiero recibir información vía e-mail') }}
                &nbsp;&nbsp;
                {{ Form::checkbox('wish_email', 1, false, array('class' => 'form-control')) }}
            </label>--}}
		</div>
		<!--</div>-->
	</div>
	{{-- WishMail Message Container --}}
	<div class="messageContainer"></div>
</article>