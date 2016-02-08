<?php 
	
		require('../session.php');

$_extrajs .= <<<eof
  $( "#sortable" ).sortable();
  $( "#sortable" ).disableSelection();
  $('.toggleh1').click(function(){
  $('div.showhide').toggle();
   });
});

eof;

		require('../headerSecure.php'); 
		require('../header.php');
		
?>



<?php	
/*------------------------------Add New Navigation----------------------------*/
if (isset($_POST['newNav']))
 {
	 $name 		= addslashes($_POST['navName']);
     $parent_id = addslashes($_POST['parent_id']);
	 $page_id 	= addslashes($_POST['pageID']);
	 $post_id 	= 0;
  	 $nav_link 	= addslashes($_POST['url']);

$query 	= "select * from `nav` where id = '$parent_id'";
$result = mysql_query($query) or print mysql_error(); 
$data 	= mysql_fetch_assoc($result);

$level = addslashes($data['level'] + 1);



$query 		= "select count(id) from `nav` where parent_id = '$parent_id'";
$result 	= mysql_query($query) or print mysql_error(); 
$navorder 	= addslashes(mysql_result($result,0,0) + 1);						//Adding One to the total number of Children for new menu item


$query = "insert into `nav` values(NULL,'$name','$level','$navorder','$parent_id','$page_id','$post_id','$nav_link')";
$result = mysql_query($query);

if (mysql_affected_rows()!== 1)
	{
		echo '<p class="error">'," Error - Failed to add new Navigation item ",mysql_error(),'</p></br>';
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Failed to add new Navigation item', 'Error');";
		echo '}); </script>';
		unset($_POST);
	}
else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.success('New Navigation item created.', '');";
		echo '}); </script>';
		unset($_POST);
	}
		}
 
    

?>

<?php
/*------------------------------Delete Navigation----------------------------*/
if (is_numeric($_REQUEST['delete_nav_item']))
{
	$id = addslashes($_REQUEST['delete_nav_item']);
    
	$query = "select count(id) as num_children from `nav` where parent_id = '$id'";
	$result= mysql_query($query);
	if (mysql_result($result,0,0) == 0)
	{
	$query = "delete from `nav` where id = '$id' limit 1";
	$result = mysql_query($query);

if (mysql_affected_rows()!== 1)
	{
		echo '<p class="error">'," Error - Failed to delete Navigation item ",mysql_error(),'</p></br>';
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Failed to delete Navigation item', 'Error');";
		echo '}); </script>';
		unset($_REQUEST);
	}
else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.warning('Navigation Item Deleted.', '');";
		echo '}); </script>';
		unset($_REQUEST);
	}
	}
	else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Cannot Delete this Navigation Item, includes Child items', 'Error');";
		echo '}); </script>';
		echo '<p class="error">',"Cannot Delete this Navigation Item, includes Child items - Delete/Move Child items first",mysql_error(),'</p></br>';
		unset($_REQUEST);
	}
}
?>

<?php	
/*------------------------------Update Navigation----------------------------*/
if (isset($_POST['editNav']))
 {
	 $edit_id =  $_POST['edit_id'];
	 $edit_name = addslashes($_POST['edit_name']);
     $edit_url = addslashes($_POST['edit_url']);
	 
	
if ($edit_url)
{
	$query = "update `nav` set `name` = '$edit_name',`link` = '$edit_url' where `id` = '$edit_id' limit 1";
	$result = mysql_query($query);

}
else
{
	$query = "update `nav` set `name` = '$edit_name' where `id` = '$edit_id' limit 1";
	$result = mysql_query($query);

}

if (mysql_affected_rows()!== 1)
	{
		echo '<p class="error">',"Error - Navigation Failed to Update",mysql_error(),'</p></br>';
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Error - Navigation Failed to Update', 'Error');";
		echo '}); </script>';
		unset($_POST);
	}
else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.success('Navigation Successfully Updated.', '');";
		echo '}); </script>';
		unset($_POST);
	}
		}

?>

