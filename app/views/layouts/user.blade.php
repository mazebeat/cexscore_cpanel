<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"/>
	<title>@yield('title')</title>
	{{--<link rel="shortcut icon" href="http://www.umayor.cl/favicon.ico"/>--}}
	{{--<link rel="apple-touch-icon-precomposed" href="http://www.umayor.cl/favicon.ico" />--}}

	{{--LATEST COMPILED AND MINIFIED CSS--}}
	{{ HTML::style('css/bootstrap.min.css') }}
	{{--	{{ HTML::style('css/bootstrap-lumen.css') }}--}}
	{{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css') }}
	{{--{{ HTML::style('css/bootstrap-datetimepicker.css') }}--}}
	{{--RADIO BUTTON STYLE--}}
    {{ HTML::style('css/skins/all.css') }}
	{{--SELECT STYLE--}}
    {{ HTML::style('css/select2.min.css') }}
    {{ HTML::style('css/select2-bootstrap.min.css') }}

	{{--FORMVALIDATION--}}
{{--	{{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css') }}--}}
	{{ HTML::style('plugins/formvalidation/css/formValidation.min.css') }}
	{{ HTML::style('//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css') }}

	{{ HTML::style('css/frontend.min.css') }}

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	{{ HTML::script('//html5shim.googlecode.com/svn/trunk/html5.js') }}
	{{ HTML::script('//oss.maxcdn.com/respond/1.4.2/respond.min.js') }}
	<![endif]-->

	{{--EXTRAS--}}
	{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js') }}
	{{ HTML::script('//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js') }}

    @yield('style')
</head>
<body>
	<header class="container user">
		@yield('header')
	</header>
	<main class="container user">
		@yield('content')
	</main>
	<footer class="container user">
		@yield('footer')
	</footer>
	{{ HTML::script('//code.jquery.com/jquery-1.11.0.min.js') }}
	{{ HTML::script('//code.jquery.com/ui/1.11.0/jquery-ui.min.js  ') }}
	{{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('plugins/formvalidation/js/formValidation.min.js') }}
    {{ HTML::script('plugins/formvalidation/js/framework/bootstrap.min.js') }}
	{{--{{ HTML::script('js/bootstrap-datetimepicker.min.js') }}--}}
	{{ HTML::script('js/icheck.min.js') }}
    {{ HTML::script('js/select2.min.js') }}
    {{ HTML::script('js/select2_locale_es.js') }}
    {{ HTML::script('js/jquery.rut.min.js') }}
	{{ HTML::script('js/frontend.js') }}
	@yield('script')
	<a href="#" id="go-top" role="button" title="Click para ir al comienzo!" data-toggle="tooltip" data-placement="left"><i class="fa fa-chevron-circle-up fa-3x"></i></a>
</body>
</html>