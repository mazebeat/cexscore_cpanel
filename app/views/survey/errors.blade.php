@extends('layouts.user')

@section('style')
	<style type="text/css">
		.code_error {
			font-size: 9vw;
		}
	</style>
@stop

@section('content')
	<section class="row">
		<article class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 text-center">
			@if ($errors->has())
				@if($errors->any())
					{{ HTML::alert('danger', $errors->all(), null) }}
				@endif
			@endif
			@if(isset($error))
				<h3>Oops! Sentimos la molestia</h3>
				<h1 class="text-uppercase code_error">Error! <i class="fa fa-terminal fa"></i><strong>{{ $error->code or 500 }}</strong></h1>
				<h4>{{ $error->message  }}</h4>
			@endif
			@if(isset($code))
				<h3>Oops! Sentimos la molestia</h3>
				<h1 class="text-uppercase code_error">Error! <i class="fa fa-terminal fa"></i><strong>{{ $code }}</strong></h1>
				@if(isset($exception))
					{{-- <small>{{ $exception }}</small> --}}
				@endif
			@endif
		</article>
	</section>
@stop