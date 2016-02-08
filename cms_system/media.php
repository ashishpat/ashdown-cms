<?php 
	
require('../session.php');

/*****************Extra Javascripts****************/	
$_extrajs .= <<<eof


});	

eof;
/****************End Javascripts*******************/

require('../headerSecure.php'); 
require('../header.php'); 	
?>

<?php
require('functions.php')
?>

        
<div class="right-framework">
<br /><br />

<h1>File Properties</h1>
<br />
<p>Select a File to view details</p>
<br />
<br />

<? if (isset($_REQUEST['imageid']))
{
		$id = $_REQUEST['imageid'];
		$query="SELECT * from `media` where `id`='$id' limit 1";
		$result=mysql_query($query);
		$data = mysql_fetch_assoc($result);
		
		
	
	echo '<p> File name </p><br />		';	
	echo '<form  action="',$_SERVER['PHP_SELF'],'" method="post"  style=" position:relative;">';
	echo '<input type="text" name="Title" class="inputdesign_SIDEBAR" placeholder="Your page title"  tabindex="10" disabled="disabled" required="required" value="',$data['filename'],'" />';
	echo '<br /><br /><p>URL</p><br />';
	echo '<input type="text" name="Title" class="inputdesign_SIDEBAR" placeholder="Your page title"  tabindex="10" disabled="disabled" required="required" value="',$data['url'],'" />';
	echo '<br /><br /><p class="right-framework-data"> File Type: ',strtoupper($data['filetype']),'</p>';
	echo '<br /><p class="right-framework-data">File size: ',round(($data['filesize']/1024),0),' KB</p>';
	list($width, $height) = getimagesize(open_dir_ext.'media/'.$data['filename']);
	echo '<br /><p class="right-framework-data"> Image Size: ',$width,' &Chi; ',$height,'</p>';
	echo '<br /><br />';
	echo '<p><a class="delete_link" href="?delete_item=',$data['id'],' ">Delete File</a> | <a href="',$_SERVER['PHP_SELF'],'"> Cancel</a></p>';
	echo '</form>';
}
?>

</div>


<div class="mainContent">


<script> $(document).ready(function() { $('.toggleedit').click(function(){ $('div#showhideadd').toggle(); }); }); </script>




<!-------Form display--------->
<form name="media_view" class="media_view" action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">

<!--
Data Check
<? echo '<p>',print_r($data).$num,'</p>'; ?>
<? echo '<p>',$order_by,'</p>'; ?>
-->

<div class="formHeader"><span>Media Browser</span></div>
<div class="form_box">
<input type="text" name="search_name"  placeholder="Search Filename" value="<?php echo stripslashes($_REQUEST['search_name']); ?>"/>

<p>Select Media Type</p>
<select name="media_type" class="select_button_color">
<option value="all">All</option>

<?php /*Display unique media types*/
		$query="SELECT DISTINCT `filetype` FROM `media` ORDER BY `filetype` ASC ";
		$result=mysql_query($query);
			
		while ($data = mysql_fetch_assoc($result)) 
			{
				echo '<option value="',$data['filetype'],'"';
				if (stripslashes($_REQUEST['media_type'])==$data['filetype'])
				{ echo ' selected="selected" '; }
				echo '>',$data['filetype'],'</option>';	
			}
?>	


</select>

<p>Select Category</p>
<select name="category" class="select_button_color">
<option value="all">All</option>

<?php /*Display unique category types*/
		$query="SELECT DISTINCT `category` FROM `media` ORDER BY `category` ASC ";
		$result=mysql_query($query);
			
		while ($data = mysql_fetch_assoc($result)) 
			{
				echo '<option value="',$data['category'],'"';
				if (stripslashes($_REQUEST['category'])==$data['category'])
				{ echo ' selected="selected" '; }
				echo '>',$data['category'],'</option>';	
			}
?>	
</select>



<p>Order by:</p>
<select name="order_file" class="select_button_color">
<option value="`filename` ASC">Ascending</option>
<option value="`filename` DESC">Decending</option>
<option value="date">date/time</option>
<option value="filesize">File Size</option>
</select>

<input type="submit" name="media_view_submit" class="BUTTONsubmitb" id="filter" value="Filter" accesskey="f"/>
<?php if (is_array($_SESSION['filter_items']))
	{
		echo '<input type="submit" name="clear_filter" class="BUTTONsubmitb" id="filter" value="Reset filter" accesskey="c"/>';
	}
?>


 <!--form-box-->
</form>

</div>

<div class="browser_display">

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
					echo '<a href="?imageid=',$media['id'],'">';
					echo '<div class="browser_display_object">';
					echo '<img src="',$media['url'],'"/>';
					echo '</br>';
					echo '<p>',$media['filename'],'</p>';
					echo '</div>';
					echo '</a>';
				}
		else
				{
					echo '<a href="?imageid=',$media['id'],'">';
					echo '<div class="browser_display_object">';
					echo '<img src="',rootPath,'assets/icons/Very_Basic/file/file-512.png" style="width:60%; margin-top:20%; verticle-align:middle;"/>';
					echo '</br>';
					echo '<p>',$media['filename'],'</p>';
					echo '</div>';
					echo '</a>';
				}
		}
	}
	else
	{
		echo '<h1>No matches found</h1>';
	}
?>


<div class="CMSforms" style="width:20%; position:absolute; bottom:1%; right:2%; z-index:9999;" >
<div id="showhideadd" style="display:none;" >
<form name="upload_media" id="form1" action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post" enctype="multipart/form-data"> 
<br /><br />

<input type="file" name="uploadMedia" style="padding-left:2%;">
<div id="preview"></div>
<br>
<?php echo $uploaded_url;?>
<br />

<label style="vertical-align:middle; margin-left:3%;">Select Category: </label>
<select name="upload_category" style="vertical-align:middle;">
<?php
$query="SELECT * FROM `settings` WHERE `option` = 'setting_category'";
		$result=mysql_query($query);
			
		while ($data = mysql_fetch_assoc($result)) 
			{
				echo '<option value="',$data['value'],'"';
				echo '>',$data['attribute'],'</option>';	
			}
?>
</select>
<br />

<br /><br />
<img src="../assets/icons/Very_Basic/image_file/image_file-32.png" title="Image File" style="vertical-align:middle; margin-left:3%;"/>
<img src="../assets/icons/File_Types/pdf/pdf-32.png" title="PDF File" style="vertical-align:middle; margin-left:1%;"/>


<input type="submit" name="upload_media" class="BUTTONsubmitb" style="right:5%; position:absolute;" value="Upload">
<br /><br />

</form>
</div>

<div class="formHeader toggleedit" ><img src="../assets/gfx/sub-icon_black.png" width="20" height="20" style="vertical-align:middle; margin-left:5%;"/><span style="vertical-align:middle;">Upload File</span></div>
</div>
</div> <!--browser_display-->
 

<!---------Upload Media------------->


<!----------------Upload Media----------------------->


<div style="clear:both;"></div>



</div> <!----MainContent--->

<?php 
		/********Footer*******/
		ini_set ('display_errors',1);
		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>
