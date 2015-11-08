@extends('layouts.cpanel2')

@section('title')
@endsection

@section('page-title')
	<i class="fa fa-home fa-fw"></i>Inicio
@endsection

@section('breadcrumb')
	@parent
@endsection

@section('content')
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Cuentas</span> <span class="info-box-number" id="qAccounts"></span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-bookmark-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Planes</span> <span class="info-box-number" id="qPlans"></span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="fa fa-user-plus"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Usuarios</span> <span class="info-box-number" id="qUsers"><small></small></span>
				</div><!-- /.info-box-content -->
			</div><!-- /.info-box -->
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Tabla NPS</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class='table table-condensed table-striped table-hover borderless2'>
						<thead>
						<tr>
							<th class='text-left datatable-header'></th>
							<th class='text-center datatable-header'><i class='fa fa-thumbs-o-up fa-2x good'></th>
							<th class='text-center datatable-header'><i class='fa fa-thumbs-o-down fa-2x bad'></th>
							<th class='text-center datatable-header'>
								<span style='font-size: 14px' title='NPS: Índice de Promotores Netos&#13;Obtenido por la diferencia entre el % de promotores menos el % de detractores'>NPS</span></th>
						</tr>
						</thead>
						<tbody id="npsTable"></tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Cuentas Activas</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div id="activeAccounts" style="width: 100%; height: 350px; background-color: #FFFFFF;"></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
		<div class="col-md-5 col-sm-12 col-xs-12">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Cuentas por Plan</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div id="accountByPlan" style="width: 100%; height: 350px; background-color: #FFFFFF;"></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
@endsection

@section('style')
@endsection

@section('script')
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
	<!-- ChartJS 1.0.1 -->
	{{ HTML::script('template/plugins/chartjs/Chart.min.js') }}
	<script type="text/javascript">
		(function ($) {
			var clientsByPlan, countClients;
			$.get('/admin/find/cpanel', function (data) {
				var accountsByPlan = AmCharts.makeChart("accountByPlan", {
					"type": "pie",
					"adjustPrecision": true,
					"balloonText": "<strong>[[title]]:</strong> <span style='font-size:14px'> [[value]] ([[percents]]%)</span>",
					"innerRadius": "70%",
					"labelRadius": 0,
					"minRadius": 100,
					"pullOutRadius": "15%",
					"startAngle": 12,
					"groupedAlpha": 0,
					"groupedColor": "",
					"hideLabelsPercent": 100,
					"hoverAlpha": 0.5,
					"labelsEnabled": false,
					"labelTickAlpha": 0,
					"marginBottom": 0,
					"marginTop": 0,
					"outlineAlpha": 1,
					"outlineThickness": 2,
					"pullOutDuration": 0.2,
					"pullOutEffect": "easeInSine",
					"sequencedAnimation": false,
					"startDuration": 0,
					"startEffect": "easeOutSine",
					"titleField": "plan",
					"valueField": "count",
					"addClassNames": true,
					"fontFamily": "Arial",
					"fontSize": 12,
					"allLabels": [],
					"balloon": {
						"borderColor": "#008000",
						"borderThickness": 1,
						"fadeOutDuration": 0.1,
						"pointerWidth": 8,
						"shadowAlpha": 0.09,
						"textAlign": " middle"
					},
					"export": {
						"enabled": true
					},
					"legend": {
						"align": "center",
						"autoMargins": false,
						"backgroundColor": "",
						"marginLeft": 10,
						"marginRight": 10,
						"markerBorderAlpha": 0,
						"markerBorderColor": "#55CB2B",
						"markerBorderThickness": 20,
						"markerType": "circle",
						"rollOverColor": "#FF8000",
						"rollOverGraphAlpha": 0,
						"switchType": "v",
						"textClickEnabled": true
					},
					"titles": [],
					"dataProvider": data.clientsByPlan
				});
				var activeAccounts = AmCharts.makeChart("activeAccounts", {
					"type": "pie",
					"adjustPrecision": true,
					"balloonText": "<strong>[[title]]:</strong> <span style='font-size:14px'> [[value]] ([[percents]]%)</span>",
					"innerRadius": "70%",
					"labelRadius": 0,
					"minRadius": 100,
					"pullOutRadius": "15%",
					"startAngle": 72,
					"groupedAlpha": 0,
					"groupedColor": "",
					"hideLabelsPercent": 100,
					"hoverAlpha": 0.5,
					"labelsEnabled": false,
					"labelTickAlpha": 0,
					"marginBottom": 0,
					"marginTop": 0,
					"outlineAlpha": 1,
					"outlineThickness": 2,
					"pullOutDuration": 0.2,
					"pullOutEffect": "easeInSine",
					"sequencedAnimation": false,
					"startDuration": 0,
					"startEffect": "easeOutSine",
					"titleField": "legend",
					"valueField": "count",
					"addClassNames": true,
					"fontFamily": "Arial",
					"fontSize": 12,
					"allLabels": [],
					"balloon": {
						"borderColor": "#008000",
						"borderThickness": 1,
						"fadeOutDuration": 0.1,
						"pointerWidth": 8,
						"shadowAlpha": 0.09,
						"textAlign": " middle"
					},
					"export": {
						"enabled": true
					},
					"legend": {
						"align": "center",
						"autoMargins": false,
						"backgroundColor": "",
						"marginLeft": 10,
						"marginRight": 10,
						"markerBorderAlpha": 0,
						"markerBorderColor": "#55CB2B",
						"markerBorderThickness": 20,
						"markerType": "circle",
						"rollOverColor": "#FF8000",
						"rollOverGraphAlpha": 0,
						"switchType": "v",
						"textClickEnabled": true
					},
					"titles": [],
					"dataProvider": data.countClients
				});
				accountsByPlan.validateNow();
				activeAccounts.validateNow();

				$('#qAccounts').text(data.totalClients);
				$('#qPlans').text(data.totalPlans);
				$('#qUsers').text(data.totalUsers);
				$('#npsTable').html(data.npsTable);
			});
		})(jQuery);
	</script>
@endsection