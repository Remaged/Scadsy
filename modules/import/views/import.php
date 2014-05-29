<h1>Import</h1>

<?php echo form_open_multipart('import/importer/import',array('class'=>'sc-form','id'=>'import_from')); ?>

<div>
		<label>File</label>
		<input type="file" name="import_csv" size="20" />

<?php echo form_submit('import','Import'); ?>
	
<?php echo form_close(); ?>