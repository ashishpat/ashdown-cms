<?php 
	
		require('../session.php');
	   	require('../headerSecure.php'); 
		require('../header.php');
?>


<?php

/*Upload CSS*/

$UPLOAD_DIR = open_dir_ext."css/";

if (!empty($_FILES["uploadCSS"])) {
    $myFile = $_FILES["uploadCSS"];
	$ext = '.' .pathinfo($_FILES['uploadCSS']['name'], PATHINFO_EXTENSION);
	echo $ext;
	
	if ($ext != ".css")
		{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.error('Uploaded file is not a Stylesheet, Upload files with .css extension', 'Error');";
			echo '}); </script>';
			unset($_POST);
		}
	else
		{
		
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
        echo "<p>Unable to save file.</p>";
		echo '<p class="error">',$myFile['error'],'<p>';
        
    	}
	else
		{ echo '<p class="notice">File uploaded</p>';}
		
	echo '<p class="error">',$myFile['error'],'</p>';
	echo '<p class="notice">',$myFile["tmp_name"],'</p>';
	echo '<p class="notice">',$myFile["name"],'</p>';
    echo $UPLOAD_DIR,$name;
	// set proper permissions on the new file
    //chmod(UPLOAD_DIR . $name, 0644);
	
	//Update information on the database//
	if (isset($_POST['updateCSS']))
 		{
			$scriptname = stripslashes($name);
			$type = stripslashes('css');
			$url = '/dev/cms/css/'.$name;
			$pageid = addslashes($_POST['page_id']);
			if ($pageid == 'All')
				{$page_id = 0;}
			else
				{$page_id = addslashes($_POST['page_id']);}
			
			$query = "insert into `scripts` values(NULL,'$scriptname','$type','','$url','$page_id')";
			$result = mysql_query($query);

		if (mysql_affected_rows()!== 1)
			{
				echo '<p class="error">',"CSS - failed to add ",mysql_error(),'</p></br>';
				echo '<script> $(document).ready(function() {';
				echo "Notifier.error('Failed to add CSS', 'Error');";
				echo '}); </script>';
				unset($_POST);
			}
		else
			{
				echo '<script> $(document).ready(function() {';
				echo "Notifier.success('CSS File added.', '');";
				echo '}); </script>';
				unset($_POST);
			}
		}
		
		}
	
	

}

?>

<?php
/*Upload JavaScript*/

$UPLOAD_DIR = open_dir_ext."js/";

if (!empty($_FILES["uploadJS"])) {
    $myFile = $_FILES["uploadJS"];
	
	$ext = '.' .pathinfo($_FILES['uploadJS']['name'], PATHINFO_EXTENSION);
	echo $ext;
	
	if ($ext != ".js")
		{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.error('Uploaded file is not JavaScript, Upload files with .js extension', 'Error');";
			echo '}); </script>';
			unset($_POST);
		}
	else
		{
			
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
        echo "<p>Unable to save file.</p>";
		echo '<p class="error">',$myFile['error'],'<p>';
        
    	}
	else
		{ echo '<p class="notice">File uploaded</p>';}
		
	echo '<p class="error">',$myFile['error'],'</p>';
	echo '<p class="notice">',$myFile["tmp_name"],'</p>';
	echo '<p class="notice">',$myFile["name"],'</p>';
    echo $UPLOAD_DIR,$name;
	// set proper permissions on the new file
    //chmod(UPLOAD_DIR . $name, 0644);
	
	//Update information on the database//
	if (isset($_POST['updateJS']))
 		{
			$scriptname = stripslashes($name);
			$type = stripslashes('javascript');
			$url = '/dev/cms/js/'.$name;
			$pageid = addslashes($_POST['page_id']);
			if ($pageid == 'All')
				{$page_id = 0;}
			else
				{$page_id = addslashes($_POST['page_id']);}
			
			$query = "insert into `scripts` values(NULL,'$scriptname','$type','','$url','$page_id')";
			$result = mysql_query($query);

		if (mysql_affected_rows()!== 1)
			{
				echo '<p class="error">',"JavaScript - failed to add ",mysql_error(),'</p></br>';
				echo '<script> $(document).ready(function() {';
				echo "Notifier.error('Failed to add JavaScript file', 'Error');";
				echo '}); </script>';
				unset($_POST);
			}
		else
			{
				echo '<script> $(document).ready(function() {';
				echo "Notifier.success('JavaScript File added.', '');";
				echo '}); </script>';
				unset($_POST);
			}
		}
	}
		
}
?>

<?php

