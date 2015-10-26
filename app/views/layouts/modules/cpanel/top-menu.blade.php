<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			{{--<a class="navbar-brand" href="{{ url('admin/login') }}">CPanel CEX Score</a>--}}
			<a class="navbar-brand" href="{{ url('admin/login') }}">{{ HTML::image('image/customertrigger/customertrigger-score.png', '', ['class' => '', 'style' => 'max-width: 200px']) }}</a>
{{--			<a class="navbar-brand col-xs-4" href="{{ url('admin/login') }}">{{ HTML::image('image/customertrigger/customertrigger-score.png', '', ['class' => 'img-responsive']) }}</a>--}}
		</div>

		<div id="navbar" class="navbar-collapse collapse">
			<div class="hidden-md hidden-lg">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('admin/shorten/generate') }}">Generar URL Corta</a></li>
					<li class="divider"></li>
					<li><a href="{{ url('admin/survey/load') }}">Modificar Preguntas</a></li>
				</ul>
			</div>
			<form class="navbar-form navbar-left" role="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Buscar...">
				</div>
				<button type="submit" class="btn btn-default">Buscar</button>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->nombre_usuario }}
						<b class="caret"></b></a> {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Session::get('user.back')->nombre_usuario }} <b class="caret"></b></a>--}}
					<ul class="dropdown-menu">
						<li class="divider"></li>
						<li>
							<a href="{{ url('admin/logout') }}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>