<?php
/*------------------------------Move Navorder Up----------------------------*/
if (is_numeric($_REQUEST['moveup_id']))
{
	$id = addslashes($_REQUEST['moveup_id']);
   
	
	$query 	= "select * from `nav` where id='$id' limit 1";
	$result = mysql_query($query) or print mysql_error(); 
	$movemain	= mysql_fetch_assoc($result);
	
	$movemain_parent = $movemain['parent_id'];
	$moveto_nav_order =  $movemain['navorder'] - 1;
	
	$query 	= "select * from `nav` where navorder='$moveto_nav_order' and parent_id='$movemain_parent' limit 1";
	$result = mysql_query($query) or print mysql_error(); 
	$movealt = mysql_fetch_assoc($result);
		

	$movefrom_nav_order = $movealt['navorder'] + 1;
	
		
	if ($moveto_nav_order != 0)
	{
		$id = $movemain['id'];
		$query 	= "update `nav` set `navorder`='$moveto_nav_order' where id='$id' limit 1";
		$result = mysql_query($query);
		$id = $movealt['id'];
		$query 	= "update `nav` set `navorder`='$movefrom_nav_order' where id='$id' limit 1";
		$result = mysql_query($query);
	}
	else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Cannot Move this Item up, its the 1st item', 'Error');";
		echo '}); </script>';
		echo '<p class="error">',"Cannot Move this Item up, its the 1st item",mysql_error(),
			  '</p></br>';
	}
	unset($_REQUEST['moveup_id']);
}
?>

<?php
/*------------------------------Move Navorder Down----------------------------*/
if (is_numeric($_REQUEST['movedown_id']))
{
	$id = addslashes($_REQUEST['movedown_id']);
   
	
	$query 	= "select * from `nav` where id='$id' limit 1";
	$result = mysql_query($query) or print mysql_error(); 
	$movemain	= mysql_fetch_assoc($result);
	
	$movemain_parent = $movemain['parent_id'];
	
	$moveto_nav_order =  $movemain['navorder'] + 1;
	
	
	$query 	= "select * from `nav` where navorder='$moveto_nav_order' and parent_id='$movemain_parent' limit 1";
	$result = mysql_query($query) or print mysql_error(); 
	$movealt = mysql_fetch_assoc($result);
	$movealtrow = mysql_num_rows($result);	
	
	print_r ($movealtrow);
	
	$movefrom_nav_order = $movealt['navorder'] - 1;
	
	
	
	if ($movealtrow > 0)
	{
	$id = $movemain['id'];
	$query 	= "update `nav` set `navorder`='$moveto_nav_order' where id='$id' limit 1";
	$result = mysql_query($query);
	$id = $movealt['id'];
	$query 	= "update `nav` set `navorder`='$movefrom_nav_order' where id='$id' limit 1";
	$result = mysql_query($query);
	}
	else
	{
		echo '<script> $(document).ready(function() {';
		echo "Notifier.error('Cannot Move this Item down, its the last item', 'Error');";
		echo '}); </script>';
		echo '<p class="error">',"Cannot Move this Item down, its the last item",mysql_error(),
			  '</p></br>';
	}
	
	
}
?>

<!-------------------Recursive List of Parent List------------------------------------->
<?php 
// get all menuitems with 1 query 
$result = mysql_query("SELECT * FROM `nav` where level < 3 ORDER BY level, navorder "); 
while ($data = mysql_fetch_assoc($result))
	{
		if ($data['level'] == 2)
		{
			$m22[1][$data['parent_id']]['child'][] = $data;
		}
		else
		{
			$m22[$data['level']][$data['id']]['data'] = $data;
		}
	}
?>

<!------------------Alternate Recursive list for Navigation (TRAIL)------------------------------------->
<?php 
/* get all menuitems with 1 query 
$result = mysql_query("SELECT * FROM `nav` ORDER BY level, navorder "); 
while ($data = mysql_fetch_assoc($result))
	{
		if ($data['level'] == 2)
		{
			$m25[1][$data['parent_id']]['grandchild'][] = $data;
		}
		else if ($data['level'] == 3)
		{
			$m25[2][$data['parent_id']]['child'][] = $data;
		}
		else
		{
			$m25[$data['level']][$data['id']]['data'] = $data;
		}
	}

*/
?>



