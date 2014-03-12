<!DOCTYPE html>
<html>
<head>
	<title>SCADSY - School Administration System</title>
	<?php echo $scripts; ?>
	<?php echo $stylesheets; ?>
</head>

<body>
	<div id="container">
		<div id="header_container">
			<div id="header">
				<div id="logo">
					<h1>SCADSY: <?php echo Database_manager::get_db()->database; ?> </h1>
				</div>
				<div id="menu">
					<?php echo $menu; ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		
		<div id="page">
