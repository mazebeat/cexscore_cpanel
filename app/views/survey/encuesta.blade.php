@extends('layouts.user')

@section('style')
    @if(isset($theme))
        @include('layouts.theme')
    @endif
    <style>
        /*.incentive img {*/
        /*margin-bottom: 10px;*/
        /*-webkit-filter: none;*/
        /*filter: none;*/
        /*}*/
    </style>
@endsection

@section('header')
    @if(isset($theme) && isset($theme->logo_header))
        <section class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center header_text">
                <section class="row">
                    <article class="col-xs-12 col-sm-10 col-md-6 col-lg-6 col-center-block" style="margin-top: 0.3%;">
                        {{ HTML::image($theme->logo_header, 'header-logo', array('class' => 'img-responsive center-block')) }}
                    </article>
                </section>
            </article>
        </section>
    @endif
@endsection

@section('content')
    <section class="row" style="margin-top: 15px; margin-bottom: 15px;">
        @if(isset($theme) && isset($theme->logo_incentivo))
            <article class="col-xs-10 col-sm-10 col-md-5 col-lg-5 col-center-block incentive">
                {{ HTML::image($theme->logo_incentivo, 'Incentivo', array('class' => 'img-responsive center-block')) }}
            </article>
        @endif
        <article class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-center-block instrucciones">
            <h4>{{{ $survey->description }}}</h4>
        </article>
    </section>
    <section class="row">
        <article class="panel panel-primary col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 survey_text">
            <section class="panel-body">
                @if ($errors->has())
                    <article class="errors">
                        @if($errors->any())
                            {{ HTML::alert('danger', $errors->all(), 'Error...') }}
                        @endif
                    </article>
                @endif
                {{ Form::open(array('url' => 'survey/store', 'method' => 'POST', 'accept-charset' => 'UTF-8', 'role' => 'form', 'id' => 'surveyForm', 'class' => 'form-horizontal', 'onKeypress' => 'if(event.keyCode == 13) event.returnValue = false;')) }}
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <section class="row">
                        {{ HTML::generateSurvey($survey) }}
                    </section>
                </article>
                @if(isset($client) && $client->plan->scopeOptInt())
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include('layouts.form_cliente')
                    </article>
                @endif
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {{ Form::submit('Enviar Respuestas', array('class' => 'text-uppercase btn btn-lg center-block user'))  }}
                </article>
                {{ Form::close() }}
            </section>
        </article>
    </section>
@endsection

@section('footer')
    @include('survey.footer')
@endsection

@section('script')
    <script type="text/javascript">
        (function ($) {
            var $username = '{{ Session::get('user_name') }}';
            var color = '{{ $theme->color_opciones }}';
            var input_color = 'blue';

            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
                weekHeader: 'Sm',
                dateFormat: 'dd-mm-yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };

            $.datepicker.setDefaults($.datepicker.regional['es']);

            if ($('#age').length > 0) {
                if ($('#age')[0].type != 'date') {
                    $('#age').datepicker({
                        dateFormat: 'dd-mm-yy',

                        showOtherMonths: true,
                        selectOtherMonths: true,
                        changeMonth: true,
                        changeYear: true,

                        minDate: new Date(1960, 01, 01),
                        maxDate: new Date()
                    });
                }
            }

            if ($('input#rut').length) {
                $("input#rut").rut({
                    formatOn: 'keyup',
                    validateOn: 'change'
                });
            }

            switch (color) {
                case 'red':
                    input_color = 'red';
                    break;
                case 'green':
                    input_color = 'green';
                    break;
                case 'blue':
                    input_color = 'blue';
                    break;
                case 'grey':
                    input_color = 'grey';
                    break;
                case 'orange':
                    input_color = 'orange';
                    break;
                case 'yellow':
                    input_color = 'yellow';
                    break;
                case 'pink':
                    input_color = 'pink';
                    break;
                case 'purple':
                    input_color = 'purple';
                    break;
                default:
                    input_color = 'blue';
                    break;
            }

            $('input[type=radio]').iCheck({
                radioClass: 'iradio_square-' + input_color,
                increaseArea: '20%',
                labelHover: true,
                cursor: true
            }).on('ifChecked', function (event) {
                event.preventDefault();
                var $name = $(this).attr('name');
                var $value = $(this).val();
                $('select[name="' + $name + '"]').select2('val', $value);
                $('#surveyForm').formValidation('revalidateField', $name);
            });

            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-' + input_color,
                increaseArea: '20%',
                labelHover: true,
                cursor: true
            });

            $('select').select2({
                width: '100%',
                containerCssClass: '',
                dropdownAutoWidth: true,
                dropdownCssClass: 'text-center'
            }).change(function (event) {
                event.preventDefault();
                var $name = $(this).attr('name');
                var $value = event.val;
                $('input[type=radio][name="' + $name + '"][value=' + $value++ + ']').iCheck('toggle');
                $('#surveyForm').formValidation('revalidateField', $name);
            });

            $('#gender').select2().change(function (e) {
                $('#gender').formValidation('revalidateField', 'gender');
            });

            $('.table td').hover(function () {
                $(this).find('.iradio_square-' + input_color).addClass('hover');
            }, function () {
                $(this).find('.iradio_square-' + input_color).removeClass("hover");
            }).click(function (event) {
                event.preventDefault();
                $(this).find('.iradio_square-' + input_color).iCheck('toggle');
            });

            $('input[type=submit]').darkcolor();

            /**
             *  Bootstrap Validator
             */
            $('#surveyForm').formValidation({
                err: {
                    clazz: 'help-block2',
                    container: function ($field, validator) {
                        return $field.parents('.form-group').next('.messageContainer');
                    }
                },
                fields: {
                    rut: {
                        message: 'El RUT no es valido',
                        validators: {
                            callback: {
                                callback: function (value, validator) {
                                    if (value != '') {
                                        return $.validateRut(value);
                                    }

                                    return true;
                                },
                                message: 'El RUT no es v&aacute;lido'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function (e) {
            }).on('err.field.fv', function (e, data) {
                // console.warn(e);
            });
        }(jQuery));
    </script>
@endsection
