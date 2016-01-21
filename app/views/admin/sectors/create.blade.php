@extends('layouts.cpanel')

@section('title')
    Crear Sector
@endsection

@section('page-title')
    <i class="fa fa-plus fa-fw"></i>Agregar Sector
@endsection

@section('breadcrumb')
    @parent
    <li>Sector</li>
    <li class="active">Agregar</li>
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

    {{ Form::open(array('route' => 'admin.sectors.store', 'class' => 'form-horizontal')) }}

    <div class="form-group">
        {{ Form::label('descripcion_sector', 'Nombre Sector:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('descripcion_sector', Input::old('descripcion_sector'), array('class'=>'form-control', 'placeholder'=>'Nombre Sector')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Instrucción Encuesta:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('description', Input::old('description'), array('class'=>'form-control', 'placeholder'=>'Description', 'rows' => 4)) }}
            <small class="count"></small>
        </div>
    </div>

    {{--<div class="form-group">--}}
    {{--{{ Form::label('titulo', 'Título Encuesta:', array('class'=>'col-md-2 control-label')) }}--}}
    {{--<div class="col-sm-10">--}}
    {{--{{ Form::text('titulo', Input::old('titulo'), array('class'=>'form-control', 'placeholder'=>'Titulo')) }}--}}
    {{--</div>--}}
    {{--</div>--}}

    <div role="tabpanel" class="tab-pane" id="tab6">
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
                                    {{ Form::questionForm('preguntaCabecera', $i, false, $i+1, false) }}
                                </div>
                                @if($i+1 < 4)
                                    <div class="col-md-12">
                                        <h4>Sub-Pregunta</h4>
                                        <section>
                                            {{ Form::questionForm('preguntaCabecera', $i, true, $i+1, false) }}
                                        </section>
                                    </div>
                                @endif
                            </section>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        <div class="col-sm-10">
            {{ Form::submit('Crear', array('class' => 'btn btn-lg btn-primary pull-right')) }}
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('style')
    {{ HTML::style('plugins/bootstrap_wizard/prettify.css')  }}
    {{ HTML::style('plugins/jquery-steps/css/jquery.steps.min.css')  }}
    {{ HTML::style('backend/css/nav-wizard.bootstrap.min.css') }}
@endsection

@section('script')
    {{ HTML::script('plugins/ckeditor/ckeditor.js') }}
    {{ HTML::script('plugins/ckeditor/config.js') }}
    {{ HTML::script('plugins/bootstrap_wizard/jquery.bootstrap.wizard.min.js')  }}
    {{ HTML::script('plugins/jquery-steps/js/jquery.steps.min.js')  }}
    {{ HTML::script('plugins/bootstrap_wizard/prettify.min.js')  }}

    <script>
        (function ($) {
            $('#myTabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            });

            $("textarea").keyup(function () {
                $(this).parent().find('small.count').text('Caracteres: ' + $(this).val().length);
            });
        })(jQuery)
    </script>
@endsection