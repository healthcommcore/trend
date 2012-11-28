<?php

defined ( '_JEXEC') or die ('Restricted access');

class TablePubmed extends JTable

{
	var $id = null;
	var $summary = null;
	var $topicIDs = null;
	
	function __construct (&$db)
	{
		parent::__construct ( '#__bibliography', 'id', $db);
	}
}
?>