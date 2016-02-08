<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Content Management System | AshDown</title>



<!---StyleSheet-->
<link href="<?php echo rootPath;?>cms_system/css/cms.css" rel="stylesheet" type="text/css" />




<!---JavaScripts-->


<script src="<?php echo rootPath;?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo rootPath;?>assets/jquery/jquery-1.9.1.js"></script>
<script src="<?php echo rootPath;?>assets/jquery/jquery-ui.js"></script> 
<script src="<?php echo rootPath;?>cms_system/js/jquery.autosize.js"></script>
<script type="text/javascript" src="<?php echo rootPath;?>cms_system/js/jquery.form.js"></script> 
<link href="<?php echo rootPath;?>assets/ckeditor/ckeditor_style.css" rel="stylesheet">


<!---jqeury/jquery-ui/css--->
<script type="text/javascript" src="<?php echo rootPath;?>cms_system/js/jquery.js"></script>

<script type="text/javascript" src="<?php echo rootPath;?>cms_system/js/jquery.form.js"></script>
<link href="<?php echo rootPath;?>assets/jquery/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo rootPath;?>js/notifier.js"></script>
<script type="text/javascript" src="<?php echo rootPath;?>cms_system/js/popup.js"></script>
<!--Assests-->
<script type="text/javascript" src="<?php echo rootPath;?>assets/codemirror/lib/codemirror.js"></script>
<link href="<?php echo rootPath;?>assets/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css" />
<script src="<?php echo rootPath;?>assets/codemirror/mode/css/css.js"></script>

<!--CodeMirror-->




<!---Scripts---->
  <script>

			// This call can be placed at any point after the
			// <textarea>, or inside a <head><script> in a
			// window.onload event handler.

			// Replace the <textarea id="editor"> with an CKEditor
			// instance, using default configurations.

			
			
	</script>

<?php
if (isset($_extrajs))
	{
		echo '<script> $(document).ready(function() {';
		echo "CKEDITOR.replace( 'editor1' );";
	
		echo $_extrajs;
		echo '}); </script>';
		
	}

?>




<?php
	if ($_SESSION['logout'] == 1)
		{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.success('You have logged out successfully', '');";
			echo '}); </script>';
			unset($_SESSION['logout']);
		}
	else
		{
			if (is_array($_SESSION['messages']))
				{
					//echo '<p class="error">',implode('</br>',$_SESSION['messages']),'</p>';
					
					foreach ($_SESSION['messages'] as $errordata)
						{
								
								echo '<script> $(document).ready(function() {';
								echo "Notifier.error('",$errordata,"', 'Error');";
								echo '}); </script>';
						}
					
					echo '<script> $(document).ready(function() {';
					
					echo '}); </script>';
		
					unset ($_SESSION['messages']);
				}
		}
?>
</head>
<body>
<?php
if ($_SESSION['auth']=='1')
	{
				
			echo '<div class="titleNotice">';
			echo '<p class="notice">',stripslashes($_SESSION['usr']['firstname']),' ',stripslashes($_SESSION['usr']['lastname']),'</p>';		/*---Submit Button for Logging out---*/
			echo '<form name="logoff" action="',$_SERVER['PHP_SELF'],'" method="post" >						
					<input type="submit" name="logout" id="logout" value="Log Out" />
					</form>';
			echo '</div>';
		
		
	if (isset($_SESSION['error']))
		{
		foreach ($_SESSION['error'] as $var)
			{
				echo '<p class="alerts">',$var,'</p></br>';			/*-----Prints out Login Errors-------*/
			}
	
		unset($_SESSION['error']);
		}
	}
?>
        
<script> $(document).ready(function() { $('#togglepages').click(function(){ $('div#showhidepages').toggle(); }); }); </script>
<script> $(document).ready(function() { $('#togglescripts').click(function(){ $('div#showhidescripts').toggle(); }); }); </script>


<!--------Navigation------------------->
<div class ="left-framework">
<img src="<?php echo rootPath;?>assets/gfx/ash-logo_white.png" class="logo"/>
<div class="navigation">
<div class="navigation-line"><p><a href="<?php echo rootPath;?>cms_system/cmsIndex.php">CMS Home</a></p></div>
<div class="navigation-line"><p><a href="<?php echo rootPath;?>cms_system/usermanager.php">User Manager</a></p></div>
<div class="navigation-line" id="togglescripts"><p>Scripts Manager</p><img src="<?php echo rootPath;?>assets/gfx/sub-icon_black.png" class="navigationIcon"/></div>

<div class="navigation-sub" id="showhidescripts">
<p><a href="<?php echo rootPath;?>cms_system/scriptsMang.php">Add Scripts</a></p>
<p><a href="<?php echo rootPath;?>css/editScripts.php">Edit Scripts</a></p>
</div>

<div class="navigation-line"><p><a href="<?php echo rootPath;?>cms_system/navigation.php">Navigation</a></p></div>

<div class="navigation-line" id="togglepages"><p>Pages</p><img src="<?php echo rootPath;?>assets/gfx/sub-icon_black.png" class="navigationIcon"/></div>

<div class="navigation-sub" id="showhidepages">
<p><a href="<?php echo rootPath;?>cms_system/newpage.php">Create New Page</a></p>
<p><a href="<?php echo rootPath;?>cms_system/pages.php">Update Page</a></p>
</div>

<div class="navigation-line"><p><a href="<?php echo rootPath;?>cms_system/media.php">Media </a></p></div> 	
<div class="navigation-line" id="togglepages"><p><a href="<?php echo rootPath;?>cms_system/settings.php">Settings</a></p><img src="<?php echo rootPath;?>assets/icons/System/settings/settings-128.png" class="navigationIcon"/></div>

</div>	
</div>>>>>>>>