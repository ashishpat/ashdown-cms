<?php


if (!isset($_SESSION))
	{
		session_start();
	}
require_once ('config.php');



if (!$link = mysql_connect(db_host, db_user, db_password))
	{
		echo "Failed to connect to database. Please make sure that you have configured the config.php file",mysql_error();
		die ('The page has terminated');
	}
else 
	{mysql_select_db(db_database);}



ini_set ('display_errors',1);

		error_reporting (E_ALL & ~E_NOTICE);
	
?>