<?php 
	
		require('../session.php');
$_extrajs .= <<<eof
	
	
	$('#form').ajaxForm( {
		
		success:function InsertHTML(uploaded_url)
			{
			var editor = CKEDITOR.instances.editor1;
			Notifier.success('File Uploaded', 'Error');
			var value = uploaded_url;
			editor.insertHtml(value);
			}
    }); 

eof;

		require('../headerSecure.php'); 
		require('../header.php'); 	
?>


<?php
require('functions.php')
?>

<?php	
/*------------------------------Update Page----------------------------*/
if (isset($_POST['updatepage']))
 {
	 $id = $_POST['ID'];
	 $title = addslashes($_POST['Title']);
     $content = htmlspecialchars(stripslashes($_POST['editor1']));
	 $css = htmlspecialchars(stripslashes($_POST['cssInput']));
	 $editedby =stripslashes($_SESSION['usr']['username']);
	 $ip = addslashes($_SERVER['REMOTE_ADDR']);


$query = "update `page` set `title` = '$title',`content` = '$content',`css` = '$css',`editedby` = '$editedby',`ipaddress` = '$ip' where id = '$id' limit 1";
$result = mysql_query($query);

if (mysql_affected_rows()!== 1)
	{
		echo '<p class="error">',"Error - Failed to Update Page",mysql_error(),'</p></br>';
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Failed to Update Page', 'Error');";
		echo '}); </script>';
		unset($_POST);
	}
else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.success('Page Successfully Updated.', '');";
		echo '}); </script>';
		unset($_POST);
	}
 }

?>


<?php
/*------------------------------Delete Page----------------------------*/
if (isset($_POST['deleteSelection']))
{
	 $pageid = $_POST['pageid'];
	 $query = "delete from `page` where id = '$pageid' limit 1";
			$result = mysql_query($query);

			if (mysql_affected_rows()!== 1)
				{
					echo '<p class="error"> Failed to delete',mysql_error(),'</p>';
					echo '<script> $(document).ready(function() {';
					echo "Notifier.error('Failed to Remove User', 'Error');";
					echo '}); </script>';
					unset ($_POST);
				}
			else
				{
					echo '<script> $(document).ready(function() {';
					echo "Notifier.warning('Page Deleted', '');";
					echo '}); </script>';
					unset ($_POST);
				}
		
}
?>



<div class="right-framework">
<br /><br />

<h1>Edit Page</h1>
<br />
<br />
<div class="right-framework-light">
	<p>Select a page to Edit</p>
    <p><form name="updateSelection" id="updateSelection" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<br />
    <select name="pageid" class="selectButton">
    <!----------------Lists the Users on Dropdown----------->
    <!----------------_POST:updateSelectionSubmit-------->
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
    <br /><br />
    <input type="submit" name="updateSelectionSubmit" class="BUTTONsubmitb" value="Select" accesskey="s" />
    <input type="submit" name="deleteSelection" class="BUTTONsubmitbDelete" value="Delete Page" accesskey="d" />
	</form></p>
</div>
    <br />
<br />
<br />
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
	if (isset($_POST['updateSelectionSubmit']))
		{
		$pageid = stripslashes($_POST['pageid']);
		echo $title;
		$query = "select * from `page` where id='$pageid' limit 1";
		$result = mysql_query($query);	
		
		$data = mysql_fetch_assoc($result);
		
		
		}
	unset($_POST['updateSelectionSubmit'] );
	?>
<br />
<br />
<input class="invisible" type="text" name="ID" value="<? echo $data['id'];?>" required="required"/>
<p>Page Title</p><br />
<input type="text" name="Title"  tabindex="10" class="inputdesign_SIDEBAR" placeholder="Your page title" required="required" value="<? echo stripslashes($data['title']);?>"/>
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<input name="updatepage" type="submit" class="BUTTONsubmitb" value="Update Page">

</div>

