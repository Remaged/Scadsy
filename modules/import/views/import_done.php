<h1>Import finished</h1>

<p>The import was finished.</p>

<?php if(count($records) > 0) { ?>
<p>The system failed to import the following students:</p>
	
<table class="sc-table">
	<thead>
		<tr>
			<th>First name</th>
			<th>Last name</th>
			<th>Error</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>First name</th>
			<th>Last name</th>
			<th>Error</th>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach($records as $record) { ?>
			<tr>
				<td><?php echo $record['student']->first_name; ?></td>
				<td><?php echo $record['student']->last_name; ?></td>
				<td><?php echo $record['error']; ?></td>
			</tr>	
		<?php } ?>
	</tbody>
</table>
<?php } ?>