<!-------------------NAVIGATION.CSS file--------------------------->
<?php
/*Save and Update File*/

if (isset($_POST['updateFile']))
{

$dir = open_dir_ext."css/";
$filename = $dir."navigation.css";
$filedata = stripslashes($_POST['cssInput']);

$fh = fopen($filename, 'w') or die("can't open file");
fwrite($fh, $filedata);
fclose($fh);


unset($_POST);
}

?>


<?php
/*
GET Files to Edit
Open Files to using GET
*/



$dir = open_dir_ext."css/";
$filename = $dir."navigation.css";


$fh = fopen($filename, 'r+') or die("can't open file");

$fileData = fread($fh, filesize($filename));
fclose($fh);

?>


<div class="right-framework">

<br /><br />
<h1>Edit <br />
Navigation</h1>


</div>

<div class="mainContent">


<div class="CMSforms" style="width:30%; float:left; margin-right:30px;">

<div class="formHeader"><img src="../assets/gfx/sub-icon_black.png" width="30" height="30" style="vertical-align:middle; padding-left:5%;"/><span style="vertical-align:middle;">Add Navigation Item</span></div>


<form name="addNav" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-left:15%;">
    <br /><br />
    <label>Name</label><br />
    <input type="text" name="navName" id="UserName" class="inputdesignb" value="<? echo stripslashes($data['username']);?>" 
    required="required" tabindex="9" />
    
    <br /><br /><br />
    <label>Parent Name</label><br />
    <select name="parent_id" tabindex="10"  class="inputdesignb">
    <option value="0">No Parent</option>
   	<?php

		//echo '<option>',print_r($m22),'</option>';
		foreach ($m22[1] as $pid=>$data)
			{
				echo '<option value="',$data['data']['id'],'"';
					echo '>';
					echo stripslashes($data['data']['name']),'</option>';	
					if (is_array($data['child']))
					{
						foreach ($data['child'] as $child)
						{
						echo '<option value="',$child['id'],'"';
						echo '>';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;';
						echo stripslashes($child['name']),'</option>';	
						}
					}
			}
		?>	
    </select>
  	
    <br /><br /><br />
    <label>Link Page</label><br />
    <select name="pageID" tabindex="11" class="inputdesignb">
    <option value=""></option>
   	<?php
		$query="SELECT * FROM `page`";
		$result=mysql_query($query);
		$num=mysql_numrows($result);

		while ($page_data = mysql_fetch_assoc($result)) 
			{
				
				echo '<option value="',$page_data['id'],'"';
				if ($_POST['id'] == $page_data['id'])
					{echo 'selected = "selected"';}
				echo '>',stripslashes($page_data['title']),'</option>';	
			}
		?>	
    </select>
    <!--
    <p>Link Post<br>
    <select name="postID"  tabindex="10" >
    <option value=""></option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    </select>
    </p>
    -->
    
    <br /><br /><br />
    <label>URL | Link</label><br />
    <input type="text" name="url"  value=""  tabindex="14" class="inputdesignb" />

<br /><br /><br />
<input type="submit" name="newNav"  value="Add" class="BUTTONsubmitb" accesskey="s" tabindex="15" style="right:30%;"/>&nbsp;
<input type="reset" name="Clear"  value="Clear" class="BUTTONsubmitb" accesskey="c" tabindex="16" />    
<br />
<br />
<br />
<br />


</form>
</div>

<div class="navEditor">
 <div class="formHeader" style="background:#efefef; color:#1d1d1d;"><img src="../assets/icons/Programming_File_Types/css/css-32.png" width="30" height="30" style="vertical-align:middle; padding-left:2%;"/><span style="vertical-align:middle;">Navigation | Menu Editor</span></div>
<?php 
// get all menuitems with 1 query 
$result = mysql_query("SELECT * FROM nav ORDER BY navorder "); 
?>

<?php 
// prepare special array with parent-child relations 
$menuData = array( 
    'items' => array(), 
    'parents' => array() 
); 

