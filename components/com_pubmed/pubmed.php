<?php

defined ( '_JEXEC') or die ('Restricted access');

require_once( JPATH_COMPONENT.DS.'controller.php' );
// JTable::addIncludePath (JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'tables');

$controller = new PubmedController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect();

?>