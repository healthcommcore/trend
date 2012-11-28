<?php

defined ( '_JEXEC') or die ('Restricted access');
jimport('joomla.application.component.controller');
class PubmedController extends JController
{
	// display() function called by default

	function display()
	{
		$document =& JFactory::getDocument();
		
		// Requested view - default 'all'
		$viewName = JRequest::getVar( 'view', 'search');
		
		// Multiple document type - default 'HTML'. Others may be RSS
		//$viewType = $document::getType();	-> run-time error???
		// $view = &$this->getView($viewName, $viewType);
		$view = &$this->getView($viewName,'HTML');
		/*
		$model =& $this->getModel($viewName, 'ModelBios');
		
		// Check that model exists
		if (!JError::isError( $model)) {
			$view->setModel( $model, true);
			// die('no model');
		}
		*/
		// set layout - default 'default'

		$view->setLayout('default');
		$view->display();
		
	}

/*
	function score ( $tpl = null)
	{
		global $option, $mainframe;
		$viewName = JRequest::getVar( 'view', 'score');
		$view = &$this->getView($viewName,'HTML');
		$view->setLayout('default');
		$view->display();
		// $viewName = JRequest::getVar( 'view', 'check');
		// $model = &$this->getModel();
		
		// $bio = $model->getBio();
		
		
		//$pathway =& $mainframe->getPathWay();	// breadcrumbs
		
		// If want link to list of all recipes
		// $backlink = JRoute::_('index.php?option='. $option . '&view=all');
		
		
		// $this->assignRef('bio', $bio);
		// $this->assignRef('backlink', $backlink);
		// $this->assignRef('option', $option);
		// parent::display($tpl);
	}
	*/

}

?>
