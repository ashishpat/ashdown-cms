<?php 
	
		require('../session.php');
/*$_extrajs .= <<<eof
	$('#username').change(function(){
	$('#updateSelectionSubmit').click();
	});
eof;
*/
		require('../headerSecure.php'); 
		require('../header.php');
	   	
		
	 	
?>
<!---------------FrameWorks--------------->
<div class="right-framework">
<br /><br />
<h1>User Manager</h1>
<br />
<p>Add, Delete or Edit User information<br /><br />
</p>

</div>
	
<div class="mainContent">

<?php	
/*------------------------------Create New User----------------------------*/
if (isset($_POST['AddNewUser']))
 {
	 $username = addslashes($_POST['UserName']);
     $firstname = addslashes($_POST['FirstName']);
	 $lastname = addslashes($_POST['LastName']);
	 $password = addslashes($_POST['Password']);
	 $repassword = addslashes($_POST['RePassword']);
	 $ip = addslashes($_SERVER['REMOTE_ADDR']);
     $email = addslashes($_POST['Email']);
     	 
	 if($password !== $repassword)
			{
				echo '<script> $(document).ready(function() {';
					echo "Notifier.warning('Password do not match', '');";
					echo '}); </script>';
			}
	else
		{
$password = sha1(salt .sha1($password)); 
$query = "insert into `Users` values(NULL,'$username','$password','$email','$firstname','$lastname','$ip',now())";
$result = mysql_query($query);

if (mysql_affected_rows()!== 1)
	{
		echo '<p class="error">',"Error - Failed to add new user",mysql_error(),'</p></br>';
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Failed to Add New User', 'Error');";
		echo '}); </script>';
		unset($_POST);
	}
else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.success('New User successfully added.', '');";
		echo '}); </script>';
		unset($_POST);
	}
		}
 }
    

?>

<?php
/*------------------------------Update User----------------------------*/
if (isset($_POST['UpdateUser']))
{
	 $username = addslashes($_POST['UserName']);
     $firstname = addslashes($_POST['FirstName']);
	 $lastname = addslashes($_POST['LastName']);
	 $password = addslashes($_POST['Password']);
	 $repassword = addslashes($_POST['RePassword']);
	 $ip = addslashes($_SERVER['REMOTE_ADDR']);
     $email = addslashes($_POST['Email']);
	 $id = addslashes($_POST['id']);
	 
	 echo $username;
	 echo $firstname;
	 echo $lastname;
	 echo $password;
	 echo $repassword;
	 echo $ip;
	 echo $email;
	 echo $id;
	 if($password !== $repassword)
			{
				echo "Passwords do not match";
			}
	else
		{
$password = sha1(salt .sha1($password)); 


$query = "update `Users` set `username` = '$username', `firstname` = '$firstname', `lastname` = '$lastname', `password` = '$password', `email`= '$email', `ipaddress` = '$ip' where `id` = '$id' limit 1";

$result = mysql_query($query);

if (mysql_affected_rows()!== 1)
	{
		echo '<p class="error">',"Error - Failed to Update User",mysql_error(),'</p></br>';
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Failed to Update User', 'Error');";
		echo '}); </script>';
	}
else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.success('User updated successfully', '');";
		echo '}); </script>';
		unset($_POST);
	}
}
}



?>
<?php


/*------------------------------Delete User----------------------------*/
if (isset($_POST['DeleteUser']))
{
	foreach ($_POST['deleteUserID'] as $key => $val)
		{
			$query = "select * from `Users` where id = '$val' limit 1";
			$getUser_result = mysql_query($query);	
			$_SESSION['getUser'] = mysql_fetch_assoc($getUser_result);
			$query = "delete from `Users` where id = '$val' limit 1";
			$result = mysql_query($query);

			if (mysql_affected_rows()!== 1)
				{
					echo '<p class="error"> Failed to delete',mysql_error(),'</p>';
					echo '<script> $(document).ready(function() {';
					echo "Notifier.error('Failed to Remove User', 'Error');";
					echo '}); </script>';
				}
			else
				{
					echo '<script> $(document).ready(function() {';
					echo "Notifier.warning('User account of ",stripslashes($_SESSION['getUser']['firstname'])," deleted', '');";
					echo '}); </script>';
				}
		}
}
unset($_SESSION['getUser']);
unset ($_POST['deleteUserID']);
?>


