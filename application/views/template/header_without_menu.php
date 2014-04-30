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

		</div>
		<div class="clear"></div>
	</div>
	
	<div id="sc-left-box">
		<div id="sc-main-menu-back"></div>
		<div id="sc-menu">
			<?php //echo $menu; ?>
		</div>
	</div>
	
	<div id="sc-right-box">
	
	<div id="sc-page">
		
		<?php echo $notifications; ?>
		
		<div id="sc-page-content">
