@extends('layouts.cpanel')

@section('title')
	Crear Cliente
@endsection

@section('page-title')
	&nbsp;<i class="fa fa-plus fa-fw"></i>Agregar Cliente
@endsection

@section('breadcrumb')
	@parent
	<li>Clientes</li>
	<li class="active">Agregar</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						{{ implode('', $errors->all('<li class="error">:message</li>')) }}
					</ul>
				</div>
			@endif
		</div>
	</div>

	{{ Form::open(array('route' => 'admin.clientes.store', 'class' => 'form-horizontal', 'id' => 'createClientForm', 'files' => true)) }}
	<div id="rootwizard">
		{{--BEGIN PROGRESS BAR--}}
		{{--{{ HTML::bsProgressBar('bar', ['id' => 'bar']) }}--}}
		{{--END PROGRESS BAR--}}

		{{--BEGIN NAV TABS--}}
		<ul class="nav nav-pills nav-wizard nav-justified" role="tablist">
			<li>
				<a href="#tab1" data-toggle="tab">Cuenta&nbsp;<i class="fa"></i></a>

				<div class="nav-arrow"></div>
			</li>
			<li role="presentation">
				<div class="nav-wedge"></div>
				<a href="#tab2" data-toggle="tab">Administrador&nbsp;<i class="fa"></i></a>

				<div class="nav-arrow"></div>
			</li>
			<li role="presentation">
				<div class="nav-wedge"></div>
				<a href="#tab3" data-toggle="tab">Plan&amp;Conf&nbsp;<i class="fa"></i></a>

				<div class="nav-arrow"></div>
			</li>
			<li role="presentation">
				<div class="nav-wedge"></div>

				<a href="#tab4" data-toggle="tab">Encuesta&nbsp;<i class="fa"></i> </a>

				<div class="nav-arrow"></div>
			</li>
			<li role="presentation">
				<div class="nav-wedge"></div>
				<a href="#tab5" data-toggle="tab">Apariencia&nbsp;<i class="fa"></i></a>

			</li>
		</ul>
		{{--END NAV TABS--}}

		{{--BEGIN CONTENT TAB--}}
		<div class="tab-content">
			{{--BEGIN TAB 1 - BASICOS--}}
			<div role="tabpanel" class="tab-pane active" id="tab1">
				@include('admin.clientes.tabs.cuenta')
			</div>
			{{--END TAB 1--}}

			{{--BEGIN TAB 2 - CONTACTO--}}
			<div role="tabpanel" class="tab-pane" id="tab2">
				@include('admin.clientes.tabs.admin')
			</div>
			{{--END TAB 2--}}

			{{--BEGIN TAB 3 - PLAN--}}
			<div role="tabpanel" class="tab-pane" id="tab3">
				@include('admin.clientes.tabs.config')
			</div>
			{{--END TAB 3--}}

			{{--BEGIN TAB 4 - ENCUESTA--}}
			<div role="tabpanel" class="tab-pane" id="tab4">
				@include('admin.clientes.tabs.encuesta')
			</div>
			{{--END TAB 4--}}

			{{--BEGIN TAB 5 - APARIENCIA--}}
			<div role="tabpanel" class="tab-pane" id="tab5">
				@include('admin.clientes.tabs.apariencia')
			</div>
			{{--END TAB 5--}}


			{{--BEGIN TAB 6 - PREGUNTAS--}}
			<div role="tabpanel" class="tab-pane" id="tab6">
				{{--<div id="preguntaFormulario">--}}
				{{--<!-- Navigation Buttons -->--}}
				{{--<div class="col-md-2">--}}
				{{--<ul class="nav nav-pills nav-stacked" id="myTabs">--}}
				{{--@for ($i = 0; $i < 4; $i++)--}}
				{{--<li class="{{ ($i == 0) ? 'active' : '' }}"><a href="#tabpre{{ $i }}">{{ array_get($catgs, $i) }}</a></li>--}}
				{{--@endfor--}}
				{{--</ul>--}}
				{{--</div>--}}

				{{--<!-- Content -->--}}
				{{--<div class="col-md-10">--}}
				{{--<div class="tab-content">--}}
				{{--@for ($i = 0; $i < 4; $i++)--}}
				{{--<div class="tab-pane {{ ($i == 0) ? 'active' : '' }}" id="tabpre{{ $i }}">--}}
				{{--<section data-step="{{ $i }}" class="row">--}}
				{{--<div class="col-md-12">--}}
				{{--<h3>Pregunta</h3>--}}
				{{--{{ Form::questionForm('preguntaCabecera', $i, false, $i+1) }}--}}
				{{--</div>--}}
				{{--<div class="col-md-12">--}}
				{{--<h4>Sub-Pregunta</h4>--}}
				{{--<section>--}}
				{{--{{ Form::questionForm('preguntaCabecera', $i, true, $i+1) }}--}}
				{{--</section>--}}
				{{--</div>--}}
				{{--</section>--}}
				{{--</div>--}}
				{{--@endfor--}}
				{{--</div>--}}
				{{--</div>--}}
				{{--</div>--}}
			</div>
			{{--END TAB 6 - PREGUNTAS--}}

			{{--BEGIN NAVEGATION--}}
			<ul class="pager wizard">
				<li class="previous first" style="display:none;"><a href="javascript:;">{{ Lang::get('pagination.first') }}</a></li>
				<li class="previous"><a href="javascript:;">{{ Lang::get('pagination.previous') }}</a></li>
				<li class="next"><a href="javascript:;">{{ Lang::get('pagination.next') }}</a></li>
				<li class="next last finish" style="display:none;">
					<button class="btn btn-success btn-lg pull-right" type="submit">{{ Lang::get('pagination.finish') }}!</button>
				</li>
			</ul>
			{{--END NAVEGATION--}}
		</div>
		{{--END CONTENT TAB--}}
	</div>
	{{ Form::close() }}

	{{--BEGIN FINALLY MODAL--}}
	<div class="modal fade" id="completeModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Completado</h4>
				</div>

				<div class="modal-body">
					<p class="text-center">Proceso para crear un Cliente, completado.</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">Volver CPanel</button>
				</div>
			</div>
		</div>
	</div>
	{{--END FINALLY MODAL--}}
