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

/***********************Setting Functions****************************/
/*General Settings*/
if (isset($_POST['general_settings']))
{
	$setting_sitetitle 	= addslashes($_POST['setting_sitetitle']);
	$setting_siteurl 	= addslashes($_POST['setting_siteurl']);
	$setting_email	 	= addslashes($_POST['setting_email']);
	$setting_homepage 	= $_POST['setting_homepage'];
	
	$querya = "update `settings` set `value` = '$setting_sitetitle' where `option` = 'setting_sitetitle'";
	$queryb = "update `settings` set `value` = '$setting_siteurl' where `option` = 'setting_siteurl'";
	$queryc = "update `settings` set `value` = '$setting_email' where `option` = 'setting_email'";
	$queryd = "update `settings` set `value` = '$setting_homepage' where `option` = 'setting_defaultpage'";
	
	$resulta = mysql_query($querya);
	$resultb = mysql_query($queryb);
	$resultc = mysql_query($queryc);
	$resultd = mysql_query($queryd);
	
	
	
	if (mysql_affected_rows() != 1)
		{
			echo '<p class="error">',"Error - Failed to update General Settings",mysql_error(),'</p></br>';
			echo '<script> $(document).ready(function() {';
			echo "Notifier.error('Setting update Failed', 'Error');";
			echo '}); </script>';
			unset($_POST);
		}
	else
		{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.success('Setting successfully updated.', '');";
			echo '}); </script>';
			unset($_POST);
		}

	
		
}
/*END General Settings*/


/*Meta Content*/
if (isset($_POST['meta_content']))
{
	$setting_metacontent	= addslashes($_POST['setting_metacontent']);
	$setting_metakeywords 	= addslashes($_POST['setting_metakeywords']);
	$setting_titleformat 	= addslashes($_POST['setting_titleformat']);
	
	$querya = "update `settings` set `value` = '$setting_metacontent' where `option` = 'setting_metacontent'";
	$queryb = "update `settings` set `value` = '$setting_metakeywords' where `option` = 'setting_metakeywords'";
	$queryc = "update `settings` set `value` = '$setting_titleformat' where `option` = 'setting_titleformat'";
	$resulta = mysql_query($querya);
	$resultb = mysql_query($queryb);
	$resultc = mysql_query($queryc);
	
	
	
	if (mysql_affected_rows() != 1)
		{
			echo '<p class="error">',"Error - Failed to update Meta Content",mysql_error(),'</p></br>';
			echo '<script> $(document).ready(function() {';
			echo "Notifier.error('Setting update Failed', 'Error');";
			echo '}); </script>';
			unset($_POST);
		}
	else
		{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.success('Setting successfully updated.', '');";
			echo '}); </script>';
			unset($_POST);
		}

	
		
}
/*END Meta Content*/

/*Categories*/
/*Remove_Categories*/
if (isset($_POST['remove_categories']))
{
	$setting_remove_categories	= addslashes($_POST['setting_remove_categories']);
	
	$query = "delete from `settings` where id = '$setting_remove_categories' limit 1";
	$result = mysql_query($query);
		
	if (mysql_affected_rows() != 1)
		{
			echo '<p class="error">',"Error - Failed to remove category",mysql_error(),'</p></br>';
			echo '<script> $(document).ready(function() {';
			echo "Notifier.error('Setting update Failed', 'Error');";
			echo '}); </script>';
			unset($_POST);
		}
	else
		{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.success('Setting successfully updated.', '');";
			echo '}); </script>';
			unset($_POST);
		}

}
/*END remove_categores*/


/*add_categories*/
if (isset($_POST['add_categories']))
{
	$setting_option = "setting_category";
	$setting_add_category	= addslashes($_POST['setting_add_category']);
	$setting_add_category_value = strtolower(str_replace(' ', '', $setting_add_category));
	$ip = addslashes($_SERVER['REMOTE_ADDR']);
	
	$query = "insert into `settings` values(NULL,'$setting_option','$setting_add_category_value','$setting_add_category','$ip',now())";
	$result = mysql_query($query);
		
	if (mysql_affected_rows() != 1)
		{
			echo '<p class="error">',"Error - Failed to add new category",mysql_error(),'</p></br>';
			echo '<script> $(document).ready(function() {';
			echo "Notifier.error('Setting update Failed', 'Error');";
			echo '}); </script>';
			unset($_POST);
		}
	else
		{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.success('Setting successfully updated.', '');";
			echo '}); </script>';
			unset($_POST);
		}

}
/*END add_categories
/*END Categories*/

