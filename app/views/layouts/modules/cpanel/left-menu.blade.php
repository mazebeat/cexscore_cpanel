{{--<li class="header">HEADER</li>--}}{{--<!-- Optionally, you can add icons to the links -->--}}{{--<li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>--}}{{--<li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>--}}{{--<li class="treeview">--}}    {{--<a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>--}}    {{--<ul class="treeview-menu">--}}        {{--<li><a href="#">Link in level 2</a></li>--}}        {{--<li><a href="#">Link in level 2</a></li>--}}    {{--</ul>--}}{{--</li>--}}{{-- <li class="treeview">
	<a href="#">
		<i class="fa fa-share"></i> <span>Multilevel</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
		<li>
			<a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
				<li>
					<a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
						<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
	</ul>
</li> --}}

<li class="header">MENÚ</li>
<li class="active"><a href="{{ URL::to('/admin/login') }}"><i class="fa fa-home fa-fw"></i> <span>{{ Lang::get('messages.home') }}</span></a></li>{{-- MAIN --}}
<li class="treeview">
	<a href="#"> <i class="fa fa-share"></i> <span>Administración</span> <i class="fa fa-angle-left pull-right"></i> </a>
	<ul class="treeview-menu">
		<li><a href="{{ url('/admin/plans') }}"><i class="fa fa-circle fa-fw"></i>Planes</a></li>
		<li><a href="{{ url('/admin/sectors') }}"><i class="fa fa-circle fa-fw"></i>Sector</a></li>
		{{--<li><a href="{{ url('/admin/momentos') }}"><i class="fa fa-circle fa-fw"></i>Momento</a></li>--}}
		<li><a href="{{ url('/admin/canals') }}"><i class="fa fa-circle fa-fw"></i>Canal</a></li>
		<li><a href="{{ url('/admin/cuentas') }}"><i class="fa fa-circle fa-fw"></i>Cuenta</a></li>
		<li><a href="{{ url('/admin/encuesta') }}"><i class="fa fa-circle fa-fw"></i> Encuesta</a></li>
		<li><a href=""><i class="fa fa-circle fa-fw"></i>Periodos</a></li>

		{{-- GEO --}}
		<li class="treeview">
			<a href="#"><i class="fa fa-link"></i> <span>Geografía</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<li><a href="{{ url('/admin/pais') }}"><i class="fa fa-circle fa-fw"></i>País</a></li>
				<li><a href="{{ url('/admin/regions') }}"><i class="fa fa-circle fa-fw"></i>Región</a></li>
				<li><a href="{{ url('/admin/ciudads') }}"><i class="fa fa-circle fa-fw"></i>Ciudad</a></li>
			</ul>
		</li>
	</ul>
</li>

{{-- CLIENT --}}
<li class="treeview">
	<a href="#"><i class="fa fa-file-text-o fa-fw"></i> <span>Cuenta</span> <i class="fa fa-angle-left pull-right"></i></a>
	<ul class="treeview-menu">
		<li><a href="{{ url('/admin/shorten/generate') }}"><i class="fa fa-flash fa-fw"></i>Generar URL Corta</a></li>
		<li><a href="{{ url('/admin/survey/load') }}"><i class="fa fa-circle fa-fw"></i>Mi Encuesta</a></li>
		<li><a href="#"><i class="fa fa-circle fa-fw"></i>Momentos por Encuesta</a></li>
		<li><a href="{{ url('/admin/usuarios') }}"><i class="fa fa-circle fa-fw"></i>Usuarios</a></li>
	</ul>
</li>