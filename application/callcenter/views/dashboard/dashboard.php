<?php
$this->layout($gs_template, $ga_templatedata);
$this->addstylesheet('/assets/plugins/morris/morris.css');

$this->addscript('/assets/plugins/knob/jquery.knob.js');
$this->addscript('https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
$this->addscript('/assets/plugins/morris/morris.min.js');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Dashboard
		<small>Version 2.0</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- solid sales graph -->
	<div class="box box-solid bg-teal-gradient">
		<div class="box-header">
			<i class="fa fa-th"></i>
			<h3 class="box-title">Performance Graph</h3>
		</div>
		<div class="box-body border-radius-none">
			<div class="chart" id="line-chart" style="height: 250px;"></div>
		</div><!-- /.box-body -->
		<div class="box-footer no-border">
			<div class="row">
				<div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
					<input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60" data-fgColor="#39CCCC">
					<div class="knob-label">Mail-Orders</div>
				</div><!-- ./col -->
				<div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
					<input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60" data-fgColor="#39CCCC">
					<div class="knob-label">Online</div>
				</div><!-- ./col -->
				<div class="col-xs-4 text-center">
					<input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60" data-fgColor="#39CCCC">
					<div class="knob-label">In-Store</div>
				</div><!-- ./col -->
			</div><!-- /.row -->
		</div><!-- /.box-footer -->
	</div><!-- /.box -->
</section><!-- /.content -->

