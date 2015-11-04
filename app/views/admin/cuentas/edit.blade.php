@extends('layouts.cpanel')

@section('title')
	Editar Cuenta
@endsection

@section('page-title')
	{{--<i class="fa fa-pencil fa-fw"></i>Editar Cliente--}}
	<i class="fa fa-user fa-fw"></i>{{ Session::get('account.name', $cliente->nombre_cliente) }}
@endsection

@section('breadcrumb')
	@parent
	<li class=""><a href="{{ url('admin/cuentas')  }}">Cuenta</a></li>
	<li class="active">{{ Session::get('account.name', $cliente->nombre_cliente)  }}</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-10 col-md-offset-2">
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						{{ implode('', $errors->all('<li class="error">:message</li>')) }}
					</ul>
				</div>
			@endif
		</div>
	</div>


	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs" id="myTabs">
			<li class="active"><a href="#home">Información Básica</a></li>
			<li><a href="#plan">Plan</a></li>
			<li><a href="#momentos">Momentos</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="home">@include('admin.cuentas.tabs.edit.home')</div>
			<div class="tab-pane" id="plan">@include('admin.cuentas.tabs.edit.plan')</div>
			<div class="tab-pane" id="momentos">@include('admin.cuentas.tabs.edit.momentos')</div>
		</div>
	</div>

	{{ link_to_route('admin.cuentas.show', 'Volver', $cliente->id_cliente, array('class' => 'btn btn-lg btn-default pull-right')) }}
@endsection

@section('style')
	{{ HTML::style('plugins/bootstrap_wizard/prettify.min.css')  }}
	{{ HTML::style('plugins/jquery-steps/css/jquery.steps.min.css')  }}
	{{ HTML::style('backend/css/nav-wizard.bootstrap.min.css') }}
	<style>
		.texthide {
			display: none
		}
	</style>
@endsection

@section('script')

	{{--Bootstrap Wizard--}}
	{{--{{ HTML::script('plugins/bootstrap_wizard/jquery.bootstrap.wizard.min.js') }}--}}
	{{--{{ HTML::script('plugins/jquery-steps/js/jquery.steps.min.js') }}--}}
	{{--{{ HTML::script('plugins/bootstrap_wizard/prettify.min.js') }}--}}

	{{--jQuery RUT--}}
	{{ HTML::script('js/jquery.rut.min.js') }}

	{{--CKEditor--}}
	{{--{{ HTML::script('plugins/ckeditor/ckeditor.js') }}--}}
	{{--{{ HTML::script('plugins/ckeditor/adapters/jquery.min.js') }}--}}
	{{--{{ HTML::script('plugins/ckeditor/config.js') }}--}}

	{{--InputMask--}}
	{{ HTML::script('plugins/input-mask/jquery.inputmask.min.js') }}
	{{ HTML::script('plugins/input-mask/jquery.inputmask.date.extensions.min.js') }}
	{{ HTML::script('plugins/input-mask/jquery.inputmask.extensions.min.js') }}

	{{--JS Create cliente--}}
	{{ HTML::script('js/cliente.edit.js') }}
	<script>
		(function ($) {
			$('#myTabs a').click(function (e) {
				e.preventDefault();

//				var url = $(this).attr("data-url");
//				var href = this.hash;
				var pane = $(this);

				// ajax load from data-url
//				$(href).load(url, function (result) {
				pane.tab('show');
//				});
			});

			// load first tab content
			$('#home').load($('.active a').attr("data-url"), function (result) {
				$('.active a').tab('show');
			});
		})(jQuery);
	</script>
@endsection