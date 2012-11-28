              <?php
defined( '_JEXEC' ) or die( 'Restricted Access.' );


/**
* @version 1.0 $
* @package Email
*/
 
require_once( JPATH_SITE .'/components/com_email/email.html.php' );
?>

<script language="javascript" type="text/javascript">

function isBlank(val) {
	if (val == null || val == "") return true;
	for(var i=0;i<val.length;i++) {
		if ((val.charAt(i)!=' ')&&(val.charAt(i)!="\t")&&(val.charAt(i)!="\n")&&(val.charAt(i)!="\r")){return false;}
		}
	return true;
		
}

function processEmail(form) {
	var msg = "Please specify ";
	 	
			
	if (isBlank(form.mm_email.value)) {
		msg += "your email\n";
	} 

	if (isBlank(form.mm_subject.value)) {
		msg += "the subject\n";
	} 

	if (isBlank(form.mm_message.value)) {
		msg += "your message\n";
	} 
		
	if (msg != "Please specify ") {
		alert(msg);
		return false;	
	}
	else	return true;

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

// Function formatmsg($message)
// Argument: $message
//
// Reformat messages so that max # chars per line (\n separator) in email is about 70 chars
// Use blank as word separator (for simplicity) - replace with \n as necessary
// Returns: new formatted string
function formatmsg($message) {
		$words = explode(' ', $message); // each entry in array $words is a word from the string
		$retmsg = "";
		$linechars = 0;			// start with first char
		foreach($words as $word)
		{
			// Keep blanks, newlines as in original
			// Check to see if there are any newlines in the text, starting from the END
			if ( ($pos = strrpos($word, "\n")) != false) {
				$linechars = strlen($word-$pos);	// new start
				$retmsg .= ' '.$word;
			}
			else if (($linechars + strlen($word)) > 70 ) {
				// line too long, insert newline
				$retmsg .= "\n".$word;	
				$linechars = 0;
			}
			else {
				$linechars += (strlen($word) +1);	// add space
				if ($retmsg != '') $retmsg .= ' '.$word;
				else $retmsg = $word;
			}
		}
		return $retmsg; // return the new string
}

// Function sendemail()
// Arguments:
//	$toemails:
//	$fromemail:
//	$subject:
//	$message:
// Returns mail() status
function sendemail( $toemails, $fromemail, $subject, $message) {



		$message = formatmsg($message);
		$old_level = error_reporting(0);	// turn off email error reporting
		$status = mail ($toemails, 'Trend feedback:'. $subject, $message, 'From:'.$fromemail);
		error_reporting($old_level);
		return $status;
}


switch ($task) {
	case 'send':
		// place in helper code?
	
		$values = array();	// will hold results for values[1..3]
		
		$mm_email = trim(JRequest::getVar( 'mm_email', 0));
		$mm_subject = trim(JRequest::getVar( 'mm_subject', 0));
		$mm_message = trim(JRequest::getVar( 'mm_message', 0));
		
		if (  ( $mm_email == '') || ( $mm_subject == '') || ( $mm_message == '') ) {
			
	        HTML_email::displayEmail('Please complete all the fields in the form');
			break;
		}

		$toemails = 'trend_feedback@DFCI.HARVARD.EDU'; 


		$status = sendemail( $toemails, $mm_email, $mm_subject, $mm_message);
		if ($status) $sendemail_msg = "Your email has been sent. Thank you for your feedback.";
		else $sendemail_msg = "There was an error. Your email was not sent.";

	
        HTML_email::sendEmail($sendemail_msg);
		break;
	case '':
	default:
        HTML_email::displayEmail($errmsg);
}
?>


