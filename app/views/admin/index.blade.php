@extends('layouts.admin')

@section('title')
@endsection

@section('style')
	@if(isset($theme))
		@include('layouts.theme')
	@endif
@endsection

@section('header')
	<section class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center header_text">
			<section class="row">
				<article class="col-xs-12 col-sm-10 col-md-6 col-lg-6 col-center-block">
					{{ HTML::image($theme->logo_header, 'header-logo', array('class' => 'img-responsive center-block')) }}
				</article>
			</section>
		</article>
	</section>
@endsection

@section('content')

	<section class="row row-md-flex-center row-lg-flex-center" id="login">

		<article class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-center-block">
			@if ($errors->has())
				@if($errors->any())
					{{ HTML::alert('danger', $errors->all(), 'Atencion!...') }}
				@endif
			@endif
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3 class="panel-title">{{ Str::hes('INICIO DE SESIÓN') }}</h3>
				</div>
				<div class="panel-body">
					{{ Form::open(array('url' => 'admin', 'method' => 'POST', 'accept-charset' => 'UTF-8', 'role' => 'form', 'id' => 'loginForm')) }}
					<fieldset>
						<div class="form-group">
							{{ Form::text('username', Input::old('username'), ['class' => 'form-control', 'required', 'placeholder' => 'Usuario...', 'autocomplete' => 'off'])  }}
						</div>
						<div class="form-group">
							{{ Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => 'Contraseña...']) }}
						</div>
						<input class="btn btn-lg btn-warning btn-block text-uppercase" type="submit" value="Entrar">
					</fieldset>
					{{ Form::close() }}
				</div>
			</div>
		</article>
	</section>
@endsection

@section('script')
	<script>
		(function ($) {
			$('#loginForm').formValidation({
				fields: {
					username: {
						message: 'El Usuario no es valido',
						validators: {
							notEmpty: {
								message: 'El campo Usuario es requerido'
							},
						}
					},
					password: {
						message: 'La contraseña es obligatoria.',
						validators: {
							notEmpty: {
								message: 'El campo Contraseña es requerido.'
							},
						}
					}
				}
			});
		})(jQuery);
	</script>
@endsection