while ($menuItem = mysql_fetch_assoc($result)) 
{ 
    $menuData['items'][$menuItem['id']] = $menuItem; 
    $menuData['parents'][$menuItem['parent_id']][] = $menuItem['id']; 
} 
?>

<?php 
// menu builder function, parent_id 0 is the root 
function buildMenu($parent_id, $menuData) 
{ 
    $html = ''; 

    if (isset($menuData['parents'][$parent_id])) 
    { 
        $html = '<ul>'; 
        foreach ($menuData['parents'][$parent_id] as $itemId) 
        {   
			
			if ($menuData['items'][$itemId]['page_id'] != 0)
			{
				$link_page_id = $menuData['items'][$itemId]['page_id'];
				
				
				$html .= '<li class="table-look"  id="p' .$menuData['items'][$itemId]['id'] .'">';
				$html .= '<a href="#tabs-'.$menuData['items'][$itemId]['id'] .'"></a>';

				$html .= $menuData['items'][$itemId]['name']; 
				$html .= '</a>'; 
				
				$html .= "<script> $(document).ready(function() { $('.toggle".$menuData['items'][$itemId]['id'] 
							."').click(function(){";
				$html .= " $('div.showhide".$menuData['items'][$itemId]['id'] ."').toggle(); }); }); </script>";
				$html .= '<a href="#" class="toggle' .$menuData['items'][$itemId]['id'].'" 
							title="Edit Navigation Item"><img src="../assets/gfx/sub-icon_black.png" width="15" height="15" style="vertical-align:middle; float:left; padding:3px 5px 5px 5px;"/></a>';
				
				
				$html .= '<a class="navDelete" style="right:22%;" href="?moveup_id='.$menuData['items'][$itemId]['id'].'" 
							title="Move Up">&#8743;</a>';
				$html .= '<a class="navDelete" style="right:20%;" href="?movedown_id='.$menuData['items'][$itemId]['id'].'" 
							title="Move Down">&#8744;</a>';
				
				$html .= '<span class="navDelete">Page</span>';
				$html .= '</li>';
				$html .= '<div id="edit-nav" class="showhide'.$menuData['items'][$itemId]['id'].'">';
				$html .= '';
				$html .= '<form name="editNav" action="'.$_SERVER['PHP_SELF'] .'" method="post">';
				$html .= '<label>Navigation Label &nbsp;</label><br />';
				$html .= '<input type="text" name="edit_name" class="inputdesigna" value="'.$menuData['items'][$itemId]['name'].'"/><br /><br />';
				$html .= '<input type="text" name="edit_id" class="invisible" value="'.$menuData['items'][$itemId]['id'].'"/>';
				
				$html .= '</br><i>Page Linked</i> - ';
					$searchid = $menuData['items'][$itemId]['page_id'];
					$query= "SELECT * FROM `page` where id='$searchid'";
					$result= mysql_query($query);
					$page_data = mysql_fetch_assoc($result);
				$html .= $page_data['title'];
				
				$html .= '<br /><br /><br /><input type="submit" name="editNav"  value="Save" class="BUTTONsubmit" accesskey="s" tabindex="15" style="right:2%; bottom:1%;" />';
				$html .= '</br></br> <a style="position:relative; color:#900;" href="?delete_nav_item=' .$menuData['items'][$itemId]['id'];
				$html .='" title="Delete Navigation Item">Delete</a> | ';
				$html .= '<a href="#" class="toggle' .$menuData['items'][$itemId]['id'].'" 
							title="Close Edit">Cancel</a>';
				$html .= '</form>';
				$html .= '</div>';
	            // find childitems recursively 
	            $html .= buildMenu($itemId, $menuData); 
				
		
				
			}
			else if ($menuData['items'][$itemId]['post_id'] != 0)
			{
				$link_page_id = $menuData['items'][$itemId]['page_id'];
				
				
				$html .= '<li class="table-look"  id="p' .$menuData['items'][$itemId]['id'] .'">';
				$html .= '<a href="#tabs-'.$menuData['items'][$itemId]['id'] .'"></a>';

				$html .= $menuData['items'][$itemId]['name']; 
				$html .= '</a>'; 
				
				$html .= "<script> $(document).ready(function() { $('.toggle".$menuData['items'][$itemId]['id'] 
							."').click(function(){";
				$html .= " $('div.showhide".$menuData['items'][$itemId]['id'] ."').toggle(); }); }); </script>";
				$html .= '<a href="#" class="toggle' .$menuData['items'][$itemId]['id'].'" 
							title="Edit Navigation Item"><img src="../assets/gfx/sub-icon_black.png" width="15" height="15" style="vertical-align:middle; float:left; padding:3px 5px 5px 5px;"/></a>';
				
				
				$html .= '<a class="navDelete" style="right:22%;" href="?moveup_id='.$menuData['items'][$itemId]['id'].'" 
							title="Move Up">&#8743;</a>';
				$html .= '<a class="navDelete" style="right:20%;" href="?movedown_id='.$menuData['items'][$itemId]['id'].'" 
							title="Move Down">&#8744;</a>';
				$html .= '<span class="navDelete">Post</span>';
				$html .= '</li>';
				$html .= '<div id="edit-nav" class="showhide'.$menuData['items'][$itemId]['id'].'">';
				$html .= '';
				$html .= '<form name="editNav" action="'.$_SERVER['PHP_SELF'] .'" method="post">';
				$html .= '<label>Navigation Label &nbsp;<br /></label>';
				$html .= '<input type="text" name="edit_name" class="inputdesigna" value="'.$menuData['items'][$itemId]['name'].'"/><br /><br />';
				$html .= '<input type="text" name="edit_id" class="invisible" value="'.$menuData['items'][$itemId]['id'].'"/>';
				
				$html .= '</br><i>Page Linked</i> - ';
					$searchid = $menuData['items'][$itemId]['page_id'];
					$query= "SELECT * FROM `page` where id='$searchid'";
					$result= mysql_query($query);
					$page_data = mysql_fetch_assoc($result);
				$html .= $page_data['title'];
				
				$html .= '<br /><br /><br /><input type="submit" name="editNav"  value="Save" class="BUTTONsubmit" accesskey="s" tabindex="15" style="right:2%; bottom:1%;" />';
				$html .= '</br></br> <a style="position:relative; color:#900;" href="?delete_nav_item=' .$menuData['items'][$itemId]['id'];
				$html .='" title="Delete Navigation Item">Delete</a> | ';
				$html .= '<a href="#" class="toggle' .$menuData['items'][$itemId]['id'].'" 
							title="Close Edit">Cancel</a>';
				$html .= '</form>';
				$html .= '</div>';
	            // find childitems recursively 
	            $html .= buildMenu($itemId, $menuData); 

			}
			else
			{
				
				$link_page_id = $menuData['items'][$itemId]['page_id'];
				
				
				$html .= '<li class="table-look"  id="p' .$menuData['items'][$itemId]['id'] .'">';
				$html .= '<a href="#tabs-'.$menuData['items'][$itemId]['id'] .'"></a>';

				$html .= $menuData['items'][$itemId]['name']; 
				$html .= '</a>'; 
				
				$html .= "<script> $(document).ready(function() { $('.toggle".$menuData['items'][$itemId]['id'] 
							."').click(function(){";
				$html .= " $('div.showhide".$menuData['items'][$itemId]['id'] ."').toggle(); }); }); </script>";
				$html .= '<a href="#" class="toggle' .$menuData['items'][$itemId]['id'].'" 
							title="Edit Navigation Item"><img src="../assets/gfx/sub-icon_black.png" width="15" height="15" style="vertical-align:middle; float:left; padding:3px 5px 5px 5px;"/></a>';
				
				$html .= '<a class="navDelete" style="right:22%;" href="?moveup_id='.$menuData['items'][$itemId]['id'].'" 
							title="Move Up">&#8743;</a>';
				$html .= '<a class="navDelete" style="right:20%;" href="?movedown_id='.$menuData['items'][$itemId]['id'].'" 
							title="Move Down">&#8744;</a>';
				$html .= '<span class="navDelete">Custom</span>';
				$html .= '</li>';
				$html .= '<div id="edit-nav" class="showhide'.$menuData['items'][$itemId]['id'].'">';
				$html .= '';
				$html .= '<form name="editNav" action="'.$_SERVER['PHP_SELF'] .'" method="post">';
				$html .= '<label>Navigation Label &nbsp;<br /></label>';
				$html .= '<input type="text" name="edit_name" class="inputdesigna" value="'.$menuData['items'][$itemId]['name'].'"/><br /><br />';
				$html .= '<input type="text" name="edit_id" class="invisible" value="'.$menuData['items'][$itemId]['id'].'"/>';
				
				$html .= '</br><label><i>URL</i></label> - ';
				$html .= '<input type="text" name="edit_url" class="inputdesignb" style="color:#1d1d1d;" value="'.$menuData['items'][$itemId]['link'].'"/>';
				
				$html .= '<br /><br /><br /><input type="submit" name="editNav"  value="Save" class="BUTTONsubmit" accesskey="s" tabindex="15" style="right:2%; bottom:1%;" />';
				$html .= '</br></br> <a style="position:relative; color:#900;" href="?delete_nav_item=' .$menuData['items'][$itemId]['id'];
				$html .='" title="Delete Navigation Item">Delete</a> | ';
				$html .= '<a href="#" class="toggle' .$menuData['items'][$itemId]['id'].'" 
							title="Close Edit">Cancel</a>';
				$html .= '</form>';
				$html .= '</div>';
	            // find childitems recursively 
	            $html .= buildMenu($itemId, $menuData); 
			
			}
        } 
        $html .= '</ul>'; 
		
    } 

    return $html; 
} 

