<?php
/**
* @version 1.0 $
* @package Ad
* @copyright (C) 2008 Therese Lung DFCI/CCBR/HCC
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
 
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted Access.' );


class HTML_email {
	function displayEmail ($errmsg ) {
	global $option;
	global $view;
	global $itemid, $id;
		
		if ($errmsg != '') {
			echo"<h4 style='color:red'>$errmsg</h4>";
		}

		?>
<div id="pagecolor">
<h1>Send us feedback</h1>
<p>All fields are required</p>
<?php
// Fix URL => current option/id
		echo '<form action="index.php?option='. $option. '&view='. $view.'&task=send&id='.$id. '&Itemid='. $itemid.'" method="post" name="email" onSubmit="return processEmail (this)">'; 
        ?>
<form>
<table>
<tbody>
<tr>
<td class="key"><label for="mm_email">Your email:</label></td>
<td><input class="inputbox" name="mm_email" id="mm_email" value="" size="50" type="text" /></td></tr>
<tr>
<td class="key"><label for="mm_subject">
Subject:</label></td>
<td><input class="inputbox" name="mm_subject" id="mm_subject" value="" size="50" type="text" /></td></tr>
<tr>
<td class="key" valign="top"><label for="mm_message">
Message:</label></td>
<td id="mm_pane"><textarea rows="20" cols="50" name="mm_message" id="mm_message" class="inputbox"></textarea></td></tr></tbody></table><!--a href="" title="" class="readon" >Send email</a-->
<input class="readon" style="float: right" type="submit" value="Send email"></form>
</div>
	
		<?php	
	}
	
	function sendEmail ($sendemail_msg) {
	
	?>
	<p class="contentheading">Send us feedback</p>
	
  <h4><?php echo $sendemail_msg ?></h4>
  <p>
  
  </p>
	
	<?php
	}	// end function
} // end class
