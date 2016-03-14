@extends('pdf.generador.template_encuesta')

@section('style')
    @if(isset($theme))
        @include('layouts.theme')
    @endif
    <link href="{{ public_path('css/skins/all.css') }}" rel="stylesheet">
    {{--<link href="{{ url('css/skins/all.css') }}" rel="stylesheet">--}}

    <style>
        /*.incentive img {*/
        /*margin-bottom: 10px;*/
        /*-webkit-filter: none;*/
        /*filter: none;*/
        /*}*/
        .panel-primary{
            border: 0;
        }
        h4, .h4 {
            /*font-size: 11px;*/
            font-size: 15px;
        }
        h4 > strong{
            /*font-size: 12px;*/
            font-size: 16px;
        }
        h5, .h5 {
            /*font-size: 11px;*/
            font-size: 15px;
            display: inline-block;
            padding-left: 0!important;
        }
        h5 + div.form-group{
            display: inline-block;
        }
        body{
            /*font-size: 12px;*/
            font-size: 16px;
            font-family: arial, sans-serif;
        }

        table.table td{
            padding:0!important;
            border:0!important;
        }

        table.table td > label.control-label{
            /*font-size: 11px!important;*/
            font-size: 15px!important;
        }
        div.form-group.table-responsive{
            border:0!important;
            padding-left: 15px;
            padding-right: 15px;
        }
        article hr{
            margin-top:0!important;
        }
        /*textarea{
            padding: 0 !important;
            height: 0px!important;
            visibility: hidden;
        }*/
        .respuesta{
            border-bottom-style:dotted;
            border-width:1px;
            border-color: #CCCCCC;
        }
        .datos_personales label.control-label{
            /*font-size: 11px;*/
            font-size: 15px;
        }

        article.encuesta{
            padding-right: 0 !important;
        }
        article.encuesta > section.row > article{
            padding-right: 0 !important;
        }
        article.encuesta > section.row > article > div.form-group{
            padding-right: 0 !important;
        }
    </style>
@endsection

@section('header')
    <section class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center header_text">
            <section class="row">
                <article class="col-xs-6 col-xs-offset-3 col-sm-10 col-md-6 col-lg-6 col-center-block" style="margin-top: 0.3%;">
                    {{-- HTML::image($theme->logo_header, 'header-logo', array('class' => 'img-responsive center-block')) --}}
                    <img src="{{public_path($theme->logo_header)}}" alt="header-logo" class="img-responsive center-block" style="max-height: 150px;">
                    {{--<img src="{{url($theme->logo_header)}}" alt="header-logo" class="img-responsive center-block">--}}
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
                {{--<img src="{{url($theme->logo_incentivo)}}" alt="Incentivo" class="img-responsive center-block">--}}
            </article>
        @endif
        <article class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-offset-1 col-lg-10 col-center-block">
            <section class="panel-body" style="padding-left: 30px;">
                <h4 style="font-size: 19px;">{{ $survey->description }}</h4>
            </section>
        </article>
    </section>

    <section class="row">
        <article class="panel panel-primary col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 survey_text">
            <section class="panel-body">
                {{ Form::open(array('url' => 'survey/store', 'method' => 'POST', 'accept-charset' => 'UTF-8', 'role' => 'form', 'id' => 'surveyForm', 'class' => 'form-horizontal', 'onKeypress' => 'if(event.keyCode == 13) event.returnValue = false;')) }}
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 encuesta">
                    <section class="row">
                        {{ HTML::generateSurvey($survey) }}
                    </section>
                </article>
                @if(isset($client) && $client->plan->scopeOptInt())
                    {{--<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <hr>
                    </article>--}}
                    {{--<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
                    {{--<article class="">--}}
                    @include('pdf.generador.form_cliente')
                    {{--</article>--}}
                @endif

                {{ Form::close() }}
            </section>
        </article>
    </section>
@endsection

{{--@section('footer')
    @include('survey.footer')
@endsection--}}

@section('script')
    <script>
        $(document).on('ready', function(){
            //quita select que aparece en modo responsive, dejando radiobuttons
            $("div.form-group.table-responsive.hidden-md.hidden-lg").remove();
            $("div.form-group.table-responsive.hidden-xs.hidden-sm").removeClass("hidden-xs hidden-sm");

            //activa y da formato a check "no quiero recibir mas info"
            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-grey',
                increaseArea: '20%',
                labelHover: true,
                cursor: true
            });

            //achica areas de respuesta
            var textareas = $("textarea");

            textareas.attr('placeholder', '');
            textareas.attr('rows', '1');

            //quita algunos formatos de las tablas contenedoras de radiobuttons
            var tablas = $("table.table.table-hover.table-condensed");
            tablas.removeClass("table-hover table-condensed");

            var titulosH5 = $("article h5");
            titulosH5.addClass('col-xs-4');

            var justificacion = $("h5 + div.form-group");
            justificacion.addClass('col-xs-8');

        });
    </script>
@endsection
