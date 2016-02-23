@extends('layouts.cpanel')

@section('title')
	Editar Periodo
@endsection

@section('page-title')
	<i class="fa fa-pencil fa-fw"></i>Editar Periodo
@endsection

@section('breadcrumb')
	@parent
	<li>Periodos</li>
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

	{{ Form::model($periodo, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('admin.periodos.update', $periodo->id_periodo))) }}

	<div class="form-group">
		{{ Form::label('periodo', 'Periodo:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('periodo', Input::old('periodo'), array('class'=>'form-control', 'placeholder'=>'Periodo, formato: YYYY-MM')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('meta', 'Meta:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('number', 'meta', Input::old('meta'), array('class'=>'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('mes', 'Mes:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('number', 'mes', Input::old('mes'), array('class'=>'form-control', 'readonly')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('anio', 'Año:', array('class'=>'col-md-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::input('number', 'anio', Input::old('anio'), array('class'=>'form-control', 'readonly')) }}
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">&nbsp;</label>

		<div class="col-sm-10">
			{{ Form::submit('Actualizar', array('class' => 'btn btn-lg btn-primary')) }}
			{{ link_to_route('admin.periodos.show', 'Cancelar', $periodo->id_periodo, array('class' => 'btn btn-lg btn-default')) }}
		</div>
	</div>


	{{ Form::input('hidden', 'id_periodo', Input::old('id_periodo'), array('class'=>'form-control')) }}
	{{ Form::input('hidden', 'id_cliente', Input::old('id_cliente'), array('class'=>'form-control')) }}

	{{ Form::close() }}
@endsection

@section('script')
	<script>
		(function ($) {
			$('input[name="periodo"]').keyup(function (e) {
				var $this = $(this);
				if ($this.val().indexOf("-") > -1) {
					var $split = $this.val().split('-');
					$('input[name="anio"]').val($split[0]);
					$('input[name="mes"]').val(parseInt($split[1]));
				}
				e.preventDefault();
			});
		})(jQuery)
	</script>
@endsection