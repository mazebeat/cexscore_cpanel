<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>@yield('title')</title>

	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('backend/css/bootstrap-lumen.min.css') }}
	{{ HTML::style('backend/css/dashboard.css') }}
	{{ HTML::style('backend/css/backend.min.css') }}

	{{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>

@include('layouts.modules.cpanel.top-menu')
<main class="container-fluid">
	<section class="row">
		<article class="col-sm-3 col-md-2 sidebar">
			@include('layouts.modules.cpanel.left-menu')
		</article>
		<article class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<section class="row">
				<article class="col-lg-12">
					<h1 class="page-header">
						@yield('page-title')
					</h1>
					<ol class="breadcrumb">
						@section('breadcrumb')
							<li><i class="fa fa-home fa-fw"></i><a href="{{ url('admin/login') }}">Inicio</a></li>
						@show
					</ol>
				</article>
			</section>

			@if (Session::has('message'))
				<div class="flash alert">
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif

			@yield('main')
		</article>
	</section>
</main>
{{ HTML::script('//code.jquery.com/jquery-1.11.0.min.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
</body>
</html>