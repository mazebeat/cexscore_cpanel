@extends('layouts.cpanel2')

@section('title')
	Ver Cliente
@endsection

@section('page-title')
	<i class="fa fa-eye fa-fw"></i>Resumen {{ array_get($resumen, 'cliente.nombre_cliente') }}
@endsection

@section('breadcrumb')
	@parent
	<li>Cuenta</li>
	<li class="active">Resumen</li>
@endsection

@section('content')
	<div class="masonry-container clearfix" style="font-size: 12px;">
		{{ HTML::resumenAccount($resumen) }}
	</div>
	<div class="clearfix"></div>
	{{--	{{ \HTML::resumenUsuarios($resumen['usuarios'], ['class' => 'col-md-8 col-sm-12 col-xs-12 ']) }}--}}
	{{--<div class="clearfix"></div>--}}
	@endsection

	@section('style')    <!-- DataTables -->
	{{ HTML::style('template/plugins/datatables/dataTables.bootstrap.css') }}
	<style>
		.item {
			/*float: right;*/
			/*width: 80px;*/
			/*height: 60px;*/
			/*border: 2px solid hsla(0, 0%, 0%, 0.5);*/
		}
	</style>
	@endsection

	@section('script')        <!-- DataTables -->
	{{ HTML::script('template/plugins/datatables/jquery.dataTables.min.js') }}
	{{ HTML::script('template/plugins/datatables/dataTables.bootstrap.min.js') }}
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

			$('#userTable').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
		})(jQuery);
	</script>
@endsection