/*Site Operations*/
if (isset($_POST['submit_maintainencemode']))
	
	{
		$mode_value = strtolower(addslashes($_POST['setting_maintainence_mode']));
		
		$query = "update `settings` set `value` = '$mode_value' where `option` = 'setting_maintainence_mode'";
		$result = mysql_query($query);
	
	
	
			if (mysql_affected_rows() != 1)
				{
					echo '<p class="error">',"Error - Failed to add new user",mysql_error(),'</p></br>';
					echo '<script> $(document).ready(function() {';
					echo "Notifier.error('Setting update Failed', 'Error');";
					echo '}); </script>';
					unset($_POST);
				}
			else
				{
					echo '<script> $(document).ready(function() {';
					echo "Notifier.success('Setting successfully updated.', '');";
					echo '}); </script>';
					unset($_POST);
				}
	}
	
if (isset($_POST['submit_siteoperations']))
	{
			
		
		$allowed_ip = addslashes($_POST['setting_allowed_ip']);
		
		$query = "update `settings` set `value` = '$allowed_ip' where `option` = 'setting_allowed_ip'";
		$result = mysql_query($query);
	
	
	
			if (mysql_affected_rows() != 1)
				{
					echo '<p class="error">',"Error - Failed to update allowed Maintainence Mode IP Address",mysql_error(),'</p></br>';
					echo '<script> $(document).ready(function() {';
					echo "Notifier.error('Setting update Failed', 'Error');";
					echo '}); </script>';
					unset($_POST);
				}
			else
				{
					echo '<script> $(document).ready(function() {';
					echo "Notifier.success('Setting successfully updated.', '');";
					echo '}); </script>';
					unset($_POST);
				}
		
		
	}
	
	
/*Query to Update Form Information*/


				$query 	= "SELECT * FROM `settings`";
				$result = mysql_query($query);
			
				while ($datasettings_query = mysql_fetch_assoc($result)) 
					{
						$datasettings[] = $datasettings_query;	
						
					}

?>

<div class="right-framework">


</div>

<script> $(document).ready(function() { $('.togglegeneral').click(function(){ $('div#showhidegeneral').toggle(); }); }); </script>
<script> $(document).ready(function() { $('.togglemetacontent').click(function(){ $('div#showhidemetacontent').toggle(); }); }); </script>
<script> $(document).ready(function() { $('.togglecategories').click(function(){ $('div#showhidecategories').toggle(); }); }); </script>
<script> $(document).ready(function() { $('.toggleoperations').click(function(){ $('div#showhideoperations').toggle(); }); }); </script>

<div class="mainContent">

<div style="width:50%; margin-left:auto; margin-right:auto;">
<div class="CMSforms" >
	
	<div class="formHeader togglegeneral" ><img src="<?php echo rootPath;?>assets/icons/System/settings/settings-128.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;"/><span style="vertical-align:middle;">General Settings</span></div>
    
    <div id="showhidegeneral" style="display:none;">
   
    <br />
   
<form name="general_setttings" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-left:15%;">
   	   
         <label>Site Title</label><br />
         <input value="<?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_sitetitle")
					 {
						echo stripslashes($formvalue['value']);
						
					 }
				}
		  ?>
         " name="setting_sitetitle" class="inputdesignb"/>
         <br /><br />
         <label>Site URL</label><br />
         <input value="<?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_siteurl")
					 {
						echo stripslashes($formvalue['value']);
						
					 }
				}
		  ?>
         " name="setting_siteurl" class="inputdesignb"/>
         <br /><br />
         <label>E-mail Addresss</label><br />
         <input value="<?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_email")
					 {
						echo stripslashes($formvalue['value']);
						
					 }
				}
		  ?>
        	" name="setting_email" class="inputdesignb"/>
            

		<br /><br />
        <label>Set Homepage</label><br />
         <select value="" name="setting_homepage" class="inputdesignb">
		<?php
		
		foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_defaultpage")
					 {
						$default_page_value = str_replace(' ','',$formvalue['value']);
						
					 }
				}
				
		$query="SELECT * FROM `page`";
		$result=mysql_query($query);
		$num=mysql_numrows($result);

		while ($data = mysql_fetch_assoc($result)) 
			{
				echo '<option value="',$data['id'],'"';
				if ($data['id'] ==  $default_page_value)
				echo 'selected="selected"';
				echo '>',stripslashes($data['title']),'</option>';	
			}
		?>	
         </select>
        
        <br /><br />
		<br /><br />

		<input type="submit" name="general_settings" id="UpdateUser" value="Update" class="BUTTONsubmitb" accesskey="s" tabindex="15" style="right:30%;"/>
		<input type="reset" name="Clear" id="Clear" value="Clear" class="BUTTONsubmitb" accesskey="c" tabindex="16" />    

		<br /><br />

