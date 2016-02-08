<?php
if (isset($_POST['logout']))
	{
		$_SESSION['auth']=0;
		unset($_SESSION['usr']);
		$_SESSION['logout']=1;
		//echo "<body onload=\"window.location='",rootPath,"cms_system/login.php'\">"; 
		$url = rootPath.'cms_system/login.php';
		header("Location: $url");
						/*-------Redirects to login.php--------*/
	}
	
?>
<?php
if ($_SESSION['auth']=='1')
	{
	
	}
else 
	{
		unset($_SESSION['usr']);
		unset($_SESSION['error']);
		$_SESSION['messages'][] = "You must Login to view this page" ; 
		header("Location: login.php");
		die ('Page has terminated');		/*-------Redirects Failed authentication to login.php--------*/
	}

?>