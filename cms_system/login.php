<?php 


		
		require_once('../session.php');

/*if ($_SERVER["HTTPS"] != "on") 
    {
        $ssl = 'https://'.$_SERVER['SERVER_ADDR'].rootPath.'cms_system/login.php';
		header("Location: $ssl");
    }
*/		
		
		
$_SESSION['auth']=0;		/*default setting authenticated value to false*/	   

if (isset($_POST['Submit']))
 {
	 $username = addslashes($_POST['UserName']);
	 $password = addslashes($_POST['Password']);	
	 $password = sha1(salt .sha1($password)); 

		$query = "select * from `Users` where username = '$username' and password = '$password' limit 1";
		$result = mysql_query($query);

if (mysql_num_rows($result) == 1)
	{
		$_SESSION['usr'] = mysql_fetch_assoc($result);
		$_SESSION['auth'] = '1';
		$url = rootPath.'cms_system/cmsIndex.php';
		header("Location: $url");
	}
else
	{
		$error = "Invalid Username and/or Password";
		$_SESSION['auth'] = '0';
	}
 }	
 
require_once('../header.php');   

?>


<?php 
		if ($error)
			{
			echo '<script> $(document).ready(function() {';
			echo "Notifier.error('",$error,"', 'Error');";
			echo '}); </script>';
			}
?>

<br />
<br />
<br />
<br />


<div class="CMSforms" style="margin-left:auto; margin-right:auto; width:25%;">

<div class="formHeader"><span>Login</span></div>

<br />
<form name="AddUser"  autocomplete="off" class="formCMS" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
<br /><br />
<center><input type="text" name="UserName" id="UserName" class="inputdesigna" tabindex="10"  placeholder="Username" required="required" /></center>
   
<center><input type="password" name="Password" id="Password" class="inputdesigna" tabindex="40" placeholder="Password" required="required" /></center>
   
<br><br /><br />


	<input type="submit" name="Submit" id="Submit" class="BUTTONsubmit" value="Sign In" accesskey="s" tabindex="90" />
  	
    <br />

<a href="#"><p style="text-align:left;">Forgot Password ?</p></a>

</form>
