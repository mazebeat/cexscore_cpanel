@extends('pdf.generador.template_encuesta')

@section('style')
    @if(isset($theme))
        @include('layouts.theme')
    @endif
    <link href="{{ public_path('css/skins/all.css') }}" rel="stylesheet">
    <style>
        body {
            zoom: 0.9;
        }
        .panel-primary {
            border: 0;
        }

        h4, .h4 {
            font-size: 12px;
        }

        h5, .h5 {
            font-size: 12px;
            display: inline-block;
        }

        h5 + div.form-group {
            display: inline-block;
        }

        body {
            font-size: 12px;
            font-family: arial, sans-serif;
        }

        table.table td {
            padding: 0 !important;
            border: 0 !important;
        }

        div.form-group.table-responsive {
            border: 0 !important;
            padding-left: 15px;
            padding-right: 15px;
        }

        article hr {
            margin-top: 0 !important;
        }
    </style>
@endsection

@section('header')
    <section class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center header_text">
            <section class="row">
                <article class="col-xs-6 col-xs-offset-3 col-sm-10 col-md-6 col-lg-6 col-center-block" style="margin-top: 0.3%;">
                    <img src="{{public_path($theme->logo_header)}}" alt="header-logo" , class="img-responsive center-block">
                </article>
            </section>
        </article>
    </section>
@endsection

@section('content')
    <section class="row" style="margin-top: 15px;">
        @if(isset($theme) && !is_null($theme->logo_incentivo))
            <article class="col-xs-10 col-sm-10 col-md-5 col-lg-5 col-center-block incentive">
                <img src="{{public_path($theme->logo_incentivo)}}" alt="Incentivo" class="img-responsive center-block">
            </article>
        @endif
        <article class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-offset-1 col-lg-10 col-center-block">
            <section class="panel-body" style="padding-left: 30px;">
                <h4>{{ $survey->description }}</h4>
            </section>
        </article>
    </section>

    <section class="row">
        <article class="panel panel-primary col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 survey_text">
            <section class="panel-body">
                {{ Form::open(array('url' => 'survey/store', 'method' => 'POST', 'accept-charset' => 'UTF-8', 'role' => 'form', 'id' => 'surveyForm', 'class' => 'form-horizontal', 'onKeypress' => 'if(event.keyCode == 13) event.returnValue = false;')) }}
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <section class="row">
                        {{ HTML::generateSurvey($survey) }}
                    </section>
                </article>
                @if(isset($client) && $client->plan->scopeOptInt())
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </article>
                    <article class="">
                        @include('pdf.generador.form_cliente')
                    </article>
                @endif
                {{ Form::close() }}
            </section>
        </article>
    </section>
@endsection

@section('script')
    <script>
        $(document).on('ready', function () {
            $("div.form-group.table-responsive.hidden-md.hidden-lg").remove();
            $("div.form-group.table-responsive.hidden-xs.hidden-sm").removeClass("hidden-xs hidden-sm");

            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-grey',
                increaseArea: '20%',
                labelHover: true,
                cursor: true
            });

            var textareas = $("textarea");

            textareas.attr('placeholder', '');
            textareas.attr('rows', '2');

            var tablas = $("table.table.table-hover.table-condensed");
            tablas.removeClass("table-hover table-condensed");

            var titulosH5 = $("article h5");
            titulosH5.addClass('col-xs-4');

            var justificacion = $("h5 + div.form-group");
            justificacion.addClass('col-xs-8');
        });
    </script>
@endsection
