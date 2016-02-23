@extends('layouts.cpanel')

@section('title')
    Sector {{{ $survey->titulo or '' }}}
@endsection

@section('page-title')
    <i class="fa fa-question fa-fw"></i>Modificar Preguntas
@endsection

@section('breadcrumb')
    @parent
    <li>Preguntas</li>
    <li><a href="#">Modificar</a></li>
@endsection

@section('content')
    @if($errors->has())
        <div class="row">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <ul>
                    @foreach($errors->all() as $message)
                        <li>{{$message}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <section class="row">
        <article class="col-md-12 col-lg-12">
            @if(isset($survey))
                {{ Form::open(['action' => 'AdminController@modifySurvey', 'method' => 'POST', 'role' => 'form', 'id' => 'editSurvey', 'class' => '']) }}
                <fieldset>
                    <div class="form-group">
                        {{ Form::label('description', 'Descripción:', array('class'=>'col-md-2 control-label')) }}
                        <div class="col-sm-10">
                            {{ Form::textarea('description', $description, array('class'=>'form-control', 'placeholder'=>'Description', 'rows' => 4)) }}
                        </div>
                    </div>
                    @if(isset($survey) && isset($isMy))
                        {{ Form::loadSurvey($survey, $isMy) }}
                        @if($isMy)
                            {{ Form::submit('Modificar', ['class' => 'btn btn-primary pull-right']) }}
                        @endif
                    @endif
                    {{ Form::hidden('id_encuesta', $id, array()) }}
                </fieldset>
                {{ Form::close() }}
            @endif
        </article>
    </section>
@endsection

@section('style')
@endsection

@section('script')
    {{ HTML::script('plugins/ckeditor/ckeditor.js') }}
    {{ HTML::script('plugins/ckeditor/config.js') }}
@endsection