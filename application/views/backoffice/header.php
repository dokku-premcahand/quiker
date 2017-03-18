<?php
	$class = $this->router->fetch_class();
	$action = $this->router->fetch_method();
	$name = $class."_".$action.".css";
?>
<html>
<head>
<title><?php echo $title?></title>
<link href="<?php echo base_url('assets/css/bootstrap.css');?>" type="text/css" rel="stylesheet"/>
<link href="<?php echo base_url('assets/css/main.css');?>" type="text/css" rel="stylesheet"/>
<link href="<?php echo base_url('assets/css/jquery.dataTables.css');?>" type="text/css" rel="stylesheet"/>
<?php
	if(isset($name) && !empty($name)){
?>
		<link href="<?php echo base_url('assets/css/'.$name);?>" type="text/css" rel="stylesheet"/>
<?php
	}
?>
</head>
<body>
<?php
	if($this->session->userdata('id')){
?>
	<div class="col-lg-12">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Back Office Panel</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo base_url('backoffice/logout') ?>">Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
<?php
	}
?>