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
			<span><a href="<?php echo site_url();?>"><?php echo Database_manager::get_db(TRUE)->get_where('database',array('name'=>Database_manager::get_db()->database),1)->row()->school; ?></a></span>
			<div id="sc-logo-sub" class="sc-simple-sub">
				<ul>
					<li><a target="_blank" href="http://schools.scadsy.za.org/about.php">About SCADSY</a></li>
					<li><a target="_blank" href="http://schools.scadsy.za.org/">Main website</a></li>
					<li><a target="_blank" href="http://schools.scadsy.za.org/docs">Documentation</a></li>
				</ul>
			</div>
		</div>
		
		<div id="sc-quick-menu" show="#sc-quick-menu-sub">
			<span>Hello, <?php $user = new User(); echo $user->get_by_logged_in()->username; ?></span>
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
		
		<?php echo $notifications; ?>
		
		<div id="sc-page-content">
