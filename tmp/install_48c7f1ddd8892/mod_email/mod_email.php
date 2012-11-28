<?php
/**
* @version 1.0 $
* @package Ad
* @copyright (C) 2005 Andrew Eddie
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
 
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted Access.' );
require_once( JPATH_SITE .'/modules/mod_quiz/mod_quiz.html.php' );
?>

<script language="javascript" type="text/javascript">
function processQuiz(form) {
	var flag = false;
	for (var i=0; i < form.question1.length; i++){
		if (form.question1[i].checked) flag = true;
	}
	
	if (flag == false) {
		alert ('Please answer all questions');
		return flag;
	}
	flag = false;
	for (var i=0; i < form.question2.length; i++){
		if (form.question2[i].checked) flag = true;
	}
	if (flag == false) {
		alert ('Please answer all questions');
		return flag;
	}
	flag = false;

	for (var i=0; i < form.question3.length; i++){
		if (form.question3[i].checked) flag = true;
	}
	if (flag == false) {
		alert ('Please answer all questions');
		return flag;
	}
	flag = false;

	for (var i=0; i < form.question4.length; i++){
		if (form.question4[i].checked) flag = true;
	}
	if (flag == false) {
		alert ('Please answer all questions');
		return flag;
	}
	return true;
}
</script>


<?php

// Retrieve page params so we can reconstruct it
global $option;
global $view;
global $itemid;
global $id;
global $task;

// Retrieve URL parameters
// Joomla
$option = trim( JRequest::getVar(  'option'));
$id = trim( JRequest::getVar(  'id'));
$itemid = trim( JRequest::getVar(  'Itemid'));
$view = trim( JRequest::getVar(  'view', null));
$task = trim( JRequest::getVar(  'task', null));
$errmsg = JRequest::getVar( 'errmsg', '');

echo "task=$task";

switch ($task) {
	case 'score':
		// place in helper code?
	
		$values = array();	// will hold results for values[1..3]
		
		$answers[] = JRequest::getVar( 'question1', 0);
		$answers[] = JRequest::getVar( 'question2', 0);
		$answers[] = JRequest::getVar( 'question3', 0);
		$answers[] = JRequest::getVar( 'question4', 0);
		
		// print_r($answers);
		foreach ( $answers as $key => $answer) {
			if ($answer == 0) {
			
			// Error handling?	May  need to be done differently - 
				$mainframe->redirect('index.php?option='. $option . '&view='. $view.'&id='.$id. '&Itemid='. $itemid.'&errmsg=true','');
				exit();
			}
			$values[$answer]++;
			// echo 'Question ...  answer = '. $answer;
		}
	
        HTML_quiz::scoreQuizQuestions( $values);
		break;
	case '':
	default:
        HTML_quiz::displayQuizQuestions();
}
?>


