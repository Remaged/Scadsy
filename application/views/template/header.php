<!DOCTYPE html>
<html>
<head>
	<title>SCADSY - School Administration System</title>
	<?php echo $scripts; ?>
	<?php echo $stylesheets; ?>
</head>

<body>
	<div id="sc-top-bar">
		<div id="sc-logo" show="#sc-logo-sub">
			<span><a href="<?php echo site_url();?>">SCADSY</a></span>
			<div id="sc-logo-sub" class="sc-simple-sub">
				<ul>
					<li><a target="_blank" href="http://schools.scadsy.za.org/about.php">About SCADSY</a></li>
					<li><a target="_blank" href="http://schools.scadsy.za.org/">Main website</a></li>
					<li><a target="_blank" href="http://schools.scadsy.za.org/docs">Documentation</a></li>
				</ul>
			</div>
		</div>
		
		<div id="sc-quick-menu" show="#sc-quick-menu-sub">
			<span>Hello, USER</span>
			<div id="sc-quick-menu-sub" class="sc-simple-sub">
				<ul>
					<li><a href="#">Change profile</a></li>
					<li><a href="<?php echo site_url('user/login/logout'); ?>">Logout</a></li>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div id="sc-left-box">
		<div id="sc-main-menu-back"></div>
		<div id="sc-menu">
			<?php echo $menu; ?>
		</div>
	</div>
	
	<div id="sc-right-box">
	
	<div id="sc-page">
		
		<div class="sc-msg sc-msg-update">
			<a href="#">SCADSY Alpha V0.2</a> is available! <a href="#">Update now</a>.
		</div>
		
		<div class="sc-msg sc-msg-error">
			Hearthbleed SSL has infected us to. More information <a href="#">here</a>.
		</div>
		
		<div id="sc-page-content">
