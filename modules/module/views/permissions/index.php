<h1>Manage permissions</h1>

<div id="accordion">
	<?php foreach($modules as $module): ?>
		<h2>
			<?php echo $module->name; ?> (<?php echo $module->directory;?>)
		</h2>
		<div>	
			<div class="sub_accordion">		
				<?php foreach($module->action as $action): ?>					
					<h3>
						<?php echo $action->controller.'/'.$action->name; ?>
					</h3>
					<div>
						<table class="sc-table">	
							<?php 
								$group = $action->group;
								include('permissions_group_options.php'); 
							?>
						</table>
					</div>					
				<?php endforeach; ?>
			</div>
		</div>	
	<?php endforeach; ?>
</div>