<div class="form-group">
	{{ Form::label('encuesta[titulo]', 'T&iacute;tulo:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('encuesta[titulo]', Input::old('encuesta[titulo]'), array('class'=>'form-control', 'placeholders'=>'T&iacute;tulo de la Encuesta')) }}
	</div>
</div>

{{--<div class="form-group">--}}
	{{--{{ Form::label('encuesta[slogan]', 'Subtitulo (eslogan):', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
		{{--{{ Form::text('encuesta[slogan]', Input::old('encuesta[slogan]'), array('class'=>'form-control', 'placeholders'=>'Slogan')) }}--}}
	{{--</div>--}}
{{--</div>--}}

{{--<div class="form-group">--}}
	{{--{{ Form::label('encuesta[description]', 'Description:', array('class'=>'col-md-2 control-label')) }}--}}
	{{--<div class="col-sm-10">--}}
		{{--{{ Form::text('encuesta[description]', Input::old('encuesta[description]'), array('class'=>'form-control', 'placeholders'=>'Description')) }}--}}
	{{--</div>--}}
{{--</div>--}}