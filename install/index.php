<?php

$database_file = "../application/config/database.php";
$database_file = "../application/config/config.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
	// Load the database connection
	$dbh = new PDO($_POST['db_driver'].':host='.$_POST['db_host'].';dbname='.$_POST['db_name'], $_POST['db_user'], $_POST['db_pass']);
	
	$dbh->query(file_get_contents('script.sql'));
	
	$dbh = NULL;
	
	// Save the inserted settings
	$file_content = file_get_contents($database_file);
	$file_content = str_replace("{db_name}", $_POST['db_name'], $file_content);
	$file_content = str_replace("{db_driver}", $_POST['db_driver'], $file_content);
	$file_content = str_replace("{db_host}", $_POST['db_host'], $file_content);
	$file_content = str_replace("{db_user}", $_POST['db_user'], $file_content);
	$file_content = str_replace("{db_pass}", $_POST['db_pass'], $file_content);
	file_put_contents($database_file, $file_content);

	echo file_get_contents('succes.html');
	
	} catch (PDOException $e) {
		echo "An error occured: " . $e->getMessage();
		die();
	}
} else {
	echo file_get_contents('form.html');
}


