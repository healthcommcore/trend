<?php
/**
* @version 1.0 $
* @package Ad
* @copyright (C) 2005 Andrew Eddie
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
 
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted Access.' );


class HTML_quiz {
	function displayQuizQuestions ($errmsg ) {
	global $option;
	global $view;
	global $itemid, $id;
		
		if ($errmsg != '') {
			echo '<h4>Please answer all questions</h4>';
		}

		?>
<div>
<p class="contentheading"> What's your style?
</p>
<?php
// Fix URL => current option/id
		echo '<form action="index.php?option='. $option. '&view='. $view.'&task=score&id='.$id. '&Itemid='. $itemid.'" method="post" name="quiz" onSubmit="return processQuiz (this)">'; 
        ?>
<h4>1. Why you want to eat fruits and vegetables</h4>
<input name="question1" value="1" type="radio">
(a) I want to lose weight.<br>
<input name="question1" value="2" type="radio">
(b) I want to set a good example for my kids.<br>
<input name="question1" value="3" type="radio">
(c) I want to get more vitamins and minerals.

<h4>2. Why you want to eat fruits and vegetables</h4>
<input name="question2" value="1" type="radio">
(a) I want to lose weight.<br>
<input name="question2" value="2" type="radio">
(b) I want to set a good example for my kids.<br>
<input name="question2" value="3" type="radio">
(c) I want to get more vitamins and minerals.

<h4>3. Why you want to eat fruits and vegetables</h4>
<input name="question3" value="1" type="radio">
(a) I want to lose weight.<br>
<input name="question3" value="2" type="radio">
(b) I want to set a good example for my kids.<br>
<input name="question3" value="3" type="radio">
(c) I want to get more vitamins and minerals.

<h4>4. Why you want to eat fruits and vegetables</h4>
<input name="question4" value="1" type="radio">
(a) I want to lose weight.<br>
<input name="question4" value="2" type="radio">
(b) I want to set a good example for my kids.<br>
<input name="question4" value="3" type="radio">
(c) I want to get more vitamins and minerals.

<p></p>
<?php
			echo '<input class="trackreadon right" type="submit" value="Submit">';
		
?>
</div>
	
		<?php	
	}
	
	function scoreQuizQuestions ( $values) {
	
	?>
	
  <p class="contentheading">What's your style Score</p>
  <p>
  
  <?php 
		// Totals
		$top1 = $top2 = 0;
	
		print_r($values);
		foreach ($values as $response => $quantity) {
				// If any = 0, then 2 sets of 2
				if ($quantity == 0) {
					?>
					<p>You circled two sets</p>
					
					<?php
					break;
				}
				if ($quantity >= 2) {
					switch ($response) {	
	
						case  1: 
							?>
							<p>You circled mostly A's</p>
							
							<?php
							break;
											
						case  2: 
							?>
							<p>You circled mostly B's</p>
							
							<?php
							break;
		
						case  3: 
							?>
							<p>You circled mostly C's</p>
							
							<?php
							break;
						default:
					}					
					break;
				}
		}	// end foreach	
  
  ?> 
  </p>
	
	<?php
	}	// end function
} // end class
