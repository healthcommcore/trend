<?php
/**
* @copyright (C) 2006 by Azrul Rahim - All rights reserved!
* @license http://www.azrul.com Copyrighted Commercial Software
**/
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.'); 

/* CMS Compatibilities */
if(cmsVersion() == _CMS_JOOMLA10 || cmsVersion() == _CMS_MAMBO){
	class menujomcomment {
	    function CONFIG_MENU() {
	    mosMenuBar::startTable();
	    mosMenuBar::save( 'savesettings', 'Save' );
	    mosMenuBar::back();
	    mosMenuBar::spacer();
	    mosMenuBar::endTable();
	  }

	   function FILE_MENU() {
	    mosMenuBar::startTable();
	    mosMenuBar::save();
	    mosMenuBar::cancel();
	    mosMenuBar::spacer();
	    mosMenuBar::endTable();
	  }

	  function ABOUT_MENU() {
	    mosMenuBar::startTable();
	    mosMenuBar::back();
	    mosMenuBar::spacer();
	    mosMenuBar::endTable();
	  }

	  function STATS_MENU() {
	    mosMenuBar::startTable();
	    mosMenuBar::back();
	    mosMenuBar::spacer();
	    mosMenuBar::endTable();
	  }

	  function IMPORT_MENU() {
	    mosMenuBar::startTable();
	    mosMenuBar::back();
	    mosMenuBar::spacer();
	    mosMenuBar::endTable();
	  }

	  function TRACKBACK_MENU() {
	    mosMenuBar::startTable();
	    mosMenuBar::publish('publish_tb', 'Publish');
	    mosMenuBar::unpublish('unpublish_tb', 'Unpublish');
	    mosMenuBar::deleteList('', 'remove_tb', 'Remove');
	    mosMenuBar::endTable();
	  }

	  function MENU_Default() {
	    mosMenuBar::startTable();
	    mosMenuBar::publish();
	    mosMenuBar::unpublish();
	    mosMenuBar::deleteList();
	    mosMenuBar::endTable();
	  }
	}
}else if(cmsVersion() == _CMS_JOOMLA15){
	#CMS Version is Joomla1.5
	class menujomcomment {
	    function CONFIG_MENU() {
	    JToolBarHelper::save( 'savesettings', 'Save' );
	    JToolBarHelper::back();
	    JToolBarHelper::spacer();
	  }

	   function FILE_MENU() {
	    JToolBarHelper::save();
	    JToolBarHelper::cancel();
	    JToolBarHelper::spacer();
	  }

	  function ABOUT_MENU() {
	    JToolBarHelper::back();
	    JToolBarHelper::spacer();
	  }

	  function STATS_MENU() {
	    JToolBarHelper::back();
	    JToolBarHelper::spacer();
	  }

	  function IMPORT_MENU() {
	    JToolBarHelper::back();
	    JToolBarHelper::spacer();
	  }

	  function TRACKBACK_MENU() {
	    JToolBarHelper::publish('publish_tb', 'Publish');
	    JToolBarHelper::unpublish('unpublish_tb', 'Unpublish');
	    JToolBarHelper::deleteList('', 'remove_tb', 'Remove');
	  }

	  function MENU_Default() {
	    JToolBarHelper::publish();
	    JToolBarHelper::unpublish();
	    JToolBarHelper::deleteList();
	  }
	}
}
/* End CMS Compatibilities */

