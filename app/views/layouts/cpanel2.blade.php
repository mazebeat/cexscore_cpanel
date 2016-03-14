<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>..::Panel de Control::..</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('layouts.modules.favicon')

    <!-- Bootstrap 3.3.5 -->
    {{ HTML::style('template/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('backend/css/backend.min.css') }}
    {{-- {{ HTML::style('backend/css/bootstrap-lumen.min.cs') }} --}}

    {{--Form Validation--}}
    {{ HTML::style('plugins/formvalidation/css/formValidation.min.css') }}

    {{--JQuery UI--}}
    {{ HTML::style('//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.min.css') }}

    {{--Font Awesome--}}
    {{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') }}

    {{--Ionicons--}}
    {{ HTML::style('//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}

    {{--Theme style--}}
    {{ HTML::style('template/dist/css/AdminLTE.min.css') }}
    {{ HTML::style('template/dist/css/skins/_all-skins.min.css') }}

    {{ HTML::style('plugins/bootstrap_wizard/prettify.min.css')  }}
    {{ HTML::style('plugins/icheck/skins/all.min.css') }}

    <style>
        html, body {
            zoom: 0.95;
            -ms-zoom: 0.95;
            -webkit-zoom: 0.95;
            -moz-transform: scale(0.95, 0.95);
            -moz-transform-origin: top center;
        }
    </style>
    @yield('style')

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-yellow fixed">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{('admin/login')  }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>C</b>PANEL</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Control</b>PANEL</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars"></i>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    @if(Config::get('config.cpanel.showMessages'))
                    @include('layouts.modules.cpanel.messages')
                    @endif

                            <!-- Notifications: style can be found in dropdown.less -->
                    @if(Config::get('config.cpanel.showNotifications'))
                    @include('layouts.modules.cpanel.notifications')
                    @endif

                            <!-- Tasks: style can be found in dropdown.less -->
                    @if(Config::get('config.cpanel.showTasks'))
                    @include('layouts.modules.cpanel.tasks')
                    @endif

                            <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                            <span class="hidden-xs">{{ Str::upper(Auth::user()->nombre_usuario) }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <p>
                                    {{ Str::title(Auth::user()->nombre_usuario) }} - {{ Str::title(Auth::user()->rol_usuario == '' ? 'Usuario' : Auth::user()->rol_usuario) }}
                                    <small>{{ Carbon::now()->toDateString() }} <span id="timer"></span></small>
                                </p>
                            </li>
                            {{--<!-- Menu Body -->--}}
                            {{--<li class="user-body">--}}
                            {{--</li>--}}
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat">{{ Lang::get('messages.signout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                {{--<div class="pull-left image">--}}
                {{--{{ HTML::image('template/dist/img/user2-160x160.jpg', 'User Image', ['class' => 'img-circle']) }}--}}
                {{--</div>--}}
                {{--<div class="pull-left info">--}}
                <p style="color: white;">{{ Str::upper(Auth::user()->nombre_usuario) }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                {{--</div>--}}
                <div class="clearfix"></div>
            </div>
            {{--<!-- search form -->--}}
            @if(Config::get('config.cpanel.showSearchInput'))
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
								<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
							</span>
                    </div>
                </form>
                @endif
                {{--<!-- /.search form -->--}}

                        <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    @include('layouts.modules.cpanel.left-menu')
                </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page-title')
            </h1>
            <ol class="breadcrumb">
                @yield('breadcrumb')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            @yield('content')

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
        @include('layouts.modules.cpanel.footer')
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        @include('layouts.modules.cpanel.sidebar')
    </aside><!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 2.1.4 -->
{{ HTML::script('//code.jquery.com/jquery-2.1.4.min.js') }}

        <!-- Bootstrap 3.3.5 -->
{{ HTML::script('template/bootstrap/js/bootstrap.min.js') }}

        <!-- Slimscroll -->
{{ HTML::script('template/plugins/slimScroll/jquery.slimscroll.min.js') }}

        <!-- FastClick -->
{{ HTML::script('template/plugins/fastclick/fastclick.min.js') }}

{{-- Form Validation --}}
{{ HTML::script('plugins/formvalidation/js/formValidation.min.js') }}
{{ HTML::script('plugins/formvalidation/js/framework/bootstrap.min.js') }}
{{ HTML::script('plugins/formvalidation/js/language/es_CL.min.js')  }}

{{ HTML::script('plugins/icheck/icheck.min.js') }}

        <!-- cdn for modernizr, if you haven't included it already -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<!-- polyfiller file to detect and load polyfills -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
    webshims.setOptions('waitReady', false);
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script>

@yield('script')

        <!-- AdminLTE App -->
<script>

    var AdminLTEOptions = {
        //Add slimscroll to navbar menus
        //This requires you to load the slimscroll plugin
        //in every page before app.js
        navbarMenuSlimscroll: true,
        navbarMenuSlimscrollWidth: "3px", //The width of the scroll bar
        navbarMenuHeight: "200px", //The height of the inner menu
        //General animation speed for JS animated elements such as box collapse/expand and
        //sidebar treeview slide up/down. This options accepts an integer as milliseconds,
        //'fast', 'normal', or 'slow'
        animationSpeed: 500,
        //Sidebar push menu toggle button selector
        sidebarToggleSelector: "[data-toggle='offcanvas']",
        //Activate sidebar push menu
        sidebarPushMenu: true,
        //Activate sidebar slimscroll if the fixed layout is set (requires SlimScroll Plugin)
        sidebarSlimScroll: true,
        //Enable sidebar expand on hover effect for sidebar mini
        //This option is forced to true if both the fixed layout and sidebar mini
        //are used together
        sidebarExpandOnHover: true,
        //BoxRefresh Plugin
        enableBoxRefresh: true,
        //Bootstrap.js tooltip
        enableBSToppltip: true,
        BSTooltipSelector: "[data-toggle='tooltip']",
        //Enable Fast Click. Fastclick.js creates a more
        //native touch experience with touch devices. If you
        //choose to enable the plugin, make sure you load the script
        //before AdminLTE's app.js
        enableFastclick: true,
        //Control Sidebar Options
        enableControlSidebar: true,
        controlSidebarOptions: {
            //Which button should trigger the open/close event
            toggleBtnSelector: "[data-toggle='control-sidebar']",
            //The sidebar selector
            selector: ".control-sidebar",
            //Enable slide over content
            slide: true
        },
        //Box Widget Plugin. Enable this plugin
        //to allow boxes to be collapsed and/or removed
        enableBoxWidget: true,
        //Box Widget plugin options
        boxWidgetOptions: {
            boxWidgetIcons: {
                //Collapse icon
                collapse: 'fa-minus',
                //Open icon
                open: 'fa-plus',
                //Remove icon
                remove: 'fa-times'
            },
            boxWidgetSelectors: {
                //Remove button selector
                remove: '[data-widget="remove"]',
                //Collapse button selector
                collapse: '[data-widget="collapse"]'
            }
        },
        //Direct Chat plugin options
        directChat: {
            //Enable direct chat by default
            enable: true,
            //The button to open and close the chat contacts pane
            contactToggleSelector: '[data-widget="chat-pane-toggle"]'
        },
        //Define the set of colors to use globally around the website
        colors: {
            lightBlue: "#3c8dbc",
            red: "#f56954",
            green: "#00a65a",
            aqua: "#00c0ef",
            yellow: "#f39c12",
            blue: "#0073b7",
            navy: "#001F3F",
            teal: "#39CCCC",
            olive: "#3D9970",
            lime: "#01FF70",
            orange: "#FF851B",
            fuchsia: "#F012BE",
            purple: "#8E24AA",
            maroon: "#D81B60",
            black: "#222222",
            gray: "#d2d6de"
        },
        //The standard screen sizes that bootstrap uses.
        //If you change these in the variables.less file, change
        //them here too.
        screenSizes: {
            xs: 480,
            sm: 768,
            md: 992,
            lg: 1200
        }
    };
</script>
{{ HTML::script('template/dist/js/app.min.js') }}
</body>
</html>