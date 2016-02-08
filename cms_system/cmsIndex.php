<?php 
	
		require('../session.php');
	   	require('../headerSecure.php'); 
		require('../header.php');
	 	
?>
<!---------------FrameWorks--------------->
<div class="right-framework">
<br /><br />
<h1>Hello!</h1>
<br />
<p>Welcome to Content Management System. <br /><br />

This is your homescreen.</p>

</div>




<div class="mainContent">
<?php	
/*------------------------------Create New Notice----------------------------*/
if (isset($_POST['NoticeSubmit']))
 {
	 $title = addslashes($_POST['Title']);
     $content = addslashes($_POST['content']);
	 $editedby =stripslashes($_SESSION['usr']['username']);
	 $ip = addslashes($_SERVER['REMOTE_ADDR']);
	 
$query = "insert into `cmsIndex` values(NULL,'$editedby',now(),'$ip','$title','$content')";
$result = mysql_query($query);

if (mysql_affected_rows()!== 1)
	{
		echo '<p class="error">',"Error - Failed to Post the notice",mysql_error(),'</p></br>';
		unset($_POST['NoticeSubmit'] );
	}
else
	{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.success('Notice Successfully Posted', '');";
			echo '}); </script>';
		unset($_POST['NoticeSubmit'] );
	}
 }

/*---------------------------------Remove Post------------------------------*/
if (isset($_POST['Remove']))
	{
		 $id = addslashes($_POST['removeID']);
		$query = "delete from `cmsIndex` where id = '$id' limit 1";
			$result = mysql_query($query);

			if (mysql_affected_rows()!== 1)
				{
					echo '<p class="error"> Failed to Remove',mysql_error(),'</p>';
					echo '<script> $(document).ready(function() {';
					echo "Notifier.error('Failed to Remove', 'Error');";
					echo '}); </script>';
				}
			else
				{
					echo '<script> $(document).ready(function() {';
					echo "Notifier.info('Notice Removed', '');";
					echo '}); </script>';
				}
	}
	
?>
<div class="CMSforms" style="width:30%; float:left; margin-right:30px;">
<div class="formHeader"><span>New Notice</span></div>
<center>
<form name="AddNotice" class="formCMS" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
	
    <br />
    <input type="text" name="Title" class="inputdesignb" style="width:90%;" tabindex="10" placeholder="Title" required="required" />
   	<br /><br />
   <textarea name="content" id="content" style="width:90%;" rows="8" accesskey="C" tabindex="11" required="required"></textarea>
<br><br />
<br /><br />

	<input type="submit" name="NoticeSubmit" id="Submit" class="BUTTONsubmit" value="Post" accesskey="s" tabindex="12" />
  	
<br />



</form>
</center>
</div>

<div class="noticeArea">
<div class="formHeader" style="background:#ccc; color:#1d1d1d;"><img src="../assets/icons/Very_Basic/info/info-32.png" width="30" height="30" style="vertical-align:middle; padding-left:2%;"/><span style="vertical-align:middle;">Posted Notices</span></div>
<?php	
/*-----------------------------Display Notice----------------------------*/

		$query="SELECT * FROM `cmsIndex`";
		$result=mysql_query($query);
		$num=mysql_numrows($result);
		if ($num!==0)
			{
			$i=0;
		while ($i < $num) 
			{
				$usr[]= mysql_result($result,$i,"id");
				$i++;
			}
		$tableresult = mysql_query($query);	
		$_SESSION['cmsIndexNotice'] = mysql_fetch_assoc($tableresult);
		foreach ($usr as $optionVal) 
			{
				$query = "select * from `cmsIndex` where id = '$optionVal' order by date DESC limit 1";
				$tableresult = mysql_query($query);	
				$_SESSION['cmsIndexNotice'] = mysql_fetch_assoc($tableresult);
								
						echo '<div class="noticeBox">';
						echo '<p class="noticeTitle">',stripslashes($_SESSION['cmsIndexNotice']['title']),'</p></br>';
						echo '<p class="noticeInfo"> Posted by ',stripslashes($_SESSION['cmsIndexNotice']['editedby']);
						echo '&nbsp;on ',stripslashes($_SESSION['cmsIndexNotice']['date']),'</p>';
						echo '<p class="noticeContent">',stripslashes($_SESSION['cmsIndexNotice']['content']),'</p>';
						/*----------------------------------Remove Button for each Notice--------------------*/
						echo '	<form name="removeNotice" action="',$_SERVER['PHP_SELF'],'" method="post" >
								<input type="text" name="removeID" value="',stripslashes($_SESSION['cmsIndexNotice']['id']),			
								'"class="invisible"/>
								<input type="submit" name="Remove" id="Remove" value="Remove" class="removeNotice" style="" />
								</form></br>';
						echo '</div>';
			}
			}

?>	


</div>
<div style="clear:both"></div>
</div><!--mainContent-->

</div>

<?php 
	
		ini_set ('display_errors',1);

		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>

