<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?= $gs_title ?> | MF</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="<?= $this->asset('/assets/vendors/mercury/framework/bootstrap/css/bootstrap.min.css') ?>">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?= $this->asset('/assets/vendors/mercury/framework/css/AdminLTE.min.css') ?>">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
				 folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="<?= $this->asset('/assets/vendors/mercury/framework/css/skins/skin-blue.min.css') ?>">
		<!-- Date Picker -->
		<link rel="stylesheet" href="<?= $this->asset('/assets/vendors/mercury/framework/plugins/datepicker/datepicker3.css') ?>">
		<!-- Daterange picker -->
		<link rel="stylesheet" href="<?= $this->asset('/assets/vendors/mercury/framework/plugins/daterangepicker/daterangepicker-bs3.css') ?>">
		<!-- bootstrap wysihtml5 - text editor -->
		<link rel="stylesheet" href="<?= $this->asset('/assets/vendors/mercury/framework/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') ?>">
		<!-- DataTables -->
		<link rel="stylesheet" href="<?= $this->asset('/assets/plugins/datatables/dataTables.bootstrap.css') ?>">

		<?= $this->getstylesheets(); ?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
				<script src="http://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
				<script src="http://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">

			<header class="main-header">
				<!-- Logo -->
				<a href="/admin" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>M</b>F CRM</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>M</b>F CRM</span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown messages-menu">
								<a href="/" target="_blank">
									<i class="fa fa-eye"></i>
								</a>
							</li>
							<li class="dropdown messages-menu">
								<a href="?xhprof=1">
									<i class="fa fa-tachometer"></i>
								</a>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">

					<!-- search form -->
					<form action="/admin/gitsearch" method="get" class="sidebar-form">
						<div class="input-group">
							<input type="text" name="q" class="form-control" placeholder="Search..." value="<?= $this->getvalue('q') ?>">
							<span class="input-group-btn">
								<button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
					<!-- /.search form -->
					<!-- sidebar menu: : style can be found in sidebar.less -->
					<ul class="sidebar-menu">
						<li class="header">MAIN NAVIGATION</li>

						<li class="<?= $gs_currentpage == '/callcenter/dashboard' ? active : ''?>">
							<a href="/callcenter/dashboard">
								<i class="fa fa-tachometer"></i> <span>Dashboard</span>
							</a>
						</li>

						<li class="<?= $gs_currentpage == '/callcenter/data' ? active : ''?>">
							<a href="/callcenter/data">
								<i class="fa fa-database"></i> <span>Data</span>
							</a>
						</li>

						<li class="treeview <?= in_array($gs_currentpage, ['/callcenter/all-data', '/callcenter/researching-data']) ? active : ''?>">
							<a href="#">
								<i class="fa fa-database"></i> <span>Data</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="/callcenter/all-data"><i class="fa fa-circle-o"></i> All Data</a></li>
								<li><a href="/callcenter/researching-data"><i class="fa fa-circle-o"></i> Researching</a></li>
								<li><a href="/callcenter/all-data"><i class="fa fa-circle-o"></i> Usable</a></li>
							</ul>
						</li>

					</ul>
				</section>
				<!-- /.sidebar -->
			</aside>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">

				<?= $this->section('content') ?>

			</div><!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>Version</b> <?= $gs_version ?>
				</div>
				<strong>Copyright &copy; <?= $gi_copyrightyear ?> <a href="https://github.com/mercury/framework" target="_blank">Mercury</a>.</strong> All rights reserved.
			</footer>

		</div><!-- ./wrapper -->

		<!-- jQuery 2.1.4 -->
		<script src="<?= $this->asset('/assets/vendors/mercury/framework/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button);
		</script>
		<!-- Bootstrap 3.3.5 -->
		<script src="<?= $this->asset('/assets/vendors/mercury/framework/bootstrap/js/bootstrap.min.js') ?>"></script>
		<!-- daterangepicker -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
		<script src="/assets/vendors/mercury/framework/plugins/daterangepicker/daterangepicker.js"></script>
		<!-- datepicker -->
		<script src="/assets/vendors/mercury/framework/plugins/datepicker/bootstrap-datepicker.js"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script src="/assets/vendors/mercury/framework/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<!-- Slimscroll -->
		<script src="/assets/vendors/mercury/framework/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="/assets/vendors/mercury/framework/plugins/fastclick/fastclick.min.js"></script>
		<!-- AdminLTE App -->
		<script src="/assets/vendors/mercury/framework/js/app.min.js"></script>
		<!-- DataTables -->
		<script src="<?= $this->asset('/assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
		<script src="<?= $this->asset('/assets/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

		<script src="/assets/js/callcenter.js"></script>

		<?= $this->getscripts() ?>

	</body>
</html>
