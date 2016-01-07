@extends('layouts.cpanel')

@section('title')
    Todos Usuarios [CPanel]
@endsection

@section('page-title')
    <i class="fa fa-home fa-fw"></i>Todos Usuarios [CPanel]
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Usuarios</li>
@endsection

@section('content')
    <p>{{ link_to_route('admin.usuarios.create', 'Agregar Nuevo Usuario', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if(isset($message) && $message != '')
        <div class="alert alert-info">
            <ul>
                {{ $message }}
            </ul>
        </div>
    @endif

    @if ($usuarios->count())
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>RUT Usuario</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>&nbsp;</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->nombre_usuario }}</td>
                    <td>{{ $usuario->rut_usuario }}</td>
                    <td>{{ $usuario->username }}</td>
                    <td>{{ $usuario->correo_usuario }}</td>
                    <td>
                        @if($usuario->id_tipo_usuario != 1)
                            {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.usuarios.destroy', $usuario->id_usuario))) }}
                            {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                        @endif
                        {{ link_to_route('admin.usuarios.edit', 'Editar', array($usuario->id_usuario), array('class' => 'btn btn-info')) }}

                        @if(Auth::user()->id_tipo_usuario <= 2 || $usuario->id_tipo_usuario > 2)
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="resetPasswordBtn" data-url="/admin/usuarios/resetPassword/" data-iduser="{{ $usuario->id_usuario }}"><i class="fa fa-key fa-fw"></i> Reset</a></li>
                                    <li><a href="#" class="changePasswordBtn" data-toggle="modal" data-iduser="{{ $usuario->id_usuario }}" data-target="#changePasswordModal"><i class="fa fa-key fa-fw"></i> Cambiar</a></li>
                                </ul>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 cwlass="modal-title" id="myModalLabel"><i class="fa fa-key fa-fw"></i>{{ Lang::get('user.changePassword') }} </h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <div class="alert alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong class="showErrorsTitle"></strong>
                            <ul class="showErrorsList"></ul>
                        </div>

                        {{ Form::open(array('id' => 'changePasswordForm', 'class' => '', 'role' => 'form', 'method' => 'POST', 'url' => 'admin/usuarios/changePassword/', 'data-url' => URL::to('admin/usuarios/changePassword/'), 'aria-hidden' => 'true')) }}
                        {{--<div class="form-group">--}}
                        {{--<label for="oldPassword">{{ Str::title(Lang::get('user.password')) }}</label>--}}
                        {{--                            {{ Form::password('oldPassword', array('class' => 'form-control', 'placeholder' => Lang::get('user.password'))) }}--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="password">{{ Str::title(Lang::get('user.password')) }}</label>
                            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => Lang::get('user.password'))) }}
                        </div>
                        <div class="form-group">
                            <label for="passwordAgain">Confirmar {{ Str::title(Lang::get('user.password')) }}</label>
                            {{ Form::password('passwordAgain', array('class' => 'form-control', 'placeholder' => 'Confirmar ' . Lang::get('user.password'))) }}
                        </div>
                        <button type="submit" class="btn btn-primary">Cambiar</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        No se han encontrado usuarios.
    @endif
@endsection

@section('script')
    {{ HTML::script('js/bootbox.min.js') }}
    <script>
        (function ($) {
            $('.resetPasswordBtn').on('click', function (e) {
                e.preventDefault();

                var $this = $(this);

                bootbox.confirm("Está seguro que desea restaurar la contraseña?", function (result) {
                    if (result) {
                        var $url = $this.data('url') + $this.data('iduser');
                        $.post($url, function (data) {
                            console.log(data);
                            if (!data.pass) {

                            }
                        });
                    }
                });

                return false;
            });

            $('.changePasswordBtn').on('click', function (e) {
                e.preventDefault();

                var $this = $(this);
                var $iduser = $this.data('iduser');
                var $form = $('#changePasswordModal').find('form');
                var $url = $form.data('url');

                $form.attr('action', $url + '/' + $iduser);
                $form.find('input[name="password"]').focus();
            });

            $('#changePasswordForm').submit(function (e) {
                e.preventDefault();

                var $this = $(this);
                var $url = $this.attr('action');
                var $list = $('.showErrorsList');

                $.post($url, $this.serialize(), function (data) {
                    if (!data.pass) {
                        if (!jQuery.isEmptyObject(data.message)) {
                            $list.empty();

                            $list.parent('alert').addClass('alert-danger');

                            $.each(data.message, function (i) {
                                var $li = $('<li/>')
                                        .addClass('ui-menu-item')
                                        .attr('role', 'menuitem')
                                        .appendTo($list);
                                var aaa = $('<span/>')
                                        .addClass('ui-all')
                                        .text(data.message[i])
                                        .appendTo($li);
                            });
                        }
                    } else {
                        $list.parent('alert').addClass('alert-success');
                    }
                });
            });

            $('#changePasswordModal').on('hidden.bs.modal', function () {
                var $this = $(this);
                var $form = $this.find('form');
                $form.trigger('reset');
                $('.showErrors').empty();
            });
        })(jQuery);
    </script>
@endsection