<br />
<br />
<script> $(document).ready(function() { $('.toggleedit').click(function(){ $('div#showhideedit').toggle(); }); }); </script>
<script> $(document).ready(function() { $('.toggleadd').click(function(){ $('div#showhideadd').toggle(); }); }); </script>

<div class="left-float">
<div class="CMSforms" >
	
	<div class="formHeader toggleedit toggleadd"><img src="../assets/gfx/sub-icon_black.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;"/><span style="vertical-align:middle;">Edit User Information</span></div>
    
    <div id="showhideedit" >
    <br />
	<img src="../assets/icons/Users/edit_user/26.png" style="padding-left:10%;"/>
    <br />
    <form name="updateSelection" id="updateSelection" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   	<center>
    <select id="username" class="inputdesignb" name="username">
    <!----------------Lists the Users on Dropdown----------->
    <!----------------_POST:updateSelectionSubmit-------->
	<?php
		$query="SELECT * FROM `Users`";
		$result=mysql_query($query);
		$num=mysql_numrows($result);

		while ($data = mysql_fetch_assoc($result)) 
			{
				$datatableuser[] = $data;
				echo '<option value="',$data['id'],'"';
				if ($_POST['username'] == $data['id'])
					{echo ' selected = "selected"';}
				echo '>',stripslashes($data['username']),'</option>';	
			}
		?>	
    </select>
    <br /><br />
    <input type="submit" name="updateSelectionSubmit" class="BUTTONsubmitb"  value="Edit Selected User" accesskey="s" />
    </form>
  <!---------------------Listing User data on--------------------->
    <!---------------------Fills up the ramainder of the Form using Database---------->
    <?php
	if (isset($_POST['updateSelectionSubmit']) && is_numeric($_POST['username']))
		{
		$id = addslashes($_POST['username']);
		$query = "select * from `Users` where id=$id limit 1";
		$result = mysql_query($query);	
		
		$data = mysql_fetch_assoc($result);
		
		echo '<p> Editing ',stripslashes($data['firstname']),'</p>';
		}
	unset($_POST['updateSelectionSubmit'] );
	?>
    <form autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <form name="UpdateUser" class="formCMS" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
    <p>
    <input type="text" class="inputdesignb"  name="UserName" id="UserName" value="<? echo stripslashes($data['username']);?>" 
    required="required" tabindex="9" />
    </p>
    <input type="text" class="invisible" name="id" value="<? echo $id; ?>"/>
    <p>
    <input type="text"  class="inputdesignb" name="FirstName" id="FirstName" value="<? echo stripslashes($data['firstname']);?>" 
    required="required" tabindex="10" />
    </p>
    <p>
    <input type="text" class="inputdesignb"  name="LastName" id="LastName" value="<? echo stripslashes($data['lastname']);?>" 
    required="required" tabindex="11" />
    </p>
    <p>
    <input type="password" class="inputdesignb"  name="Password" id="Password" placeholder="New Password" required="required" tabindex="12" />
    </p>
    <p>
    <input type="password" class="inputdesignb"  name="RePassword" id="RePassword" placeholder="Retype New Password" required="required"  tabindex="13" />
    </p>
    <p>
    <input type="text" class="inputdesignb"  name="Email" id="Email" value="<? echo stripslashes($data['email']);?>" 
    required="required" tabindex="14" size="20" />
    </p>
   
<br />
<br />
<br />



<center>
<br />

