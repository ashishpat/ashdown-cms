<div style="clear:both;"></div>
<div id="menu">
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
				$html .= '<a href="index.php?pid='. $link_page_id;
            	$html .= '">';
				$html .= '<li>'. $menuData['items'][$itemId]['name']; 
				$html .= '</a>'; 
				$html .= '';
	            // find childitems recursively 
	            $html .= buildMenu($itemId, $menuData); 

    	        $html .= '</li>' ;
				
			}
			else if ($menuData['items'][$itemId]['post_id'] != 0)
			{
				$html .= '<a href="#='.$menuData['items'][$itemId]['post_id'];
	            $html .= '">';
				$html .= '<li>'. $menuData['items'][$itemId]['name']; 
				$html .= '</a>'; 
				$html .= '';
	            // find childitems recursively 
    	        $html .= buildMenu($itemId, $menuData); 

        	    $html .= '</li>' ;
				
			}
			else
			{
				$html .= '<a href="'.$menuData['items'][$itemId]['link'];
    	        $html .= '">';
				$html .= '<li>'. $menuData['items'][$itemId]['name']; 
				$html .= '</a>'; 
				$html .= '';
            	// find childitems recursively 
	            $html .= buildMenu($itemId, $menuData); 
	
    	        $html .= '</li>' ;
				
				
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

