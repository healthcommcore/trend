<?php
/**
* @version $Id: jceutilities.php 2008-01-07 $
* @package JCEUtilites
* @copyright Copyright (C) 2006/2007/2008 Ryan Demmer. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin');

/**
* JCE Utiltiies Plugin
*
* @package 		JCE Utilities
* @subpackage	System
*/
class plgSystemJCEUtilities extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param	object		$subject The object to observe
	 * @param 	array  		$config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemJCEUtilities(&$subject, $config)  {
		parent::__construct($subject, $config);
		
		// load plugin parameters
        $this->_plugin = JPluginHelper::getPlugin( 'system', 'jceutilities' );
        $this->_params = new JParameter( $this->_plugin->params );
	}
	
	function renderParams( $name, $params, $end ){
		$html = '';
		if( $name ){
			$html .= "'". $name ."':{";
		}
		$i = 0;
		foreach( $params as $k => $v ){
			if( !is_numeric( $v ) ){
				$v = '"'. $v .'"';
			}
			if( $i < count( $params ) -1 ){
				$v .= ',';
			}
			$html .= "'". $k ."':". $v;
			$i++;
		}
		if( $name ){
			$html .= "}";
		}
		if( !$end ){
			$html .= ",";
		}
		return $html;
	}
	
	function onAfterInitialise(){
		global $mainframe;

		if ($mainframe->isAdmin()) {
			return;
		}
		
		$db =& JFactory::getDBO();
		
		$pop 	= JRequest::getVar( 'pop', 0, 'int' );
		$task 	= JRequest::getVar( 'task' );
		
		if( $pop || ( $task == 'new' || $task == 'edit' ) ){
			return;
		}
		$params = $this->_params;	
		
		$components = $params->get('components', '');
		if( $components ){
			$excluded 	= explode( ',', $components );
			$option 	= JRwquest::getVar( 'option', '' );
			foreach( $excluded as $exclude ){
				if( $option == 'com_'. $exclude || $option == $exclude ){
					return;
				}
			}
		}		
		$query = "SELECT published"
		. "\n FROM #__plugins"
		. "\n WHERE element = 'jceembed'"
		. "\n AND folder = 'system'"
		;
		$db->setQuery( $query );
		$embed = $db->loadResult();
		
		$lightbox = array(
			'legacy'			=>	$params->get( 'legacy', '0' ),
			'convert'			=>	$params->get( 'convert', '0' ),
			'resize'			=>	$params->get( 'resize', '1' ),
			'icons'				=>	$params->get( 'icons', '1' ),
			'overlay'			=>	$params->get( 'overlay', '1' ),
			'overlayopacity'	=>	$params->get( 'overlayopacity', '0.8' ),
			'overlaycolor'		=>	$params->get( 'overlaycolor', '#000000' ),
			'fadespeed'			=>	$params->get( 'fadespeed', '500' ),
			'scalespeed'		=>	$params->get( 'scalespeed', '500' )
		);
		$tooltip = array(
			'classname'			=>	$params->get( 'tipclass', 'tooltip' ),
			'opacity'			=>	$params->get( 'tipopacity', '1' ),
			'speed'				=>	$params->get( 'tipspeed', '150' ),
			'position'			=>	$params->get( 'tipposition', 'br' ),
			'offsets'			=>	"{'x': ". $params->get( 'tipoffsets_x', '16' ) .", 'y': ". $params->get( 'tipoffsets_y', '16' ) ."}"
		);
		$standard = array(
			'imgpath'			=>	$params->get( 'imgpath', 'plugins/system/jceutilities/img/' ),
			'pngfix'			=>	$params->get( 'pngfix', '1' )
		);
			
		$document =& JFactory::getDocument();
		
		$document->addScript( JURI::base() . 'plugins/system/jceutilities/js/jquery-123.js' );
		$document->addScript( JURI::base() . 'plugins/system/jceutilities/js/jceutilities-160.js' );
		if( !$embed ){
			$document->addScript( JURI::base() . 'plugins/system/jceutilities/js/embed.js' );
		}
		$document->addStyleSheet( JURI::base() . 'plugins/system/jceutilities/css/jceutilities-160.css' );
		
		$html = "\tvar jcexhtmlembed=". $params->get('embedstrict', '1') .";";
		$html .= "jQuery(document).ready(function(){";
		$html .= "jceutilities({";
		$html .= $this->renderParams( 'lightbox', $lightbox, false );
		$html .= $this->renderParams( 'tootlip', $tooltip, false );
		$html .= $this->renderParams( '', $standard, true );
		$html .= "});";
		$html .= "});";
						
		$document->addScriptDeclaration( $html );
		return true;
	}	
}
?>