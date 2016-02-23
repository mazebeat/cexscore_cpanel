@extends('layouts.cpanel')

@section('title')
    Editar Sector
@endsection

@section('page-title')
    <i class="fa fa-pencil fa-fw"></i>Editar Sector
@endsection

@section('breadcrumb')
    @parent
    <li>Sectores</li>
    <li class="active">Editar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{ Form::model($sector, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.sectors.update', $sector->id_sector))) }}

    <div class="form-group">
        {{ Form::label('descripcion_sector', 'Nombre Sector:', array('class'=>'col-md-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('descripcion_sector', Input::old('descripcion_sector'), array('class'=>'form-control', 'placeholder'=>'Descripcion_sector')) }}
        </div>
    </div>

    @if(isset($survey))
        <div class="form-group">
            {{ Form::label('description', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
                {{ Form::textarea('description', Input::old('description', $survey->description or ''), array('class'=>'form-control', 'placeholder'=>'Description', 'rows' => 4)) }}
            </div>
        </div>

        @if(isset($survey))
            @if(isset($survey))
                {{ Form::loadSurvey($survey, true) }}
            @endif
        @endif
    @endif

    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        <div class="col-sm-10">
            {{ link_to_route('admin.sectors.show', 'Cancelar', $sector->id_sector, array('class' => 'btn btn-lg btn-default pull-right')) }}
            {{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary pull-right')) }}
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

    <script>
        (function ($) {
            $('#myTabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show')
            });

            $.get('/admin/find/survey', {id_sector: $(this).val()}, function (survey) {
                var count = 0, $instance = '';
                $.each(survey, function (key, data) {
                    if (data.id_pregunta_padre == null) {
                        $name = 'preguntaCabecera[' + count + '][descripcion_1]';
                    } else {
                        $name = 'preguntaCabecera[' + count + '][sub][descripcion_1]';
                        count++;
                    }
                    CKEDITOR.instances[$name].setData(data.descripcion_1);
                })
            });
        })(jQuery);
    </script>
@endsection