@extends('layouts.cpanel')

@section('title')
    Crear Cuenta
@endsection

@section('page-title')
    <i class="fa fa-plus fa-fw"></i>Agregar Cuenta
@endsection

@section('breadcrumb')
    @parent
    <li>Cuentas</li>
    <li class="active">Agregar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{ Form::open(array('route' => 'admin.cuentas.store', 'class' => 'form-horizontal', 'id' => 'createClientForm', 'files' => true)) }}
    <div id="rootwizard">
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
            <div role="tabpanel" class="tab-pane main active" id="tab1">
                @include('admin.cuentas.tabs.cuenta')
            </div>
            {{--END TAB 1--}}

            {{--BEGIN TAB 2 - CONTACTO--}}
            <div role="tabpanel" class="tab-pane main" id="tab2">
                @include('admin.cuentas.tabs.admin')
            </div>
            {{--END TAB 2--}}

            {{--BEGIN TAB 3 - PLAN--}}
            <div role="tabpanel" class="tab-pane main" id="tab3">
                @include('admin.cuentas.tabs.config')
            </div>
            {{--END TAB 3--}}

            {{--BEGIN TAB 4 - ENCUESTA--}}
            <div role="tabpanel" class="tab-pane main" id="tab4">
                @include('admin.cuentas.tabs.encuesta')
            </div>
            {{--END TAB 4--}}

            {{--BEGIN TAB 5 - APARIENCIA--}}
            <div role="tabpanel" class="tab-pane main" id="tab5">
                @include('admin.cuentas.tabs.apariencia')
            </div>
            {{--END TAB 5--}}

            {{--BEGIN NAVEGATION--}}
            <ul class="pager wizard">
                <li class="previous"><a href="javascript: void(0);">{{ Lang::get('pagination.previous') }}</a></li>
                <li class="next"><a href="javascript: void(0);">{{ Lang::get('pagination.next') }}</a></li>
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
    {{ HTML::style('plugins/bootstrap_wizard/prettify.min.css')  }}
    {{ HTML::style('plugins/jquery-steps/css/jquery.steps.min.css')  }}
    {{ HTML::style('backend/css/nav-wizard.bootstrap.min.css') }}
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
    {{--Bootstrap Wizard--}}
    {{ HTML::script('plugins/bootstrap_wizard/jquery.bootstrap.wizard.min.js') }}
    {{ HTML::script('plugins/jquery-steps/js/jquery.steps.min.js') }}
    {{ HTML::script('plugins/bootstrap_wizard/prettify.min.js') }}

    {{--jQuery RUT--}}
    {{ HTML::script('js/jquery.rut.min.js') }}

    {{--CKEditor--}}
    {{ HTML::script('plugins/ckeditor/ckeditor.js') }}
    {{ HTML::script('plugins/ckeditor/adapters/jquery.min.js') }}
    {{--{{ HTML::script('plugins/ckeditor/config.js') }}--}}

    {{--InputMask--}}
    {{ HTML::script('plugins/input-mask/jquery.inputmask.min.js') }}
    {{ HTML::script('plugins/input-mask/jquery.inputmask.date.extensions.min.js') }}
    {{ HTML::script('plugins/input-mask/jquery.inputmask.extensions.min.js') }}

    {{--JS Create cliente--}}
    {{ HTML::script('js/cliente.create.js') }}
@endsection