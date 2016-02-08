<?php 
require('../session.php');


$path = rootPath.'install/rootPath.txt';
$dir = open_dir_ext."install/open_dir.txt";
$failed = 0;
if (file_exists($dir))
	{
	 echo 'Ready for Installation';
	}
else
	{
	echo 'Please check your config.php, your rootPath is not set correctly';
	$failed++;	
	}

$fh = fopen($dir, 'w') or die("Please check your config.php, your rootPath is not set correctly");
fwrite($fh, 'write check..');
fclose($fh);

?>

<html>
<head>
<title>CMS Installation</title>
<link href="<?php echo rootPath;?>cms_system/css/cms.css" rel="stylesheet" type="text/css" />


</head>
<body>

<div class="right-framework">
<br /><br />
<h1> Welcome</h1>
<br>
<h3> CMS Installation</h3>
<br><br>
<p>If you are receiving errors, please make sure you have entered database information on config.php</p>
</div>

<div class="mainContent">

<div style="width:50%; margin-left:auto; margin-right:auto;">
<div class="CMSforms" >
	
<div class="formHeader togglegeneral" ><img src="<?php echo rootPath;?>assets/icons/System/settings/settings-128.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;"/><span style="vertical-align:middle;">Install CMS</span></div>
  
<form name="install_settings" autocomplete="off" action="install_start.php" method="post" style="margin-left:15%;">
<br><br>
<label>Please provide following information</label>
<br><br><br><br>
<label>Site Name</label><br>
<input type="text" value="" name="setting_sitetitle" class="inputdesignb" required/>
<br><br>
<label>Admin UserName</label><br>
<input type="text" value="" name="setting_username" class="inputdesignb" required/>
<br><br>
<label>Password</label><br>
<input type="password" value="" name="setting_password" class="inputdesignb" required/>
<br><br>
<label>Re-enter Password</label><br>
<input type="password" value="" name="setting_re_password" class="inputdesignb" required/>
<br><br>
<label>E-mail Address</label><br>
<input type="email" value="" name="setting_email" class="inputdesignb" required/>
<br><br>
<br><br>



<input type="submit" name="install_settings" id="UpdateUser" value="Install" class="BUTTONsubmitb" accesskey="s" tabindex="15" style="right:30%;"/>
		
<br /><br />
<br><br>

</form>
</div>
</div>
</div>	<!--mainContent-->
</body>
</html>