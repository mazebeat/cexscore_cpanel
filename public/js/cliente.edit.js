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

    function leadGeos () {
        var $this = $('#fieldCiudad');
        // console.log($this.val(), $this.find("option:selected").text(), $("#fieldCiudad option:selected").text());

        if($this.val() == null || $this.val() == undefined || $this.find("option:selected").text() == '')
        {
            $this.hide().parents('.form-group').hide();
        }

        $this = $('#fieldRegion');
        if($this.val() == null || $this.val() == undefined || $this.find("option:selected").text() == '')
        {
            $this.hide().parents('.form-group').hide();
        }
    }

    // leadGeos();

    $('#myTabs a').click(function (e) {
        e.preventDefault();
        var pane = $(this);
        pane.tab('show');
    });

    $('#home').load($('.active a').attr("data-url"), function (result) {
        $('.active a').tab('show');
    });

    $('#id_sector').on('change', function (e) {
        e.preventDefault();

        $.get('/admin/find/survey', {id_sector: $(this).val()}, function (survey) {
            $('[name="id_encuesta"]').val(survey.id);
        });
    });

    $('#addMoments').click(function (e) {
        var times = parseInt($('#cant_moment_plan').val(), 10);
        var num = $('#form-moments').children('.form-group.momento').last().data('id');
        var num2 = num + 1;
        var next = parseInt(num2 + 1);

        // console.log(num, num2);

        $('.cloneMoment').remove();

        var $template = $('#optionTemplate');
        var $clone = $template.clone()
        .removeClass('hide')
        .addClass('momento')
        .attr('data-id', num2)
        .removeAttr('id')
        .find(".control-label")
        .text('Momento ' + next + ':')
        .attr('for', 'momentos[' + num2 + '][id_momento]')
        .end()
        .insertAfter($('#form-moments').children('.form-group.momento').last())
        .end();

        var $option = $clone.find('input[name="descripcion_momento"]');
        $clone.find('[name="descripcion_momento"]')
        .attr('name', 'momentos[' + num2 + '][descripcion_momento]')
        .end()
        .find('[name="id_momento"]')
        .attr('name', 'momentos[' + num2 + '][id_momento]')
        .val(next)
        .end()
        .find('[name="id_encuesta"]')
        .attr('name', 'momentos[' + num2 + '][id_encuesta]')
        .end();

        $('#form-moments')
        .children('.form-group.momento')
        .last()
        .find('div:nth-child(3)')
        .append("<a href='javascript:void(0);' class='deleteOptionTemplate btn btn-default pull-right' data-moment='" + num2 + "'><i class='fa fa-trash-o'></i></a>")
        .end();

        $('#createClientForm').formValidation('addField', $option);

        e.preventDefault();
    });

    $('[data-delete]').click(function (e) {
        e.preventDefault();
        var $this = $(this);
        if (confirm('Está seguro de eliminar este momento ?')) {
            var url = $this.prop('href');
            var token = $this.data('delete');
            var moment = $this.data('moment');
            var action = $this.data('accion');
            var $form = $('<form/>', {action: url, method: 'post'});
            var $inputMethod = $('<input/>', {type: 'hidden', name: '_method', value: 'delete'});
            var $inputToken = $('<input/>', {type: 'hidden', name: '_token', value: token});
            var $inputMoment = $('<input/>', {type: 'hidden', name: 'id_momento', value: moment});
            var $inputAction = $('<input/>', {type: 'hidden', name: 'accion', value: action});
            $form.append($inputMethod, $inputToken, $inputMoment, $inputAction).hide().appendTo('body').submit();
        }
    });


    $('body').on('click', '.deleteOptionTemplate', function (e) {
        e.preventDefault();
        $(this).parents('.form-group').remove();
    });

    $('#fieldPais')
    .change(function (event) {
        var model = $('#fieldRegion');
        var model2 = $('#fieldCiudad');
            model.empty();
            model2.empty();

            if ($(this).find("option:selected").text().toLowerCase() == 'chile') {
                $('.fieldRegion').show();
                $('.fieldCiudad').show();
                model.removeAttr('disabled', 'disabled');
                model2.removeAttr('disabled', 'disabled');
            } else {
                $('.fieldRegion').hide();
                $('.fieldCiudad').hide();
                model.attr('disabled', 'disabled').children().removeAttr("selected");
                model2.attr('disabled', 'disabled').children().removeAttr("selected");
            }

            $.get("/admin/find/locate", {filterBy: 'pais', option: $(this).val()}, function (data) {
                if (Object.keys(data).length > 0) {
                    model.empty().append($("<option value=''></option>"));
                    $.each(data, function (index, element) {
                        model.append($("<option value='" + index + "'>" + element + "</option>"));
                    });
                }
            });

            // var $name = $(this).attr('name');
            // $('#createClientForm').formValidation('revalidateField', $name);
            event.preventDefault();
        });
    $('#fieldRegion')
    .change(function (e) {
        var model = $('#fieldCiudad');
        // console.log(model);


            model.attr('disabled', 'disabled').empty().show();
            //    .formValidation('revalidateField', model.attr('name'))
            //    .show();
            $.get("/admin/find/locate", {filterBy: 'region', option: $(this).val()}, function (data) {
                console.log(data);
                if (Object.keys(data).length > 0) {
                    model.empty().append($("<option value=''></option>"));
                    $.each(data, function (index, element) {
                        model.append($("<option value='" + index + "'>" + element + "</option>"));
                    });
                }
                model.removeAttr('disabled', 'disabled');
            });

            //var $name = $(this).attr('name');
            //$('#createClientForm').formValidation('revalidateField', $name);
            e.preventDefault();
        });

})(jQuery);