<input type="submit" name="UpdateUser" id="UpdateUser" value="Update" class="BUTTONsubmit" accesskey="s" tabindex="15" style="right:30%;"/>
<input type="reset" name="Clear" id="Clear" value="Clear" class="BUTTONsubmit" accesskey="c" tabindex="16" />    
</center>

</form>

</div><!--ShowhideEdit-->
</div><!--CMSforms-->
<div class="CMSforms" >
<!---------Form AddNewUser--------------->
<!---------_POST:AddNewUser-------->

<form name="AddUser" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >

    <div class="formHeader toggleadd toggleedit"><img src="../assets/gfx/sub-icon_black.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;"/><span style="vertical-align:middle;">Add New User</span></div>
    
    <div id="showhideadd" style="display:none;">
    <br />
	<img src="../assets/icons/Users/add_user/add_user-32.png" style="padding-left:10%;"/>
    <p><input type="text" class="inputdesignb" name="UserName" id="UserName" placeholder="Username"  required="required" tabindex="1" /></p>
    <p><input type="text" class="inputdesignb" name="FirstName" id="FirstName" placeholder="First Name" required="required" tabindex="2" /></p>
    <p><input type="text" class="inputdesignb" name="LastName" id="LastName"placeholder="Last Name" required="required" tabindex="3" /></p>
    <p><input type="password" class="inputdesignb" name="Password" id="Password" placeholder="Password" required="required" tabindex="4" /></p>
    <p> <input type="password" class="inputdesignb" name="RePassword" id="RePassword" placeholder="Retype Password" required="required"  tabindex="5" /></p>
    <p><input type="text" class="inputdesignb" name="Email" id="Email" placeholder="Email Address" required="required" tabindex="6" size="20" /></p>
   
<br><br />
<input type="submit" name="AddNewUser" id="Submit" value="Create" class="BUTTONsubmit" accesskey="s" tabindex="7" style="right:30%;"/>&nbsp;
<input type="reset" name="Clear" id="Clear" value="Clear" class="BUTTONsubmit" accesskey="c" tabindex="8" />    
<br /><br />
</form>
</div><!--ShowHideAdd-->
</div><!--CMSforms-->




</div>


<div class="datatable">
<div class="formHeader" style="background:#efefef; color:#1d1d1d;"><img src="../assets/icons/Users/remove_user/remove_user-32.png" width="30" height="30" style="vertical-align:middle; padding-left:2%;"/><span style="vertical-align:middle;">User information and Delete</span></div>
<form name="deleteUser" class="formCMS" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table width="500" border="0">
  <tr >
    <th scope="col">ID</th>
    <th  scope="col">Username</th>
    <th  scope="col">First Name</th>
    <th  scope="col">Last Name</th>
    <th  scope="col">Email</th>
    <th scope="col">Delete?</th>
  </tr>
  <?php
		foreach ($datatableuser as $user)
		{
								
								echo '<tr><td>',stripslashes($user['id']),'</td>';
								echo '<td>',stripslashes($user['username']),'</td>';
								echo '<td>',stripslashes($user['firstname']),'</td>';
								echo '<td>',stripslashes($user['lastname']),'</td>';
								echo '<td>',stripslashes($user['email']),'</td>';
								echo '<td><input type="checkbox" name="deleteUserID[',$count,']" value="',stripslashes($user['id']),'"></input></td></tr>';			
			}
			
		?>	
        
 </table>
 <br />

 <center>
<br />
 <input type="submit" name="DeleteUser" id="Submit" value="Delete Selected" class="BUTTONsubmitb" accesskey="s" tabindex="15" />&nbsp;
<input type="reset" name="Clear" id="Clear" value="Cancel" class="BUTTONsubmitb" accesskey="c" tabindex="16" />   
</center>
</form>
<br />

</div>


</div><!--mainContent-->

</div>

<?php 
	
		ini_set ('display_errors',1);

		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>

