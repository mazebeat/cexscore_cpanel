(function ($) {
    function adjustIframeHeight() {
        var $body = $('body');
        var $iframe = $body.data('iframe.fv');
        if ($iframe) {
            $iframe.height($body.height());
        }
    }

    function validateTab(index) {
        var $form = $('#createClientForm');
        var fv = $form.data('formValidation');
        var $tab = $form.find('.tab-pane').eq(index);

        //	Validate the container
        fv.validateContainer($tab);

        var isValidStep = fv.isValidContainer($tab);
        if (isValidStep === false || isValidStep === null) {
            return false;
        }

        return true;
    }

    //Datemask dd/mm/yyyy
    //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    //$("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});

    $('textarea')
        .ckeditor()
        .editor
        .on('change', function (e) {
        });

    $("#rut_cliente").rut({
        formatOn: 'change keyup',
        validateOn: 'change keyup'
    });

    $('input[type="checkbox"], input[type="radio"]').iCheck({
            tap: true,
            checkboxClass: 'icheckbox_square-orange',
            radioClass: 'iradio_square-orange',
            increaseArea: '20%'
        })
        .on('ifChanged', function (e) {
            e.preventDefault();
            var field = $(this).attr('name');
            $('#createClientForm').formValidation('revalidateField', field);
        })
        .end();

    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });

    //		VALIDATIONS
    var $fields = {
        'cliente[rut_cliente]': {
            validators: {
                notEmpty: {
                    message: 'El RUT es requerido',
                },
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
        'usuario[rut_usuario]': {
            validators: {
                notEmpty: {
                    message: 'El RUT es requerido',
                },
                callback: {
                    callback: function (value, validator) {
                        return $.validateRut(value);
                    },
                    message: 'El campo RUT es incorrecto'
                },
                stringLength: {
                    min: 8,
                    max: 12
                }
            }
        },
        'apariencia[logo_header]': {
            message: 'El archivo no es valido.',
            validators: {
                notEmpty: {
                    message: 'El archivo es requerido',
                },
                file: {
                    extension: 'jpeg,png',
                    type: 'image/jpeg,image/png,image/gif',
                    maxSize: 2097152,   // 2048 * 1024
                    message: 'Seleccione un archivo valido.'
                }
            }
        },
        'apariencia[logo_incentivo]': {
            message: 'El archivo no es valido.',
            validators: {
                notEmpty: {
                    message: 'El archivo es requerido',
                },
                file: {
                    extension: 'jpeg,png',
                    type: 'image/jpeg,image/png,image/gif',
                    maxSize: 2097152,   // 2048 * 1024
                    message: 'Seleccione un archivo valido.'
                }
            }
        }
    };

    $('#createClientForm')
        .find('#fieldPais')
        .change(function (event) {
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
        })
        .end()
        .find('#fieldRegion')
        .change(function (e) {
            var model = $('#fieldCiudad');
            model.attr('disabled', 'disabled')
                .empty()
                .formValidation('revalidateField', model.attr('name'))
                .show();

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
        })
        .end()
        .find('[name="cliente[id_plan]"]')
        .on('ifChecked', function (e) {
            var $this = $(this);
            $('#cant_moment_plan').val(0).removeAttr('disabled');
            $('.cloneMoment').remove();

            $.get("/admin/find/configplan", {idplan: $this.val()}, function (cant) {

                var q = parseInt(cant);
                if (q == 0 || q == 'undefined') {
                    q = 999;
                }

                var $name = $('#cant_moment_plan').attr('name');
                $('#cant_moment_plan').attr('max', q)
                    .attr('data-fv-lessthan-value', q)
                    .end();

                $('#createClientForm').formValidation('removeField', 'cant_moment_plan')
                    .formValidation('addField', 'cant_moment_plan')
                    .formValidation('revalidateField', $name);
            });


            e.preventDefault();
        })
        .end()
        .find('#addMoments')
        .click(function (e) {
            var times = parseInt($('#cant_moment_plan').val(), 10);
            var num = 1;
            $('.cloneMoment').remove();

            for (var x = 0; x < times; x++) {
                var $template = $('#optionTemplate');
                var $clone = $template.clone()
                    .removeClass('hide')
                    .addClass('cloneMoment')
                    .removeAttr('id')
                    .find(".control-label")
                    .text('Momento ' + num++)
                    .end()
                    .insertBefore($template)
                    .end();

                var $option = $clone.find('input[name="momento"]');
                $clone.find('[name="momento"]')
                    .attr('data-fv-notempty', 'true')
                    .attr('id', 'momento' + x)
                    .attr('required', 'required')
                    .attr('name', 'momento_encuesta[' + x + '][descripcion_momento]')
                    .end()
                    .find('[name="canal"]')
                    .attr('id', 'canal' + x)
                    .attr('required', 'required')
                    .attr('name', 'momento_encuesta[' + x + '][canal]')
                    .end();

                // Add new field
                $('#createClientForm').formValidation('addField', $option);
            }

            e.preventDefault();
        })
        .end()
        .find('#id_sector')
        .on('change', function (e) {
            $.get('/admin/find/survey', {id_sector: $(this).val()}, function (survey) {
                var count = 0, $name = '';

                $('[name="cliente[id_encuesta]"]').val(survey.id);

                $('#createClientForm').formValidation('revalidateField', $('[name="cliente[id_encuesta]"]'));

                $.each(survey.preguntas, function (key, data) {
                    if (data.id_pregunta_padre == null) {
                        $name = 'preguntaCabecera[' + count + '][descripcion_1]';
                    } else {
                        $name = 'preguntaCabecera[' + count + '][sub][descripcion_1]';
                        count++;
                    }

                    CKEDITOR.instances[$name].setData(data.descripcion_1);
                    $('[name="' + $name + '"]').html(data.descripcion_1);
                })
            });

            e.preventDefault();
        })
        .end()
        .formValidation({
            framework: 'bootstrap',
            excluded: [':disabled', ':hidden'],
            live: 'enabled',
            locale: 'es_CL',
            button: {
                //selector: '[type="submit"]',
                //disabled: 'disabled'
            },
            fields: $fields
        })
        .on('err.field.fv', function (e, data) {
            var $tabPane = data.element.parents('.tab-pane');
            var $tabId = $tabPane.attr('id');

            $('a[href="#' + $tabId + '"][data-toggle="tab"]')
                .parent()
                .addClass('error')
                .end()
                .find('i')
                .removeClass('fa-check')
                .addClass('fa-times')
                .end();

            if (data.field == 'cant_moment_plan') {
                $('#addMoments').attr('disabled', 'disabled');
            }
        })
        .on('success.field.fv', function (e, data) {
            var $tabPane = data.element.parents('.tab-pane');
            var tabId = $tabPane.attr('id');
            var isValidTab = data.fv.isValidContainer($tabPane);
            var $icon = $('a[href="#' + tabId + '"][data-toggle="tab"]').parent().find('i');

            $icon.parent().find('i').removeClass('fa-times').addClass('fa-check');

            //console.log(isValidTab);
            if (isValidTab !== null) {
                var $class = '';
                if (isValidTab) {
                    $add = 'fa-check'
                    $rem = 'fa-times'
                    $icon.parent().parent().removeClass('error');
                } else {
                    $add = 'fa-times'
                    $rem = 'fa-check'
                    $icon.parent().parent().addClass('error');
                }
                $icon.addClass($add).removeClass($rem);

            }

            if (data.field == 'cant_moment_plan') {
                $('#addMoments').removeAttr('disabled');
            }

            if (data.fv.getInvalidFields().length > 0) {
                data.fv.disableSubmitButtons(true);
            }
        })
        .on('success.form.fv', function (e) {
        })
        .bootstrapWizard({
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

                tab.removeClass('success-tab').removeClass('error');

                return true;
            },
            onPrevious: function (tab, navigation, index) {
                var isValidTab = validateTab(index + 1);

                if (!isValidTab) {
                    tab.removeClass('success-tab').addClass('error');
                    return false;
                }

                tab.addClass('success-tab');

                return true;
            },
            onLast: function (tab, navigation, index) {
                var isValidTab = validateTab(index);

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

                if ($current >= $total) {
                    $('#rootwizard').find('.pager .next').hide().end()
                        .find('.pager .finish').css('display', 'inline').end()
                        .find('.pager .finish').removeClass('disabled').end();
                } else {
                    $('#rootwizard').find('.pager .next').show().end()
                        .find('.pager .finish').hide().end();
                }
            }
        });
})(jQuery);