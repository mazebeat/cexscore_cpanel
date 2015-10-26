@extends('layouts.cpanel')

@section('title')
@endsection

@section('page-title')
	Generar URL Corta
@endsection

@section('breadcrumb')
	@parent
	<li>Shorten</li>
	<li><a href="{{ url('admin/shorten/generate') }}">Resultado</a></li>
@endsection

@section('content')
	<section class="row">
		<article class="col-md-12">
			<article class="alert alert-success">
				<h3>URL generada:</h3>
				<a class="btn btn-link" style="color: #ffffff;" href="{{ $url }}"><i class="fa fa-bolt fa-fw"></i>{{ $url }}</a>
			</article>
		</article>
	</section>
@endsection