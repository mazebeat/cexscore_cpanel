@extends('layouts.cpanel2')

@section('title')
    Ver Cliente
@endsection

@section('page-title')
    <i class="fa fa-eye fa-fw"></i>Resumen {{ Session::get('account.name', array_get($resumen, 'cliente.nombre_cliente')) }}
@endsection

@section('breadcrumb')
    @parent
    <li class=""><a href="{{ url('admin/cuentas')  }}">Cuentas</a></li>
    <li class="active">Resumen</li>
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-xs-12" style="margin-bottom: 5px;">
            {{ Form::open(array('class' => 'pull-right', 'url' => 'pdf/getZip')) }}
            {{ Form::hidden('idCliente', array_get($resumen, 'cliente.id_cliente')) }}
            {{ Form::submit('Herramientas de tracci&oacute;n', array('class' => 'btn btn-xs btn-warning')) }}
            {{ Form::close() }}
        </div>
    </div>
    <div class="masonry-container clearfix" style="font-size: 12px;">
        {{ HTML::resumenAccount($resumen) }}
    </div>
    @endsection

    @section('style')    <!-- DataTables -->
    {{ HTML::style('template/plugins/datatables/dataTables.bootstrap.css') }}
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>
    <script>
        (function ($) {
            var $container = $('.masonry-container');
            $container.masonry({
                columnWidth: '.item',
                itemSelector: '.item',
                percentPosition: true,
                isAnimated: true
            });

//			$('#userTable').DataTable({
//				"paging": true,
//				"lengthChange": false,
//				"searching": false,
//				"ordering": true,
//				"info": true,
//				"autoWidth": true
//			});
        })(jQuery);
    </script>
@endsection