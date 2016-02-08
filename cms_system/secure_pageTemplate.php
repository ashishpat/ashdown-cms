<?php 
	
require('../session.php');

/*****************Extra Javascripts****************/	
$_extrajs .= <<<eof
 $( "#dialog" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#opener" ).click(function() {
      $( "#dialog" ).dialog( "open" );
    });

    });
eof;
/****************End Javascripts*******************/

require('../headerSecure.php'); 
require('../header.php'); 	
?>
<div id="dialog" title="Basic dialog">
  <p>This is an animated dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>


<div class="right-framework">
</div>


<div class="mainContent">


<button id="opener">Open Dialog</button>

<div style="clear:both;"></div>
</div> <!----MainContent--->

<?php 
		/********Footer*******/
		ini_set ('display_errors',1);
		error_reporting (E_ALL & ~E_NOTICE);
	    include('../footer.php'); 
?>