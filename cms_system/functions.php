<?php


/**************************************************************************************************************************************************/
/*FUNCTIONS FOR MEDIA.PHP*/
/*Programed by: Ashish Pathak*/
/*
Includes:
Filter Check
Delete (unlink) Files
Upload and Write Database
Display query
/****************Filter Check****************/
$filter_items = array('search_name','media_type','category','order_file');
if (isset($_REQUEST['clear_filter']))
	{
		unset($_SESSION['filter_items']);	
		foreach ($filter_items as $value)
		{
		unset($_REQUEST[$value]);
		unset($_GET[$value]);
		}
		unset($_REQUEST['media_view_submit']);
		unset($_GET['media_view_submit']);
	}

if (isset($_REQUEST['media_view_submit']))
{
	foreach ($filter_items as $value)
	{
		$_SESSION['filter_items'][$value] = $_REQUEST[$value];
	}
}
else
{
	if (is_array($_SESSION['filter_items']))
	{
		foreach ($filter_items as $value)
		{
		$_REQUEST[$value] = $_SESSION['filter_items'][$value];
		$_GET[$value] = $_SESSION['filter_items'][$value];
		}
		$_REQUEST['media_view_submit'] = "Filter";
		$_GET['media_view_submit'] = "Filter";
	}
	
}

	/*Delete (unlink) file from the media folder and delete corresponding database*/

	$UPLOAD_DIR = open_dir_ext."media/";
	if (isset($_REQUEST['delete_item']))
	{	
		$delete_file_id = stripslashes($_GET['delete_item']);
		
		$query="SELECT * from `media` where `id`='$delete_file_id' limit 1";
		$result=mysql_query($query);
		$data = mysql_fetch_assoc($result);
		
		$delete_file = stripslashes($data['filename']);
		$fh = fopen($delete_file, 'w') or die("Can't open file");
		fclose($fh);
		
		$delete_file = stripslashes($UPLOAD_DIR.$data['filename']);
		$info_delete = unlink($delete_file);
	
		if ($info_delete)
			{
				$query = "delete from `media` where id = '$delete_file_id' limit 1";
				$result = mysql_query($query);

			if (mysql_affected_rows()!== 1)
				{
					echo '<p class="error"> Failed to delete',mysql_error(),'</p>';
					echo '<script> $(document).ready(function() {';
					echo "Notifier.error('Failed to Delete File', 'Error');";
					echo '}); </script>';
				}
			else
				{
					echo '<script> $(document).ready(function() {';
					echo "Notifier.warning('File name ",$data['filename']," deleted', 'Success');";
					echo '}); </script>';
				}
				
			}
	}

/*upload media file and write database*/
if($_POST['upload_media'])
{

$UPLOAD_DIR = open_dir_ext."media/";

if (!empty($_FILES["uploadMedia"])) {
    $myFile = $_FILES["uploadMedia"];
	$category = $_POST['upload_category'];
		
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo '<p class="error">An error occurred. Could not upload the file</p>';
      	print_r ($myFile);
    }

    // ensure a safe filename
    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($name);
    while (file_exists($UPLOAD_DIR.$name)) {
        $i++;
        $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }

    // preserve file from temporary directory
   	$success = move_uploaded_file($myFile["tmp_name"], $UPLOAD_DIR . $name);
	 if ( file_exists($myFile["name"]))
		{
				echo '<p class="notice">',$myFile["tmp_name"],' exists <p>';
		}
    if (!$success) { 
              	
				echo '<p class="error">',"Unable to Upload the file - ",$myFile['error'],'</p></br>';
				echo '<script> $(document).ready(function() {';
				echo "Notifier.error('Unable to Upload the File', 'Error');";
				echo '}); </script>';
				unset($_POST);
				
    	}
	else
		{ 
				
				
				// verify the file is a GIF, JPEG, or PNG
				$fileType = exif_imagetype($UPLOAD_DIR.$name);
				$allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
	
				if (in_array($fileType, $allowed)) 
				{
					
					/*Database*/
					$filename = stripslashes($name);
					$url = stripslashes(rootPath.'media/'.$name);
					$ext = strtoupper(pathinfo($myFile['name'], PATHINFO_EXTENSION));
					$filesize = filesize($UPLOAD_DIR.$name);
					$category = stripslashes($category);
					$ipaddress = addslashes($_SERVER['REMOTE_ADDR']);
					
					
					$query = "insert into `media` values(NULL,'$filename','$url','$filesize','$ext','$category',now(),'$ipaddress')";
					$result = mysql_query($query);
					
					if (mysql_affected_rows()!== 1)
						{
							echo '<p class="error">',"Error - Failed to add new user",mysql_error(),'</p></br>';
							echo '<script> $(document).ready(function() {';
							echo "Notifier.error('Failed to Add New User', 'Error');";
							echo '}); </script>';
							unset($_POST);
						}
					else
						{
							echo '<script> $(document).ready(function() {';
							echo "Notifier.success('File uploaded', 'Success');";
							echo '}); </script>';
							unset($_POST);							
						}
					/*Database end*/	
					unset($_POST);
				}
				else
				{
					/*Database*/
					$filename = stripslashes($name);
					$url = stripslashes(rootPath.'media/'.$name);
					$ext = strtoupper(pathinfo($myFile['name'], PATHINFO_EXTENSION));
					$filesize = filesize($UPLOAD_DIR.$name);
					$category = stripslashes($category);
					$ipaddress = addslashes($_SERVER['REMOTE_ADDR']);
					
					$query = "insert into `media` values(NULL,'$filename','$url','$filesize','$ext','$category',now(),'$ipaddress')";
					$result = mysql_query($query);
					
					if (mysql_affected_rows()!== 1)
						{
							echo '<p class="error">',"Error - Failed to add new user",mysql_error(),'</p></br>';
							echo '<script> $(document).ready(function() {';
							echo "Notifier.error('Failed to Add New User', 'Error');";
							echo '}); </script>';
							unset($_POST);
						}
					else
						{
							
							echo '<script> $(document).ready(function() {';
							echo "Notifier.success('File uploaded', 'Success');";
							echo '}); </script>';
							unset($_POST);							
						}
					/*Database end*/	
					unset($_POST);
				}
		}

	// set proper permissions on the new file
    //chmod(UPLOAD_DIR . $name, 0644);
	
}
}

	/*Query Display all Images when filter is applied*/
	if (isset($_REQUEST['media_view_submit']))
	{
		$search_name = stripslashes($_GET['search_name']);
		$media_type =  stripslashes($_GET['media_type']);
		if ($media_type == "all")
			{$media_type = "%%";}
		$category = stripslashes($_GET['category']);
		if ($category == "all")
			{$category = "%%";}
		
		$order_by =  $_GET['order_file'];
				
			$query="SELECT * FROM `media` where `filename` LIKE '%$search_name%' AND `filetype` LIKE '$media_type' AND `category` LIKE '$category' ORDER BY $order_by";
			$result=mysql_query($query);
			$num = mysql_numrows($result);
			while ($data = mysql_fetch_assoc($result)) 
			{
				$datamedia[] = $data;
			}
		
			
	}
	else /*Query when the page loads*/
	{
		$query="SELECT * FROM `media`";
		$result=mysql_query($query);
		$num = mysql_numrows($result);
		while ($datatype = mysql_fetch_assoc($result)) 
		{
			$datamedia[] = $datatype;
		}
			
	}

/**************************************************************************************************************************************************/
?>	