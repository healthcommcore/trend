<?php

defined ( '_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.view');
class PubmedViewSearch extends JView
{
	function display( $tpl = null)
	{
		global $option, $mainframe;
		$searchTopics = JRequest::getVar( 'searchTopics', null);
		$searchKey = JRequest::getVar( 'searchKey');
		$itemid = JRequest::getVar( 'Itemid');
		
		$errMsg="";
		
		// Search Bibliography
		$resultsFound="";
		if (JRequest::getVar( 'submitAction') =="searchBib") {
			if (strlen(trim($searchKey))<1) $errMsg="Please enter search keyword(s)."; 
			if (strlen($errMsg)<1) {
				// $mysqlID=dbConnect();
				
				$db =& JFactory::getDBO();	

				$query="SELECT * FROM jos_bibliography WHERE (summary LIKE \"%".addslashes($searchKey)."%\")";
				$db->setQuery( $query);

				// if ($resultID) {
				
				if ( $db->query()) {
					if ( $db->getNumRows() >0) {
						// echo $db->getNumRows() . " rows found";
						$bibSpecs = $db->loadAssocList();
					} else {
						$errMsg="No references were found containing the text: <b><i>".addslashes($searchKey)."</i></b>";
					}
				}
			}
		}

		if (JRequest::getVar( 'submitAction') =="searchBib2") {
			if ($searchTopics) {
				$whereClause="";
				while (list($k,$v)=each($searchTopics)) {
					if (strlen($whereClause)<1) {
						$whereClause=" (";
					} else {
						$whereClause.=" AND ";
					}
					$whereClause.="(topicIDs LIKE \"%|".$k."|%\")";
				}
				$whereClause.=")";
				$db =& JFactory::getDBO();	
				// $resultID=mysql_query("SELECT * FROM bibliography WHERE ".$whereClause,$mysqlID);
				$query="SELECT * FROM jos_bibliography WHERE ".$whereClause;
				$db->setQuery( $query);
				

				if ( $db->query()) {

					if ( $db->getNumRows() >0) {
						// echo $db->getNumRows() . " rows found";
						$bibSpecs = $db->loadAssocList();
					
					} else {
						$errMsg="No references were found matching the topics selected.";
					}
				}
			} else {
				$errMsg="Please select a topic.";
			}
		}

		
		
		$this->assignRef('searchKey', $searchKey);
		$this->assignRef('searchTopics', $searchTopics);
		$this->assignRef('errMsg', $errMsg);
		$this->assignRef('itemid', $itemid);
		$this->assignRef('bibSpecs', $bibSpecs);

		$this->assignRef('option', $option);
		parent::display($tpl);
	}


}