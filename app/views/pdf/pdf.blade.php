<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="pdf">
	<meta name="author" content="mazebeat">
	<title>@yield('title')</title>

	<link href="{{ public_path('assets/bootstrap-3.3.5/css/bootstrap.css') }}" rel="stylesheet">
	<style type="text/css">
		html, body {
			height: 100%;
		}

		.wrapper {
			min-height: 100%;
			height: auto !important;
			height: 100%;
			margin: 0 auto -142px;
		}

		footer {
			position: fixed;
			bottom: 50px;
			width: 100%;
		}

		.borderless tr td {
			border: none !important;
			padding: 0px !important;
		}
	</style>
</head>

<body>
<div id="wrap">
	<div class="container">
		@yield('content')
	</div>
</div>
<footer role="footer">
	<div class="container">
		@yield('footer')
	</div>
</footer>
</body>
</html>