</form>

</div><!--ShowhideEdit-->
</div><!--CMSforms-->

<!--New Form-->
<div class="CMSforms" >
<!---------Form meta_content--------------->
<!---------_POST:meta_content-------->

<div class="formHeader togglemetacontent"><img src="../assets/icons/Very_Basic/info/info-32.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;"/><span style="vertical-align:middle;">Meta Content</span></div>
    
    <div id="showhidemetacontent" style="display:none;">
    <br />
	<form name="meta_content" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-left:15%;">
   	     <label>Meta Discription</label><br />
         <textarea name="setting_metacontent" class="inputdesignb" style="height:10%;"><?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_metacontent")
					 {
						echo stripslashes($formvalue['value']);
						
					 }
				}
		  ?></textarea>
         <br /><br />
         <label>Meta Keywords | Seperate with a comma ( , )</label><br />
         <input value="<?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_metakeywords")
					 {
						echo stripslashes($formvalue['value']);
						
					 }
				}
		  ?>
         " name="setting_metakeywords" class="inputdesignb"/>
         <br /><br />
         <label>Title Format</label><br />
         <select value="" name="setting_titleformat" class="inputdesignb">
			<option value="title_format_1" 
            <?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_titleformat")
					 {
						if (stripslashes($formvalue['value']) == "title_format_1")
						{echo 'selected = "selected"';}
					}
				}
		  ?>
          >Site Title only</option>
            <option value="title_format_2"
              <?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_titleformat")
					 {
						if (stripslashes($formvalue['value']) == "title_format_2")
						{echo 'selected = "selected"';}
					}
				}
		  ?>>Page Title only</option>
            <option value="title_format_3"
              <?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_titleformat")
					 {
						if (stripslashes($formvalue['value']) == "title_format_3")
						{echo 'selected = "selected"';}
					}
				}
		  ?>>Site Title | Page Title</option>
            <option value="title_format_4"
              <?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_titleformat")
					 {
						if (stripslashes($formvalue['value']) == "title_format_4")
						{echo 'selected = "selected"';}
					}
				}
		  ?>>Page Title | Site Title</option>
         </select>
            
		<br /><br />
		<br /><br />

		<input type="submit" name="meta_content" value="Update" class="BUTTONsubmitb" accesskey="s" tabindex="15" style="right:30%;"/>
		<input type="reset" name="Clear" id="Clear" value="Clear" class="BUTTONsubmitb" accesskey="c" tabindex="16" />    

		<br /><br />

</form>
</div><!--ShowHideAdd-->
</div><!--CMSforms-->

<!--New Form-->
<div class="CMSforms" >
<!---------Form categories--------------->
<!---------_POST:remove_categories | add_categories -------->

<div class="formHeader togglecategories"><img src="../assets/gfx/sub-icon_black.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;"/><span style="vertical-align:middle;">Categories</span></div>
   

    <div id="showhidecategories" style="display:none;">
    <br /><br /><br />
	<form name="categories" autocomplete="off" id="updateSelection" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-left:15%;">
   	    
         <label>Categories</label><br />
         <select value="" name="setting_remove_categories" class="inputdesignb" size="5" style="height:12%;">
			<?php
				$query="SELECT * FROM `settings` where `option` = 'setting_category'";
				$result=mysql_query($query);
			
				while ($data = mysql_fetch_assoc($result)) 
					{
						echo '<option value="',$data['id'],'"';
						echo '>',$data['attribute'],'</option>';	
					}
			?>	
         </select>
         <br /><br />
         <input type="submit" name="remove_categories" value="Remove" class="BUTTONsubmitbDelete_alt" accesskey="s" tabindex="15" style="right:30%;"/>  
		<br /><br /><br />
		<label>Add New Category</label><br />
        <input value="" name="setting_add_category" class="inputdesignb"/>
        <br /><br />
		<br /><br />

		<input type="submit" name="add_categories" value="Add" class="BUTTONsubmitb" accesskey="s" tabindex="15" style="right:30%;"/>
		<input type="reset" name="Clear" id="Clear" value="Clear" class="BUTTONsubmitb" accesskey="c" tabindex="16" />    

		<br /><br />

