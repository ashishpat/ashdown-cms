<?php 
	
		require('../session.php');
$_extrajs .= <<<eof

	 }); 

   
eof;

	   	require('../headerSecure.php'); 
		require('../header.php');
?>

<!--
This page is used to edit all the CSS files that user uploads
- List Directory
- GET Files to Edit
- Open Files using GET
- Read Files
- Edit Files
- Save Files
- Close Files
-->
<?php
/*List Directory "/wwwroot/CSS/"  */


$dir = open_dir_ext."css/";
 	//define directory

function listFolderFiles($dir){
    $ffs = scandir($dir);
    echo '<ul>';
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
			if (strpos($ff,".css"))
            	{
					echo '<a href="?filename='.$ff.'"><li>'.$ff;				//GET filename for Open Files
            		if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
            		echo '</li></a>';
				}
		}
    }
    echo '</ul>';
}
?>

<?php
/*Save and Update File*/
if (isset($_POST['updateFile']))
{
$filename = $_POST["filename"];
$filedata = stripslashes($_POST['cssInput']);

$fh = fopen($filename, 'w') or die("can't open file");
fwrite($fh, $filedata);
fclose($fh);
unset($_POST);
}
?>


<?php
/*
GET Files to Edit
Open Files to using GET
*/
if (isset($_REQUEST['filename']))
{
$fileName = $_REQUEST['filename'];
$fh = fopen($fileName, 'r+');

$fileData = fread($fh, filesize($fileName));
fclose($fh);
unset($_REQUEST);
}
?>
<!---------------FrameWorks--------------->
<div class="right-framework">
<br /><br />
<h1>Editor</h1>
<br />
<p>Click on a file to Edit </p>

<div class="directoryList" >
<?php
listFolderFiles($dir);
?>
</div>

</div>


<div class="mainContent">

<?php

	$ext = pathinfo($fileName,PATHINFO_EXTENSION);
	echo $ext;

?>


<h2 align="left">Editor  <?php echo $fileName; ?></h2>
<div style="height:75%;">
<form name="updateFile" style="position:relative;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
<input name="filename" class="invisible" value="<?php echo $fileName;?>"/>
<textarea name="cssInput" id="code" > <? echo $fileData;?></textarea>
<br /><br /><br /><br />

<input type="submit" name="updateFile"  value="Update" class="BUTTONsubmit" accesskey="s" tabindex="15" style="right:150px;"/>&nbsp;
</form>
</div>
<script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {});
</script>



</div><!--mainContent-->


</div>

<?php 
	
		ini_set ('display_errors',1);

		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>
