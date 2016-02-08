<?php 
	
		require('session.php');
	   	require('htmlheader.php');
		include('htmlnavigation.php');
?>





<body>
<div class="mainContent">


<?php	
/*-----------------------------Display Page----------------------------*/
if (is_numeric($_REQUEST['pid']))
	{
		$pid = $_REQUEST['pid'];
		$query="SELECT * FROM `page` where id='$pid' limit 1 ";
		$result=mysql_query($query);
	
		$pagecode = mysql_fetch_assoc($result);
		echo htmlspecialchars_decode($pagecode['content']);
	}
else
	{
		$query="SELECT * FROM `page` where id='$default_homepage_id' limit 1";
		$result=mysql_query($query);
	
		$pagecode = mysql_fetch_assoc($result);
		echo htmlspecialchars_decode($pagecode['content']);
	}

?>	


<div style="clear:both"></div>
</div><!--mainContent-->

<?php 
/*---------------------------Footer------------------------------------*/	
		ini_set ('display_errors',1);

		error_reporting (E_ALL & ~E_NOTICE);
	    include('footer.php'); 
?>