</form>
</div><!--ShowHideAdd-->
</div><!--CMSforms-->

<!--New Form-->
<div class="CMSforms" >
<!---------Site Operation--------------->
<!---------_POST:AddNewUser-------->

<div class="formHeader toggleoperations"><img src="../assets/icons/Very_Basic/settings2/settings2-64.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;"/><span style="vertical-align:middle;">Site Operations</span></div>
   

    <div id="showhideoperations" style="display:none;">
    <br /><br /><br />
	<form name="updateSelection" autocomplete="off" id="updateSelection" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-left:15%;">
   	    
         <label>Maintainence Mode</label><br />
         <select value="" name="setting_maintainence_mode" class="inputdesignb">
			<option value="maintainence_mode_0" 
             <?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_maintainence_mode")
					 {
						if (stripslashes($formvalue['value']) == "maintainence_mode_0")
						{echo 'selected = "selected"';}
					}
				}
		  ?>>Disabled</option>
            <option value="maintainence_mode_1"  <?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_maintainence_mode")
					 {
						if (stripslashes($formvalue['value']) == "maintainence_mode_1")
						{echo 'selected = "selected"';}
					}
				}
		  ?>>Enabled</option>
          </select>
         <br /><br />
         <input type="submit" name="submit_maintainencemode" value="Change" class="BUTTONsubmitbDelete_alt" accesskey="s" tabindex="15" style="right:30%;"/>  
		<br /><br /><br />
		<label>Allowed IP Address | While Maintanance Mode is enabled <br />
			
        </label><br /><br />
        Your current IP address is <?php echo $_SERVER['REMOTE_ADDR']; ?>
        <input value="<?php 
		 	foreach ($datasettings as $formvalue)
				{
				if (stripslashes($formvalue['option']) == "setting_allowed_ip")
					 {
						echo stripslashes($formvalue['value']);
						
					 }
				}
		  ?>
        " name="setting_allowed_ip" class="inputdesignb"/>
        <br /><br /><br />
		       
        
        <h1>Backup</h1>
		<br /><br />
        <img src="../assets/icons/Very_Basic/globe/globe-26.png" width="25" height="25" style="vertical-align:middle; margin-right:2%;"/><span style="vertical-align:middle;">Website</span>
        <br /><br />
        <input type="submit" name="UpdateUser" id="UpdateUser" value="Backup Website" class="BUTTONsubmitb" accesskey="s" tabindex="15" style="right:30%;"/>  
        <br /><br /><br /><br />
		<img src="../assets/icons/Data/database/database-26.png" width="25" height="25" style="vertical-align:middle; margin-right:2%;"/><span style="vertical-align:middle;">Database</span>
        <br /><br />
        <input type="submit" name="UpdateUser" id="UpdateUser" value="Backup Database" class="BUTTONsubmitb" accesskey="s" tabindex="15" style="right:30%;"/>  
        <br /><br /><br />
		<label>*Backups of Website and Database are compressed,
        <br />you can download them and save it on a remote location.</label>
        
        <br /><br />
        <br /><br />

		<input type="submit" name="submit_siteoperations" value="Update" class="BUTTONsubmitb" accesskey="s" tabindex="15" style="right:30%;"/>
		<input type="reset" name="Clear" id="Clear" value="Clear" class="BUTTONsubmitb" accesskey="c" tabindex="16" />    

		<br /><br /><br /><br />


</form>
</div><!--ShowHideAdd-->
</div><!--CMSforms-->



</div> <!--framework-->

<div style="clear:both;"></div>
</div> <!----MainContent--->

<?php 
		/********Footer*******/
		ini_set ('display_errors',1);
		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>