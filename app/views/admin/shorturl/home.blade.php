@extends('layouts.cpanel')

@section('title')
@endsection

@section('page-title')
	<i class="fa fa-bolt fa-fw"></i>Generar URL corta
@endsection

@section('breadcrumb')
	@parent
	<li>Shorten</li>
	<li><a href="{{ URL::to('admin/shorten/generate') }}">Generar</a></li>
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
	{{--<div class="row">--}}
		{{--<div class="shortit">--}}
			{{Form::open(array('url' => 'admin/shorten', 'method' => 'POST', 'class' => 'form-search'))}}
			<div class="form-group">
				<div id="custom-search-input">
					{{ Form::label('client', 'Cliente:', array('class'=>'col-md-2 control-label')) }}
					<div class="input-group col-md-10">
						{{ Form::select('client', $clients, Input::old('client'), ['class' => 'form-control', 'placeholder' => 'Cliente...']) }}
					</div>
				</div>
			</div>
			<div class="form-group">
				<div id="custom-search-input">
					{{ Form::label('canal', 'Canal:', array('class'=>'col-md-2 control-label')) }}
					<div class="input-group col-md-10">
						{{ Form::select('canal', $canals, Input::old('canal'), ['class' => 'form-control', 'placeholder' => 'Canal...']) }}
					</div>
				</div>
			</div>
			<div class="form-group">
				<div id="custom-search-input">
					{{ Form::label('momento', 'Momento:', array('class'=>'col-md-2 control-label')) }}
					<div class="input-group col-md-10">
						{{ Form::select('momento', $moments, Input::old('momento'), ['class' => 'form-control', 'placeholder' => 'Momento...']) }}
					</div>
				</div>
			</div>
			<hr>
			<div class="form-group">
				{{Form::url('url',null, array('placeholder' => 'Pegue el link...', 'class' => 'form-control'))}}
			</div>
			<button class="btn btn-info pull-right" type="submit"><i class="fa fa-magic fa-fw"></i>Generar</button> {{Form::close()}}
		{{--</div>--}}
	{{--</div>--}}
@endsection