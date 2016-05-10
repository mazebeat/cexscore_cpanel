@extends('layouts.cpanel')

@section('title')
    Cuentas
@endsection

@section('page-title')
    <i class="fa fa-home fa-fw"></i>Cuentas
@endsection

@section('breadcrumb')
    @parent
    <li class="active"><a href="{{ url('admin/cuentas') }}">Cuentas</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                    </ul>
                </div>
            @endif

            @if (isset($message))
                <div class="alert alert-success">
                    <ul class="list-unstyled">
                        <li>{{ $message }}</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <p>{{ link_to_route('admin.cuentas.create', 'Agregar Nueva Cuenta', null, array('class' => 'btn btn-lg btn-success')) }}</p>

    @if ($cuentas->count())
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                {{-- <th>Fono</th> --}}
                <th>Web Site</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($cuentas as $cliente)
                <tr>
                    <td>{{ $cliente->rut_cliente }}</td>
                    <td>{{ $cliente->nombre_cliente }}</td>
                    {{-- <td>{{ $cliente->fono_fijo_cliente }}</td> --}}
                    <td>{{ $cliente->correo_cliente }}</td>
                    <td class="pull-right">
                        @if($cliente->id_cliente != 1)
                            {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('admin.cuentas.destroy', $cliente->id_cliente))) }}
                            {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                            {{ Form::close() }}
                        @endif
                        {{ link_to_route('admin.cuentas.edit', 'Editar', array($cliente->id_cliente), array('class' => 'btn btn-info')) }}
                        {{ link_to_action('CuentasController@resumen', 'Resumen', array($cliente->id_cliente), array('class' => 'btn btn-link')) }}
                        @if($cliente->id_cliente != 1)
                            {{ Form::open(array('class' => 'xover', 'style' => 'display: inline-block;', 'method' => 'POST', 'url' => 'http://' . Config::get('config.cexscore.ipaddress'), 'target' => '_blank')) }}
                            {{ Form::hidden('cliente', $cliente->id_cliente) }}
                            {{ Form::hidden('xover') }}
                            {{ Form::hidden('username') }}
                            {{ Form::hidden('password') }}
                            <a class="btn btn-warning xoverbutton" href="#"><i class="fa fa-external-link"></i></a>
                            {{ Form::close() }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $cuentas->links() }}
    @else
        No se han encontrado cuentas.
    @endif
@endsection

@section('script')
    <script>
        (function ($) {

            $('.xoverbutton').click(function (e) {
                e.preventDefault();

                var $this = $(this);
                var $form = $(this).parent();
                var user = $form.find('input[name="username"]').val();

                $this.html('<i class="fa fa-circle-o-notch fa-spin"></i>');

                $.post('/admin/find/username', $form.serialize(), function (data) {
                    if (data.pass) {
                        $form.find('input[name="username"]').val(data.username);
                        $form.find('input[name="password"]').val(data.password);
                        $form.find('input[name="xover"]').val(data.xover);
                        $form.submit();
                        $this.html('<i class="fa fa-external-link"></i>');
                    }
                });
            });
        })(jQuery)
    </script>
@endsection