@extends('layouts.user')

@section('style')
	@if(isset($theme))
		@include('layouts.theme')
	@endif
	<style>
		.incentive img {
			margin-bottom: 10px;
		}
	</style>
@endsection

@section('header')
	@if(isset($theme) && !is_null($theme->logo_header))
		<section class="row">
			<article class="col-xs-12 col-sm-10 col-md-6 col-lg-6 col-center-block">
				{{ HTML::image($theme->logo_header, 'header-logo', array('class' => 'img-responsive center-block')) }}
			</article>
		</section>
	@endif
@endsection

@section('content')
	@if(isset($theme) && !is_null($theme->logo_incentivo))
		<article class="row">
			<section class="col-xs-6 col-sm-4 col-md-3 col-lg-3 col-center-block">
				{{ HTML::image($theme->logo_incentivo, 'Incentivo', array('class' => 'img-responsive center-block')) }}
			</section>
		</article>
	@endif
	<section class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center instrucciones">
			@if(isset($message))
				<h1>{{ $message->title }}</h1>
				<h4>{{ $message->subtitle }}</h4>
			@endif
		</article>
	</section>
@stop

@section('footer')
	@include('survey.footer')
@endsection

@section('script')
	<script type="text/javascript">
		@if(isset($script))
			{{ $script }}
		@endif
	</script>
@stop