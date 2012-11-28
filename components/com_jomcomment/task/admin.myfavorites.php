<?php
/**
 * @copyright (C) 2007 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license http://www.azrul.com Copyrighted Commercial Software
 *
 * Rem:
 * This file is to perform the execution of displaying favorites from a specific user.
 **/
global $_JC_CONFIG, $mainframe;

$cms    =& cmsInstance('CMSCore');
$cms->load('libraries', 'user');

// Only valid user should have access
if(!$cms->user->id){
	echo  'Access to this location is not allowed.';
	return;
}
include_once($cms->get_path('plugins') . '/system/pc_includes/template.php');

$template   = new AzrulJXTemplate();

// Load the trunchtml library
$cms->load('libraries', 'trunchtml');

// Load helper functions
$cms->load('helper', 'url');

$limitstart = cmsGetVar('limitstart', '', 'GET');
$limit      = $limitstart ? "LIMIT $limitstart, " . JC_DEFAULT_LIMIT : 'LIMIT ' . JC_DEFAULT_LIMIT;

// SQL Queries
$strSQL = "SELECT * "
		. "FROM #__jomcomment_fav "
		. "WHERE `userid`='{$cms->user->id}'";

// Execute SQL Query & grab data
$cms->db->query($strSQL);
$favorites  = $cms->db->get_object_list();

for($i =0; $i < count($favorites); $i++){
	$row    =& $favorites[$i];
	
    if($row->option == 'com_content'){
		$row->ItemId	= $mainframe->getItemid($row->contentid);
		$row->task      = 'task=view';
	}
	elseif($row->option == 'com_myblog'){
	    // Get MyBlog itemid
	    $row->ItemId	= jcGetMyBlogItemid();
	    
	    // Get permalinks.
		$strSQL         = "SELECT `permalink` FROM #__myblog_permalinks WHERE `contentid`='$row->contentid'";
		$cms->db->query($strSQL);
	    $row->task      = 'show=' . $cms->db->get_value();
	}
	else{
	    #Other content items?
	    $row->task      = 'task=view';
	}
}

// Prepare pagination
$cms->load('libraries', 'pagination');

// Initialize some configurations
$config = array();

$cms->db->query("SELECT count(*) FROM #__jomcomment_fav WHERE `userid`='{$cms->user->id}'");

// Set some configurations so that we can initialize the paginations
$config['total_rows']	= $cms->db->get_value();
$config['base_url']		= $_SERVER['REQUEST_URI'];
$config['per_page']		= JC_DEFAULT_LIMIT;

$cms->pagination->initialize($config);

$template->set('jcitemid', jcGetItemID());
$template->set('pagination', $cms->pagination->create_links());
$template->set('favorites', $favorites);
echo $template->fetch(JC_TEMPLATE_PATH . '/admin/favorites.html');
return;
?>