/*Delete (unlink) file from the js folder and delete corresponding database*/
	
	if (isset($_REQUEST['delete_script']))
	{	
		$ext = '.' .pathinfo($_REQUEST['delete_script']['name'], PATHINFO_EXTENSION);
		
		
		if ($ext = ".js")
		{
			$UPLOAD_DIR = open_dir_ext."js/";
		
		}
		
		if ($ext = ".css")
		{
			$UPLOAD_DIR = open_dir_ext."css/";
		}
		
		
		$delete_file_name = stripslashes($_GET['delete_script']);
		
		$query="SELECT * from `scripts` where `name`='$delete_file_name' limit 1";
		$result=mysql_query($query);
		$data = mysql_fetch_assoc($result);
		
		$delete_file = stripslashes($UPLOAD_DIR.$data['name']);
		$fh = fopen($delete_file, 'w') or die("Can't open file");
		fclose($fh);
		
		$delete_file = stripslashes($UPLOAD_DIR.$data['name']);
		$info_delete = unlink($delete_file);
		
		if ($info_delete)
			{
				$query = "delete from `scripts` where name = '$delete_file_name' limit 1";
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

?>


<!---------------FrameWorks--------------->
<div class="right-framework">
<br /><br />
<h1>Scripts and Stylesheets</h1>
<br />
<p>Upload external scripts and stylesheets <br />
<br />or <br /><br />

Create your own!<br /><br />
</p>

</div>

<div class="mainContent">

<div class="left-float">
<!-----------Upload CSS------------>
<div class="CMSforms" >
<div class="formHeader"><span>Upload Stylesheet</span></div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"> 

<br />

<img src="../assets/icons/Programming_File_Types/css/css-32.png" style="vertical-align:middle; padding-left:3%;"/>
<input type="file" name="uploadCSS">
<br>
<p>Choose Page to Apply this CSS 
<select name="pageid">
<option selected="selected">All</option>
<?php
$query="SELECT * FROM `page`";
		$result=mysql_query($query);
		$num=mysql_numrows($result);

		while ($data = mysql_fetch_assoc($result)) 
			{
				$datatableuser[] = $data;
				echo '<option value="',$data['id'],'"';
				echo '>',stripslashes($data['title']),'</option>';	
			}
?>	
</select>
</p>
<br /><br />
<br /><br />
<input type="submit" name="updateCSS" class="BUTTONsubmit" value="Upload">

</form>
</div>

<br />
<br />



<!-----------JavaScript------------>
<div class="CMSforms">
<div class="formHeader"><span>Upload JavaScripts</span></div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"> 

<br />

<img src="../assets/icons/Programming_File_Types/js/js-32.png" style="vertical-align:middle; padding-left:3%;"/>
<input type="file" name="uploadJS" />
<p>Choose Page to Apply this JavaScript 
<select name="pageid">
<option selected="selected">All</option>
<?php
$query="SELECT * FROM `page`";
		$result=mysql_query($query);
		$num=mysql_numrows($result);

		while ($data = mysql_fetch_assoc($result)) 
			{
				$datatableuser[] = $data;
				echo '<option value="',$data['id'],'"';
				echo '>',stripslashes($data['title']),'</option>';	
			}
?>	
</select>
</p>
<br /><br />
<br /><br />
<input type="submit" name="updateJS" class="BUTTONsubmit" value="Upload" />
</form>
</div> <!---CMSforms-->
</div>
<?php
	$query = "select * from `scripts`";
	$result=mysql_query($query);
		
	while ($data = mysql_fetch_assoc($result)) 
		{
			$datascripts[] = $data;
		}
?>
<div class="datatable">
<div class="formHeader" style="background:#efefef; color:#1d1d1d;"><img src="../assets/icons/Objects/note/note-32.png" width="30" height="30" style="vertical-align:middle; padding-left:2%;"/><span style="vertical-align:middle;">Uploaded Scripts</span></div>
<table width="500" border="0">
  	<tr >
    	<th scope="col">ID</th>
	    <th  scope="col">Name</th>
	    <th  scope="col">Type</th>
        <th  scope="col">URL</th>
	    <th scope="col">Page ID</th>
        <th scope="col"> </th>
  	</tr>
<?php

	foreach ($datascripts as $scripts)
		{								
			echo '<tr><td>',stripslashes($scripts['id']),'</td>';
			echo '<td>',stripslashes($scripts['name']),'</td>';
			echo '<td>',stripslashes($scripts['type']),'</td>';
			echo '<td>',stripslashes($scripts['url']),'</td>';
			echo '<td>',stripslashes($scripts['page_id']),'</td>';
			echo '<td> <a href="?delete_script=',stripslashes($scripts['name']),'">Delete</a></td>';
			echo '</tr>';			
		}
?>	
</table>
</div>











</div><!--mainContent-->

</div>

<?php 
	
		ini_set ('display_errors',1);

		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>

