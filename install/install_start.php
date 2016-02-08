<?php 
require('../session.php');


if (isset($_POST['install_settings']))
{
	$setting_sitetitle 	= addslashes($_POST['setting_sitetitle']);
	$setting_email	 	= addslashes($_POST['setting_email']);
	$username = addslashes($_POST['setting_username']);
    
	$password = addslashes($_POST['setting_password']);
	$repassword = addslashes($_POST['setting_re_password']);
	$ip = addslashes($_SERVER['REMOTE_ADDR']);
	
	if($password !== $repassword)
			{
				echo '<p class="alert"> Alert: Password does not match </p>';
				echo '<p><a href="install.php">Go back</a></p>';
			}
	else
	{
	$password = sha1(salt .sha1($password)); 
	
	$db_host_install =  db_host;
	$db_database_install = db_database;
	$db_user_install = db_user;
	$db_password_install = db_password;

	if (!isset($db_host_install,$db_database_install,$db_user_install,$db_password_install))
		{
				echo '<p class="alert"> Alert: config.php has NOT been set. Please refer to installation instruction.</p>';
				echo '<p><a href="#">Installation Instructions</a></p>';
		}
	else
		
{
/*Installation Begin*/

echo '<p class="process">Starting Installation...</p><br>';	
$success = 0;


/*`User` table Creation*/
echo '<p>Creating table `Users`</p><br /><br />'; 
$query = "
   CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `ipaddress` tinytext NOT NULL,
  `lastaccess` datetime NOT NULL,
  PRIMARY KEY  (`id`)
)";
	
$result = mysql_query($query);

if (!$result)
	{
		echo '<p style="color:red;">Failed to create table `Users` ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		$success++;
	}

/*Creating User*/
echo '<p>Creating User ',$username,'</p><br />';
$query = "INSERT INTO `Users` VALUES(NULL, '$username', '$password', '$setting_email', 'admin', 'user', '$ip', now)";

$result = mysql_query($query);

if (!$result)
	{
		echo '<p style="color:red;">Failed to create user! ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		echo '<p>User Created...</p><br /><br />';			
	}
	
/*Creating `cmsIndex` table*/
echo '<p class="process">Creating `cmsIndex` table...</p><br>';	

$query = "CREATE TABLE IF NOT EXISTS `cmsIndex` (
  `id` int(11) NOT NULL auto_increment,
  `editedby` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `ipaddress` tinytext NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ";


$result = mysql_query($query);

if (!$result)
	{
		echo '<p style="color:red;">Failed to create table `CMS Index` ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		$success++;
	}

/*Creating `media` table*/
echo '<p class="process">Creating `media` table...</p><br>';	

$query = "CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `ipaddress` tinytext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `filename` (`filename`)
)";

$result = mysql_query($query);

if (!$result)
	{
		echo '<p style="color:red;">Failed to create table `media` ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		$success++;
	}

/*Creating `nav` table*/
echo '<p class="process">Creating `nav` table...</p><br>';	
	
$query = "CREATE TABLE IF NOT EXISTS `nav` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `level` int(11) default NULL,
  `navorder` int(10) default NULL,
  `parent_id` int(11) default NULL,
  `page_id` int(11) default NULL,
  `post_id` int(11) default NULL,
  `link` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
)";

$result = mysql_query($query);

if (!$result)
	{
		echo '<p style="color:red;">Failed to create table `nav` ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		$success++;
	}
			
			
			

/*Creating `page` table*/
echo '<p class="process">Creating `page` table...</p><br>';	
	
$query = "CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL auto_increment,
  `nav_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `css` text NOT NULL,
  `editedby` varchar(100) NOT NULL,
  `lastupdated` datetime NOT NULL,
  `ipaddress` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
)";

$result = mysql_query($query);

if (!$result)
	{
		echo '<p style="color:red;">Failed to create table `page` ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		$success++;
	}
	

/*Creating `scripts` table*/
echo '<p class="process">Creating `scripts` table...</p><br>';	
	
$query = "CREATE TABLE IF NOT EXISTS `scripts` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `type` varchar(100) default NULL,
  `content` text,
  `url` varchar(300) default NULL,
  `page_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
)";

$result = mysql_query($query);

if (!$result)
	{
		echo '<p style="color:red;">Failed to create table `scripts` ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		$success++;
	}
	
$index_url = rootPath.'css/index.css';
$navigation_url = rootPath.'css/navigation.css';


/*Creating `navigation` table*/
echo '<p class="process">Inserting navigation CSS...</p><br>';	

$query = "INSERT INTO `scripts` (`id`, `name`, `type`, `content`, `url`, `page_id`) VALUES
(5, 'index.css', 'css', '', '$index_url', 0),
(6, 'navigation.css', 'css', '', '$navigation_url', 0); ";

$result = mysql_query($query);
	
if (!$result)
	{
		echo '<p style="color:red;">Failed to add Items to Navigation ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		echo '<p>Navigation Items Updated...</p><br /><br />';			
	}
	
	

/*Creating `settings` table*/
echo '<p class="process">Creating `settings` table...</p><br>';	
	
$query = "CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL auto_increment,
  `option` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `attribute` varchar(100) NOT NULL,
  `ipaddress` tinytext NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
)";

$result = mysql_query($query);

if (!$result)
	{
		echo '<p style="color:red;">Failed to create table `settings` ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		$success++;
	}
	
	
/*Adding 'settings'*/
echo '<p class="process">Creating `scripts` table...</p><br>';	



$query = "INSERT INTO `settings` (`id`, `option`, `value`, `attribute`, `ipaddress`, `date`) VALUES
(1, 'setting_sitetitle', '', '', '$ip', now),
(2, 'setting_siteurl', '', '', '$ip', now),
(3, 'setting_email', '', '', '$ip', now),
(4, 'setting_category', 'pageupload', 'Page Upload', '$ip', now),
(5, 'setting_metacontent', '', '', '$ip', now),
(6, 'setting_metakeywords', '', '', '$ip', now),
(7, 'setting_titleformat', 'title_format_4', '', '$ip', now),
(8, 'setting_maintainence_mode', 'maintainence_mode_0', '', '$ip', now),
(9, 'setting_allowed_ip', '', '', '$ip', now),
(10, 'setting_category', 'mediaupload', 'Media Upload', '$ip', now),
(11, 'setting_defaultpage', '18', '', '10.10.10.10', now);";

$result = mysql_query($query);
	
if (!$result)
	{
		echo '<p style="color:red;">Failed to add Settings ',mysql_error(),'</p><br /><br />';			
	}
else
	{
		echo '<p>Settings Updated...</p><br /><br />';			
	}
	

echo $sucess;
echo '<h1>Installation Successful</h1>';
echo '<p><a href="../cms_system/login.php">Sign In</a></p>';
	
	
	
	
/*Installation Ends*/
}
	
	
	
	
	
	
	
	}


	


}


?>