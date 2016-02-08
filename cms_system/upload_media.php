<?php
		require('../session.php');
		require('../headerSecure.php'); 
		
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$UPLOAD_DIR = open_dir_ext."media/";
if (!empty($_FILES["uploadMedia"])) {
    $myFile = $_FILES["uploadMedia"];
	
		
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
					$uploaded_url = stripslashes('<img src="'.rootPath.'media/'.$name.'"/>');
					echo $uploaded_url;
					/*Database*/
					$filename = stripslashes($name);
					$url = stripslashes(rootPath.'media/'.$name);
					$ext = strtoupper(pathinfo($myFile['name'], PATHINFO_EXTENSION));
					$filesize = filesize($UPLOAD_DIR.$name);
					$category = stripslashes('pageupload');
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
					/*Database end*/	
					unset($_POST);
				}
				else
				{
					$uploaded_url = stripslashes('<a href="'.rootPath.'media/'.$name.'">'.$name.'</a>');
					echo $uploaded_url;
					/*Database*/
					$filename = stripslashes($name);
					$url = stripslashes(rootPath.'media/'.$name);
					$ext = strtoupper(pathinfo($myFile['name'], PATHINFO_EXTENSION));
					$filesize = filesize($UPLOAD_DIR.$name);
					$category = stripslashes('PageUpload');
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
					/*Database end*/	
					unset($_POST);
				}
		}

	// set proper permissions on the new file
    //chmod(UPLOAD_DIR . $name, 0644);
	
}
}
?>