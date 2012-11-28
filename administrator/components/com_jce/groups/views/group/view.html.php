<?php
/**
* @version		$Id: view.html.php 9764 2007-12-30 07:48:11Z ircmaxell $
* @package		Joomla
* @subpackage	Config
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Plugins component
 *
 * @static
 * @package		Joomla
 * @subpackage	Plugins
 * @since 1.0
 */
class GroupsViewGroup extends JView
{
	function display( $tpl = null )
	{
		global $option;

		require_once( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_jce' .DS. 'groups' .DS. 'helper.php' );
		
		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();

		$cid 	= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger( $cid, array(0) );

		$lists 	= array();		
		$row 	=& JTable::getInstance('groups', 'JCETable');
		
		// load the row from the db table
		$row->load( $cid[0] );
			
		// fail if checked out not by 'me'

		if( $row->isCheckedOut( $user->get('id') ) ){
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The Group' ), $row->name );
			$this->setRedirect( 'index.php?option='. $option .'&type=group', $msg, 'error' );
			return false;
		}

		// load the row from the db table
		if( $cid[0] ){
			$row->checkout( $user->get('id') );	
			$selected = explode( ',', $row->types );						
		}else{
			$query = 'SELECT COUNT(id)'
			. ' FROM #__jce_groups'
			;
			$db->setQuery( $query );
			$total = $db->loadResult();			
			
			$row->name 			= '';
			$row->description 	= '';
			$row->users			= '';
			$row->types			= '';
			$row->rows			= '';
			$row->plugins		= '';
			$row->published 	= 1;
			$row->ordering		= 0;
			$row->params 		= '';
				
			$selected = '';
		}	
		
		// build the html select list for ordering
		$query = 'SELECT ordering AS value, name AS text'
			. ' FROM #__jce_groups'
			. ' WHERE published = 1'
			. ' AND ordering > -10000'
			. ' AND ordering < 10000'
			. ' ORDER BY ordering'
		;
		$order = JHTML::_('list.genericordering',  $query );
		$lists['ordering'] = JHTML::_('select.genericlist',   $order, 'ordering', 'class="inputbox" size="1"', 'value', 'text', intval( $row->ordering ) );

		
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $row->published );
		
		$query = 'SELECT types'
		. ' FROM #__jce_groups'
		// Exclude ROOT, USERS, Super Administrator, Public Frontend, Public Backend
		. ' WHERE id NOT IN (17,28,29,30)'
		;
		$db->setQuery( $query );
		$types = $db->loadResultArray();
		
		// get list of Groups for dropdown filter
		$query = 'SELECT id AS value, name AS text'
		. ' FROM #__core_acl_aro_groups'
		// Exclude ROOT, USERS, Super Administrator, Public Frontend, Public Backend
		. ' WHERE id NOT IN (17,28,29,30)'
		;
		$db->setQuery( $query );
		$types = $db->loadObjectList();
		
		$i = '-';
		$options[] = JHTML::_('select.option', '0', JText::_( 'Guest' ) );
		foreach( $types as $type ){
			$options[] = JHTML::_('select.option', $type->value, $i . JText::_( $type->text ) );
			$i .= '-';
		}
		$lists['types'] = JHTML::_('select.genericlist', $options, 'types[]', 'class="inputbox levels" size="8" multiple="multiple"', 'value', 'text', $selected );
		
		$options 	= array();
		if( $row->id ){
			$query = 'SELECT id as value, username as text'
			. ' FROM #__users'
			. ' WHERE id IN ('.$row->users.')'
			;
			
			$db->setQuery( $query );
			$gusers = $db->loadObjectList();
			if( $gusers ){
				foreach( $gusers as $guser ){
					$options[] = JHTML::_('select.option', $guser->value, $guser->text );
				}
			}	
		}
		$lists['users'] = JHTML::_('select.genericlist', $options, 'users[]', 'class="inputbox users" size="10" multiple="multiple"', 'value', 'text', '' );
				
		// get params definitions
		$xmlPath = JPATH_PLUGINS .DS. 'editors' .DS. 'jce' .DS. 'libraries' .DS. 'xml' .DS. 'groups' .DS. 'editor.xml';
		$params = new JParameter( $row->params, $xmlPath );
		
		$rows = str_replace( ';', ',', $row->rows );
		
		$query = 'SELECT *'
		. ' FROM #__jce_plugins'
		. ' WHERE published = 1'
		;
		
		$db->setQuery( $query );
		$plugins = $db->loadObjectList();
				
		$editor 			=& JPluginHelper::getPlugin('editors', 'jce');
 		$editor_params 		= new JParameter( $editor->params );
		
		$layout['width'] 	= $editor_params->get( 'width', '600' );
		$layout['height'] 	= $editor_params->get( 'height', '600' );
		$layout['rows'] 	= intval( $editor_params->get( 'layout_rows', 5 ) );
		
		$this->assignRef('layout', 		$layout);			
		$this->assignRef('lists',		$lists);
		$this->assignRef('group',		$row);
		$this->assignRef('params',		$params);
		$this->assignRef('plugins',		$plugins);

		parent::display($tpl);
	}
}