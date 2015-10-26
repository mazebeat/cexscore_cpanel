@extends('layouts.user')

@section('style')
	@if(isset($theme) && !is_null($theme))
		@include('layouts.theme')
	@endif
	<style>
		.incentive img {
			margin-bottom: 10px;
		}

		.aqui {
			color: #ffffff;
		}
	</style>
@endsection

@section('header')
	<section class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
			{{ HTML::image($theme->logo_header, 'header-logo', array('class' => 'img-responsive center-block')) }}
		</article>
	</section>
@endsection

@section('content')
	<section class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="padding-top: 20px; color: #ffffff;">
			<h1><strong>Privacidad y uso de la Información</strong></h1>

			<p>CustomerTrigger S.A. en nombre de esta empresa realiza un proceso de medición de calidad de servicio con el afán de establecer procesos de mejora y transformación del servicio que presta esta empresa a su comunidad. Las preferencias registradas por Usted, junto a sus datos personales, en caso de haberlos entregados, se mantienen en estricta confidencialidad, son de propiedad de esta empresa y serán utilizados solo para los efectos indicados anteriormente, sin perjuicio que la empresa pueda utilizar el conocimiento registrado para entregar información personalizada y relevante a Usted.
				<br>Para acceder a información de nuestra compañía y a nuestros canales de contacto, puede visitar </p>

			<p><a href="http://www.customertrigger.com" class="aqui"><i class="fa fa-link fa-fw"></i>www.CustomerTrigger.com</a>
			</p>
		</article>

		<div class="clearfix"></div>

		<article class="row" style="padding: 10px;">
			<section class="col-xs-6 col-sm-4 col-md-3 col-lg-3 col-center-block">
				{{ HTML::link(URL::previous(), 'VOLVER ATRÁS', array('id' => 'submit', 'class' => 'text-uppercase btn btn-lg center-block user')) }}
			</section>
		</article>
	</section>

	<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1lavel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="modal1lavel">¡Atención!</h4>
				</div>
				<div class="modal-body">
					<p>¿Estás seguro que deseas ser eliminado de este proceso de medición?</p>
				</div>
				<div class="modal-footer">
					<ul class="list-inline">
						<li>
							{{ Form::button('NO', array('class' => 'btn btn-hot btn-md', 'data-dismiss' => 'modal')) }}
						</li>
						<li>
							{{ Form::button('SÍ', array('class' => 'btn btn-sky btn-md', 'id' => 'modal1_ok', 'data-toggle' => 'modal', 'data-target' => '#modal2')) }}
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2lavel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<h3>Tú solicitud ha sido registrada, Gracias por tu Tiempo. <i class="fa fa-spinner fa-spin"></i></h3>
				</div>
			</div>
		</div>
	</div>
@stop

@section('footer')
	@include('survey.footer')
@endsection

@section('script')
	<script>
		jq('#submit').darkcolor();
	</script>
@endsection