<div class="mainContent">
<script> $(document).ready(function() { $('.toggleeaddmedia').click(function(){ $('div#showhideadd').toggle(); }); }); </script>


		<textarea id="editor1" name="editor1"><? echo  htmlspecialchars_decode($data['content']);?></textarea>
		<br /><br />

        <div style="height:30%; width:50%; padding-bottom:5%;  background:#696969; float:left;">
        <div class="formHeader" style="background:#efefef; color:#1d1d1d;"><img src="../assets/icons/Programming_File_Types/css/css-32.png" width="30" height="30" style="vertical-align:middle; padding-left:2%;"/><span style="vertical-align:middle;">Custom Page Stylesheet</span></div>
        
         <textarea name="cssInput" id="code" placeholder="Enter custom CSS here">
       	 <? echo  htmlspecialchars_decode($data['css']);?>
         </textarea>
        </p>
        </div>
        
       
		
		</p>
	</form>

<script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {});
</script>


<!---------Upload Media------------->

<div class="CMSforms" style="width:30%; margin-left:60%;" >
<div class="formHeader" id="button" style="background:#efefef; color:#1d1d1d;"><span>Insert from Library</span></div>
<div class="formHeader"><span>Upload Media</span></div>

<form name="" id="form" action="upload_media.php"  method="post" enctype="multipart/form-data"> 
<br /><br />

<input type="file" name="uploadMedia" style="padding-left:2%;">
<div id="preview"></div>
<br>
<?php echo $uploaded_url;?>
<p style="text-align:left;">Once you upload the file,<br />the file will be added to your editor.</p>
<br /><br />

<img src="../assets/icons/Very_Basic/image_file/image_file-32.png" title="Image File" style="vertical-align:middle; padding-left:3%;"/>
<img src="../assets/icons/File_Types/pdf/pdf-32.png" title="PDF File" style="vertical-align:middle; padding-left:1%;"/>

<input type="submit" class="BUTTONsubmit" value="Upload">
<br /><br />

</form>
</div>






<div style="clear:both;"></div>


<!------------POPUP Browser------------->
<div id="popupContact">
		

<div class="formHeader togglegeneral" ><span style="vertical-align:middle;">General Settings</span><img src="<?php echo rootPath;?>assets/icons/System/delete/delete-32.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;" id="popupContactClose"/></div>

<div class="browser_add">
<br />
<br />

<?php
	if ($search_name)
		{
			echo '<h3 style="color:#1d1d1d">Search term: ',$search_name,'</h3>';
			echo '</br>';
		}
	if ($num > 0)
	{
	foreach ($datamedia as $media)
		{

		$UPLOAD_DIR = open_dir_ext."media/";
		$fileType = exif_imagetype($UPLOAD_DIR.$media['filename']);				//Uploade derectory value allowed from Upload PHP
		$allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
		
		if (in_array($fileType, $allowed)) 
				{
					
					echo '<div class="browser_display_object" id="insert_image',$media['id'],'">';
					echo '<img src="',$media['url'],'"/>';
					echo '</br>';
					echo '<p>',$media['filename'],'</p>';
					echo '</div>';
					
					
				
					echo '<script>';
					echo 'var insert_url',$media['id'],' = "<img src=\"',$media['url'],'\"/>";';
					echo '$("#insert_image',$media['id'],'").click(function(){';
					echo 'var editor = CKEDITOR.instances.editor1;';
					echo 'var value = insert_url',$media['id'],';';
					echo 'editor.insertHtml(value);';
					echo '}); </script>';
				}
		else
				{
					
					echo '<div class="browser_display_object" id="insert_image',$media['id'],'">';
					echo '<img src="',rootPath,'assets/icons/Very_Basic/file/file-512.png" style="width:60%; margin-top:20%; verticle-align:middle;"/>';
					echo '</br>';
					echo '<p>',$media['filename'],'</p>';
					echo '</div>';
					
					
					$proper_url = '<p><a href="'.$media['url'].'"/></p>';
					
					echo '<script>';
					echo 'var insert_url',$media['id'],' = "<a href=\"',$media['url'],'\">',$media['filename'],'</a>";';
					echo '$("#insert_image',$media['id'],'").click(function(){';
					echo 'var editor = CKEDITOR.instances.editor1;';
					echo 'var value = insert_url',$media['id'],';';
					echo 'editor.insertHtml(value);';
					echo '}); </script>';
					
				}
		}
	}
	else
	{
		echo '<h1>No matches found</h1>';
	}
?>
</div>
</div><!--brosweradd-->
	</div>
	<div id="backgroundPopup"></div>




</div><!--mainContent-->

<?php 
	
		ini_set ('display_errors',1);

		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>