@endsection

@section('style')
	{{ HTML::style('plugins/bootstrap_wizard/prettify.css')  }}
	{{ HTML::style('plugins/jquery-steps/css/jquery.steps.min.css')  }}
	{{ HTML::style('backend/css/nav-wizard.bootstrap.min.css') }}
	{{ HTML::style('plugins/icheck/skins/all.css') }}
	<style>
		#createClientForm .tab-content {
			margin-top: 20px;
		}

		.wizard .content {
			min-height: 100px;
		}

		.wizard .content > .body {
			width: 100%;
			height: auto;
			padding: 15px;
			position: relative;
		}
	</style>
@endsection

@section('script')
	{{ HTML::script('plugins/bootstrap_wizard/jquery.bootstrap.wizard.min.js')  }}
	{{ HTML::script('plugins/jquery-steps/js/jquery.steps.min.js')  }}
	{{ HTML::script('plugins/bootstrap_wizard/prettify.min.js')  }}
	{{ HTML::script('js/jquery.rut.min.js') }}
	{{ HTML::script('plugins/icheck/icheck.min.js') }}

	<script>
		function adjustIframeHeight() {
			var $body = $('body');
			var $iframe = $body.data('iframe.fv');
			if ($iframe) {
				$iframe.height($body.height());
			}
		}

		$('#fieldPais').change(function (event) {
			var model = $('#fieldRegion');
			var model2 = $('#fieldCiudad');
			model.empty().formValidation('revalidateField', 'cliente[region').show();
			model2.empty().formValidation('revalidateField', 'cliente[id_ciudad');

			var $select = $(this).find("option:selected").text();

			if ($select == 'Chile' || $select == 'chile' || $select == 'CHILE') {
				$('.fieldRegion').show();
				$('.fieldCiudad').show();
				model.removeAttr('disabled', 'disabled');
				model2.removeAttr('disabled', 'disabled');
			} else {
				$('.fieldRegion').hide();
				$('.fieldCiudad').hide();
				model.attr('disabled', 'disabled');
				model2.attr('disabled', 'disabled');
			}

			$.get("/admin/find/locate", {filterBy: 'pais', option: $(this).val()}, function (data) {
				if (Object.keys(data).length > 0) {
					model.append($("<option value=''></option>"));
					$.each(data, function (index, element) {
						model.append($("<option value='" + index + "'>" + element + "</option>"));
					});
				}
			});

			var $name = $(this).attr('name');
			$('#createClientForm').formValidation('revalidateField', $name);
			event.preventDefault();
		});

		$('#fieldRegion').change(function (e) {
			var model = $('#fieldCiudad');
			model.attr('disabled', 'disabled').empty().formValidation('revalidateField', model.attr('name')).show();

			$.get("/admin/find/locate", {filterBy: 'region', option: $(this).val()}, function (data) {
				if (Object.keys(data).length > 0) {
					model.append($("<option value=''></option>"));
					$.each(data, function (index, element) {
						model.append($("<option value='" + index + "'>" + element + "</option>"));
					});
				}
				model.removeAttr('disabled', 'disabled');
			});

			var $name = $(this).attr('name');
			$('#createClientForm').formValidation('revalidateField', $name);
			e.preventDefault();
		});

		$('#createClientForm input[name="cliente[id_plan]"]').on('ifChecked', function (e) {
			var $this = $(this);
			$('#cant_moment_plan').val(0).removeAttr('disabled');
			$('.cloneMoment').remove();

			$.get("/admin/find/configplan", {idplan: $this.val()}, function (cant) {

				var q = parseInt(cant);
				console.log(cant != 0)

				if (q == 0) {
					q = 999;
				}

				$('#cant_moment_plan').attr('max', q).attr('data-fv-lessthan-value', q);
				var $name = $('#cant_moment_plan').attr('name');

				$('#createClientForm').formValidation('removeField', 'cant_moment_plan')
										.formValidation('addField', 'cant_moment_plan')
										.formValidation('revalidateField', $name);
			});


			e.preventDefault();
		});

		$('#addMoments').click(function (e) {
			var times = parseInt($('#cant_moment_plan').val(), 10);
			var num = 1;
			$('.cloneMoment').remove()

			for (var x = 0; x < times; x++) {
				var $template = $('#optionTemplate');
				var $clone = $template.clone()
										.removeClass('hide')
										.addClass('cloneMoment')
										.removeAttr('id')
										.find(".control-label")
										.text('Momento ' + num++)
										.end()
										.insertBefore($template);

				var $option = $clone.find('[name="momento_encuesta[]"]');
				$option.attr('data-fv-notempty', 'true').attr('id', 'momento' + x)
										.attr('required', 'required')
										.attr('name', 'momento_encuesta[' + x + '].descripcion_momento');

				// Add new field
				$('#createClientForm').formValidation('addField', $option);
			}

			e.preventDefault();
		});

		$('#id_sector').on('change', function (e) {
			console.log('change sector');

			$.get('/admin/find/survey', {id_sector: $(this).val()}, function (survey) {

			});

			e.preventDefault();
		});

		$("#rut_cliente").rut({
			formatOn: 'keyup',
			validateOn: 'change'
		});

		//		VALIDATIONS
		var $fields = {
			'cliente[nombre_cliente]': {
				validators: {
					notEmpty: {},
				}
			},
			'cliente[rut_cliente]': {
				message: 'El RUT no es valido',
				validators: {
					notEmpty: {},
					callback: {
						callback: function (value, validator) {
//							console.log($.validateRut(value));
							return $.validateRut(value);
						},
						message: 'El campo RUT es incorrecto'
					},
					stringLength: {
						min: 8,
						max: 12,
					}
				}
			},
			'cliente[fono_cliente]': {
				validators: {
					notEmpty: {},
					regexp: {
						message: 'El número de teléfono solo puede contener dígitos, espacios, -, (, ), + y .',
						regexp: /^[0-9\s\-()+\.]+$/
					}
				}
			},
			'cliente[correo_cliente]': {
				validators: {
					notEmpty: {},
					emailAddress: {}
				}
			},
			'cliente[pais]': {
				validators: {
					notEmpty: {},
				}
			},
			'cliente[region]': {
				validators: {
					notEmpty: {},
				}
			},
			'cliente[id_ciudad]': {
				validators: {
					notEmpty: {},
				}
			},
			'cliente[id_sector]': {
				validators: {
					notEmpty: {},
				}
			},
			'cliente[id_plan]': {
				validators: {
					notEmpty: {},
				}
			},
			'encuesta[titulo]': {
				validators: {
					notEmpty: {},
				}
			},
			'encuesta[slogan]': {
				validators: {
					notEmpty: {},
				}
			},
			'encuesta[description]': {
				validators: {
					notEmpty: {},
				}
			},
			'apariencia[logo_header]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[logo_incentivo]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_header]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_body]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_footer]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_boton]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_opciones]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_text_header]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_text_body]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_text_footer]': {
				validators: {
					notEmpty: {}
				}
			},
			'apariencia[color_instrucciones]': {
				validators: {
					notEmpty: {}
				}
			},
		};

		$('#createClientForm').formValidation({
			framework: 'bootstrap',
			excluded: [':disabled'],
			live: 'enabled',
			locale: 'es_CL',
			button: {
				selector: '[type="submit"]',
				disabled: 'disabled'
			},
			fields: $fields
		}).on('err.field.fv', function (e, data) {
			var $tabPane = data.element.parents('.tab-pane');
			var $tabId = $tabPane.attr('id');

			$('a[href="#' + $tabId + '"][data-toggle="tab"]').parent()
									.addClass('error')
									.find('i')
									.removeClass('fa-check')
									.addClass('fa-times');

		}).on('success.field.fv', function (e, data) {
			var $tabPane = data.element.parents('.tab-pane');
			var tabId = $tabPane.attr('id');
			var $icon = $('a[href="#' + tabId + '"][data-toggle="tab"]').parent()
									.find('i').removeClass('fa-check fa-times');

			var isValidTab = data.fv.isValidContainer($tabPane);

			if (isValidTab !== null) {
				$icon.addClass(isValidTab ? 'fa-check' : 'fa-times');
			}

			if (data.fv.getInvalidFields().length > 0) {
				data.fv.disableSubmitButtons(true);
			}
		}).on('success.form.fv', function (e) {
		}).bootstrapWizard({
			tabClass: 'nav nav-pills',
			onTabClick: function (tab, navigation, index) {
				return validateTab(index);
			},
			onNext: function (tab, navigation, index) {
				adjustIframeHeight();
				var numTabs = $('#createClientForm').find('.tab-pane').length;
				var isValidTab = validateTab(index - 1);

				if (!isValidTab) {
					return false;
				}

				if (index === numTabs) {
				}

				tab.removeClass('success-tab')
				tab.removeClass('error')

				return true;
			},
			onPrevious: function (tab, navigation, index) {
				var isValidTab = validateTab(index + 1);

				if (!isValidTab) {
					tab.removeClass('success-tab').addClass('error');
					return false;
				}

				tab.addClass('success-tab')
				return true;
			},
			onLast: function (tab, navigation, index) {
				var isValidTab = validateTab(index);
//				console.log('The Last: ' + isValidTab, index);
//				console.log('The Last: ' + isValidTab, index + 1);
				if (!isValidTab) {
					return false;
				}

				$('#createClientForm').formValidation('defaultSubmit');

				return true;
			},
			onTabShow: function (tab, navigation, index) {
				var $total = navigation.find('li').length;
				var $current = index + 1;
				var $percent = ($current / $total) * 100;
				/* $('#rootwizard').find('.bar').css({width: $percent + '%'}).attr('aria-valuenow', $percent).find('span').text($percent + '% Complete'); */

				if ($current >= $total) {
					$('#rootwizard').find('.pager .next').hide();
					$('#rootwizard').find('.pager .finish').css('display', 'inline');
					$('#rootwizard').find('.pager .finish').removeClass('disabled');
				} else {
					$('#rootwizard').find('.pager .next').show();
					$('#rootwizard').find('.pager .finish').hide();
				}
			}
		});

		$('input[type="checkbox"], input[type="radio"]').iCheck({
			tap: true,
			checkboxClass: 'icheckbox_square-orange',
			radioClass: 'iradio_square-orange',
			increaseArea: '20%'
		}).on('ifChanged', function (e) {
			e.preventDefault();
			var field = $(this).attr('name');
			$('#createClientForm').formValidation('revalidateField', field);
		}).end();

		$('#myTabs a').click(function (e) {
			e.preventDefault()
			$(this).tab('show')
		});

		function validateTab(index) {
			var fv = $('#createClientForm').data('formValidation');
			var $tab = $('#createClientForm').find('.tab-pane').eq(index);

			//	Validate the container
			fv.validateContainer($tab);

			var isValidStep = fv.isValidContainer($tab);
			if (isValidStep === false || isValidStep === null) {
				return false;
			}

			return true;
		}
	</script>
@endsection