// output the menu 
echo buildMenu(0, $menuData); 




?>
</div>

<div style="clear:both;"></div>
<br />
<hr />
<?php
		
		$name = stripslashes('navigation');
		$query = "select * from `scripts` where name='$name' limit 1";
		$result = mysql_query($query);	
		
		$dataCSS = mysql_fetch_assoc($result);
		
	
?>
<h2 align="left">Edit <?php echo $fileName; ?></h2>
<div style="height:30%; padding-bottom:5%;  background:#696969;">
        <div class="formHeader" style="background:#efefef; color:#1d1d1d;"><img src="../assets/icons/Programming_File_Types/css/css-32.png" width="30" height="30" style="vertical-align:middle; padding-left:2%;"/><span style="vertical-align:middle;">Navigation Stylesheet</span></div>
<form name="updateFile" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
<input name="filename" class="invisible" value="<?php echo $fileName;?>"/>
<textarea name="cssInput" id="code"> <? echo  $fileData;?></textarea>
<br />
<input type="submit" name="updateFile"  value="Update" class="BUTTONsubmit" accesskey="s" tabindex="15" style="position:absolute; z-index:1000;">&nbsp;
</form>
</div>

<script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {});
</script>




<!----------------Trial Navigation list---------------->

<?php /*
		echo '<pre>';
		print_r($m25);
		echo '</pre>';
		echo '<form>';
		echo '<select>';
		foreach ($m25[2] as $pid=>$data)
			{
				echo '<option value="',$data['data']['id'],'"';
					echo '>';
					echo stripslashes($data['data']['name']),'</option>';	
					if (is_array($data['child']))
					{
						foreach ($data['child'] as $child)
						{
						echo '<option value="',$child['id'],'"';
						echo '>';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;';
						echo stripslashes($child['name']),'</option>';	
						if (is_array($data['grandchild']))
						{
							foreach ($data['grandchild'] as $grandchild)
							{
								echo '<option value="',$grandchild['id'],'"';
								echo '>';
								echo '&nbsp;&nbsp;&nbsp;&nbsp;';
								echo stripslashes($grandchild['name']),'</option>';	
							}
						}
						}
					}
			}
*/?>	
</div><!--mainContent-->

<?php 
	
		ini_set ('display_errors',1);

		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>