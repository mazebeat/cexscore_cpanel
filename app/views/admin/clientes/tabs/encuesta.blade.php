<div class="form-group">
	{{ Form::label('encuesta[titulo]', 'T&iacute;tulo:', array('class'=>'col-md-2 control-label')) }}
	<div class="col-sm-10">
		{{ Form::text('encuesta[titulo]', Input::old('encuesta[titulo]'), array('class'=>'form-control', 'placeholders'=>'T&iacute;tulo de la Encuesta')) }}
	</div>
</div>

{{--<div class="form-group">--}}	{{--{{ Form::label('encuesta[slogan]', 'Subtitulo (eslogan):', array('class'=>'col-md-2 control-label')) }}--}}	{{--<div class="col-sm-10">--}}		{{--{{ Form::text('encuesta[slogan]', Input::old('encuesta[slogan]'), array('class'=>'form-control', 'placeholders'=>'Slogan')) }}--}}	{{--</div>--}}{{--</div>--}}

{{--<div class="form-group">--}}	{{--{{ Form::label('encuesta[description]', 'Description:', array('class'=>'col-md-2 control-label')) }}--}}	{{--<div class="col-sm-10">--}}		{{--{{ Form::text('encuesta[description]', Input::old('encuesta[description]'), array('class'=>'form-control', 'placeholders'=>'Description')) }}--}}	{{--</div>--}}{{--</div>--}}

<div id="preguntaFormulario">
	<!-- Navigation Buttons -->
	<div class="col-md-2">
		<ul class="nav nav-pills nav-stacked" id="myTabs">
			@for ($i = 0; $i < 4; $i++)
				<li class="{{ ($i == 0) ? 'active' : '' }}"><a href="#tabpre{{ $i }}">{{ array_get($catgs, $i) }}</a></li>
			@endfor
		</ul>
	</div>

	<!-- Content -->
	<div class="col-md-10">
		<div class="tab-content">
			@for ($i = 0; $i < 4; $i++)
				<div class="tab-pane {{ ($i == 0) ? 'active' : '' }}" id="tabpre{{ $i }}">
					<section data-step="{{ $i }}" class="row">
						<div class="col-md-12">
							<h3>Pregunta</h3>
							{{ Form::questionForm('preguntaCabecera', $i, false, $i+1) }}
						</div>
						<div class="col-md-12">
							<h4>Sub-Pregunta</h4>
							<section>
								{{ Form::questionForm('preguntaCabecera', $i, true, $i+1) }}
							</section>
						</div>
					</section>
				</div>
			@endfor
		</div>
	</div>
</div>