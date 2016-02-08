<?php
	$query = "SELECT * FROM `settings`";
	$result = mysql_query($query);
	
	while ($datatitle_query = mysql_fetch_assoc($result)) 
			{
				$datatitle[] = $datatitle_query;	
			}
	foreach ($datatitle as $metadata)
				{
				if (stripslashes($metadata['option']) == "setting_maintainence_mode")
					 {
						if (stripslashes($metadata['value']) == "maintainence_mode_1")
							{$maintainence_mode = 'Enabled';}
						else
							{$maintainence_mode = '';}
					}
				if (stripslashes($metadata['option']) == "setting_allowed_ip")
					 {
						$allowed_ip =  stripslashes($metadata['value']);
					 }
				}
	//$server_id = (string)$_SERVER['REMOTE_ADDR'];
	//$allowed_ip = (string)$allowed_ip;
	
	
	
	$allowed_ip = str_replace(' ','',$allowed_ip);
	$server_ip = str_replace(' ','',$_SERVER['REMOTE_ADDR']);


	if ($maintainence_mode == 'Enabled')
	{
			if ( $allowed_ip != $server_ip)
			{
				$url = rootPath.'cms_admin/maintainence.html';
				header("Location: $url");
			}
			
	}
	
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="description" content="<?php 
		 	foreach ($datatitle as $metadata)
				{
				if (stripslashes($metadata['option']) == "setting_metacontent")
					 {
						echo stripslashes($metadata['value']);
					 }
				}
?>" />	
<meta name="keywords" content="<?php 
		 	foreach ($datatitle as $metadata)
				{
				if (stripslashes($metadata['option']) == "setting_metakeywords")
					 {
						echo stripslashes($metadata['value']);
					 }
				}
?>" />	

<?php
/*Default Home Page*/
foreach ($datatitle as $metadata)
				{
				if (stripslashes($metadata['option']) == "setting_defaultpage")
					 {
						$default_homepage_id = stripslashes($metadata['value']);
					 }
				}
?>
<title>
<?php
/*Title Query*/
if (is_numeric($_REQUEST['pid']))
	{
		$page_id = $_REQUEST['pid'];
	}
else 
	{
	 	$page_id = $default_homepage_id;	
	}
		$query="SELECT * FROM `page` where `id`='$page_id' limit 1";
		$result=mysql_query($query);
	
		$pagetitle = mysql_fetch_assoc($result);
		$pagetitle_value = stripslashes($pagetitle['title']);
	
	//print_r($datatitle);
	foreach ($datatitle as $title)
		{
			if (stripslashes($title['option']) == "setting_sitetitle")
				{$title_sitetitle = stripslashes($title['value']);}
			if (stripslashes($title['option']) == "setting_titleformat")	
				{
					
					if (stripslashes($title['value']) == "title_format_1")
						{echo $title_sitetitle;}
					if (stripslashes($title['value']) == "title_format_2")
						{echo $pagetitle_value;}
					if (stripslashes($title['value']) == "title_format_3")
						{echo $title_sitetitle,' | ',$pagetitle_value;}
					if (stripslashes($title['value']) == "title_format_4")
						{echo $pagetitle_value,' | ',$title_sitetitle;}
				}
		}



?>

</title>



<!---JavaScripts and CSS files-->
<?php
	
	$query = "SELECT * FROM `scripts`";
	$result = mysql_query($query);
	
	while ($datascripts_query = mysql_fetch_assoc($result)) 
			{
				$datascripts[] = $datascripts_query;	
			}
	
			
	foreach ($datascripts as $scripts)
		{
			if ($scripts['page_id'] == 0)
				{
					
					if (stripslashes($scripts['type']) == "css")
						{
							
							echo '<link href="',stripslashes($scripts['url']),'" rel="stylesheet" type="text/css" />  ';
						
						}
					if ($datascripts['type'] == "js" )
						{
							echo '<scripts type="text/javascripts" src="',stripslashes($scripts['url']),'"/>';
						}
				}
			else
				{
					if ($scripts['page_id'] == $_REQUEST['page_id'])
						{
						if ($scripts['type'] == "css")
							{
								echo '<link href="',stripslashes($scripts['url']),'" rel="stylesheet" type="text/css" /> ';
							}
						if ($scripts['type'] == "js" )
							{
								echo '<scripts type="text/javascripts" src="',stripslashes($scripts['url']),'"/>';
							}	
							
						}	
				}
		}
?>

<!---StyleSheet-->
<?php
echo '<style type="text/css">';
if (is_numeric($_REQUEST['pid']))
	{
		$pid = $_REQUEST['pid'];
		$query="SELECT * FROM `page` where id='$pid' limit 1 ";
		$result=mysql_query($query);
	
		$pagecode = mysql_fetch_assoc($result);
		echo htmlspecialchars_decode($pagecode['css']);
	}
else
	{
		$query="SELECT * FROM `page` where  id='$default_homepage_id' limit 1";
		$result=mysql_query($query);
	
		$pagecode = mysql_fetch_assoc($result);
		echo htmlspecialchars_decode($pagecode['css']);
	}
echo '</style>';
?>


</head>