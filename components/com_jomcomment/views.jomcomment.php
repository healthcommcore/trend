<?php

/**
 * Jom Comment 
 * @package JomComment
 * @copyright (C) 2006 by Azrul Rahim - All rights reserved!
 * @license Copyrighted Commercial Software
 * 
 * Responsible displaying the data given  
 **/

// Don't allow direct linking
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');

class JCView {

	var $_utf8 = null;
	var $cms = null;

	function JCView() {
		// set up utf8 object
		$this->_utf8 = new Utf8Helper();
		$this->cms =& cmsInstance('CMSCore');
	}
	
	function decodeBracket($str){
		$search = array (
			"0x7B",
			"0x7D"
		);
		$replace = array (
			"{",
			"}"
		);
		$str = str_replace($search, $replace, $str);
		return $str;
	}
	
	# We need to encode the brackets character since it interfere with th JSON
	# eval	
	function encodeBracket($str){
		$search = array (
			"{",
			"}"
		);
		$replace = array (
			"0x7B",
			"0x7D"
		);
		return $str;
	}
	
	function _translateTemplate($text) {
		global $_JC_CONFIG;

		include_once (JC_LANGUAGE_PATH.'/'. $_JC_CONFIG->get('language'));

		$word = array (
			"_JC_TPL_COMMENT_RSS_URI",
			"_JC_TPL_WRITE_COMMENT",
			"_JC_TPL_ADDCOMMENT",
			"_JC_TPL_AUTHOR",
			"_JC_TPL_EMAIL",
			"_JC_TPL_WEBSITE",
			"_JC_TPL_COMMENTS",
			"_JC_TPL_TITLE",
			"_JC_TPL_WRITTEN_BY",
			"_JC_TPL_READMORE",
			"_JC_TPL_COMMENT",
			"_JC_TPL_SEC_CODE",
			"_JC_TPL_SUBMIT_COMMENTS",
			"_JC_TPL_GUEST_MUST_LOGIN",
			"_JC_TPL_HIDESHOW_FORM",
			"_JC_TPL_REMEMBER_INFO",
			"_JC_TPL_SUBSCRIBE",
			"_JC_TPL_PAGINATE_NEXT",
			"_JC_TPL_PAGINATE_PREV",
			"_JC_TPL_NOSCRIPT",
			"_JC_TPL_INPUT_LOCKED",
			"_JC_TPL_TRACKBACK_URI",
			"_JC_TPL_HIDESHOW_AREA",
			"_JC_TPL_REPOST_WARNING",
			"_JC_TPL_BIGGER",
			"_JC_TPL_SMALLER",
			"_JC_VOTE_VOTED",
			"_JC_NOTIFY_ADMIN",
			"_JC_LOW_VOTE",
			"_JC_SHOW_LOW_VOTE",
			"_JC_VOTE_UP",
			"_JC_VOTE_DOWN",
			"_JC_REPORT",
			"_JC_TPL_BOOKMARK",
			"_JC_TPL_USERSUBSCRIBE",
			"_JC_TPL_HITS",
			"_JC_TPL_MAILTHIS",
			"_JC_TPL_FAVORITE",
			"_JC_TPL_MARKING_FAVORITE",
			"_JC_TPL_ADDED_FAVORITE",
			"_JC_TPL_WARNING_FAVORITE",
			"_JC_TPL_LINK_FAVORITE",
			"_JC_TPL_DISPLAY_VOTES",
			"_JC_TPL_MEMBERS_FAV",
			"_JC_TPL_AGREE_TERMS",
			"_JC_TPL_TERMS_WARNING",
			"_JC_TPL_LINK_TERMS",
			"_JC_TPL_VOTINGS_DUP",
			"_JC_TPL_REPORTS_DUP",
			"_JC_TPL_TB_TITLE",
			"_JC_TPL_DOWN_VOTE",
			"_JC_TPL_UP_VOTE",
			"_JC_TPL_ABUSE_REPORT",
			"_JC_TPL_GOLAST_PAGE",
			"_JC_TPL_GOLINK_LAST"
		);
		$utf = new Utf8Helper();
		$replacement = array (
			$utf->utf8ToHtmlEntities(_JC_TPL_COMMENT_RSS_URI),
			$utf->utf8ToHtmlEntities(_JC_TPL_WRITE_COMMENT), 
			$utf->utf8ToHtmlEntities(_JC_TPL_ADDCOMMENT), 
			$utf->utf8ToHtmlEntities(_JC_TPL_AUTHOR), 
			$utf->utf8ToHtmlEntities(_JC_TPL_EMAIL), 
			$utf->utf8ToHtmlEntities(_JC_TPL_WEBSITE), 
			$utf->utf8ToHtmlEntities(_JC_TPL_COMMENTS), 
			$utf->utf8ToHtmlEntities(_JC_TPL_TITLE), 
			$utf->utf8ToHtmlEntities(_JC_TPL_WRITTEN_BY), 
			$utf->utf8ToHtmlEntities(_JC_TPL_READMORE), 
			$utf->utf8ToHtmlEntities(_JC_TPL_COMMENT), 
			$utf->utf8ToHtmlEntities(_JC_TPL_SEC_CODE), 
			$utf->utf8ToHtmlEntities(_JC_TPL_SUBMIT_COMMENTS), 
			$utf->utf8ToHtmlEntities(_JC_TPL_GUEST_MUST_LOGIN), 
			$utf->utf8ToHtmlEntities(_JC_TPL_HIDESHOW_FORM), 
			$utf->utf8ToHtmlEntities(_JC_TPL_REMEMBER_INFO), 
			$utf->utf8ToHtmlEntities(_JC_TPL_SUBSCRIBE), 
			$utf->utf8ToHtmlEntities(_JC_TPL_PAGINATE_NEXT), 
			$utf->utf8ToHtmlEntities(_JC_TPL_PAGINATE_PREV), 
			$utf->utf8ToHtmlEntities(_JC_TPL_NOSCRIPT),
			$utf->utf8ToHtmlEntities(_JC_TPL_INPUT_LOCKED),
			$utf->utf8ToHtmlEntities(_JC_TPL_TRACKBACK_URI),
			$utf->utf8ToHtmlEntities(_JC_TPL_HIDESHOW_AREA),
			$utf->utf8ToHtmlEntities(_JC_TPL_REPOST_WARNING),
			$utf->utf8ToHtmlEntities(_JC_TPL_BIGGER),
			$utf->utf8ToHtmlEntities(_JC_TPL_SMALLER),
			$utf->utf8ToHtmlEntities(_JC_VOTE_VOTED),
			$utf->utf8ToHtmlEntities(_JC_NOTIFY_ADMIN),
			$utf->utf8ToHtmlEntities(_JC_LOW_VOTE),
			$utf->utf8ToHtmlEntities(_JC_SHOW_LOW_VOTE),
			$utf->utf8ToHtmlEntities(_JC_VOTE_UP),
			$utf->utf8ToHtmlEntities(_JC_VOTE_DOWN),
			$utf->utf8ToHtmlEntities(_JC_REPORT),
			$utf->utf8ToHtmlEntities(_JC_TPL_BOOKMARK),
			$utf->utf8ToHtmlEntities(_JC_TPL_USERSUBSCRIBE),
			$utf->utf8ToHtmlEntities(_JC_TPL_HITS),
			$utf->utf8ToHtmlEntities(_JC_TPL_MAILTHIS),
   			$utf->utf8ToHtmlEntities(_JC_TPL_FAVORITE),
			$utf->utf8ToHtmlEntities(_JC_TPL_MARKING_FAVORITE),
			$utf->utf8ToHtmlEntities(_JC_TPL_ADDED_FAVORITE),
			$utf->utf8ToHtmlEntities(_JC_TPL_WARNING_FAVORITE),
			$utf->utf8ToHtmlEntities(_JC_TPL_LINK_FAVORITE),
			$utf->utf8ToHtmlEntities(_JC_TPL_DISPLAY_VOTES),
			$utf->utf8ToHtmlEntities(_JC_TPL_MEMBERS_FAV),
			$utf->utf8ToHtmlEntities(_JC_TPL_AGREE_TERMS),
			$utf->utf8ToHtmlEntities(_JC_TPL_TERMS_WARNING),
			$utf->utf8ToHtmlEntities(_JC_TPL_LINK_TERMS),
			$utf->utf8ToHtmlEntities(_JC_TPL_REPORTS_DUP),
			$utf->utf8ToHtmlEntities(_JC_TPL_VOTINGS_DUP),
			$utf->utf8ToHtmlEntities(_JC_TPL_TB_TITLE),
			$utf->utf8ToHtmlEntities(_JC_TPL_DOWN_VOTE),
			$utf->utf8ToHtmlEntities(_JC_TPL_UP_VOTE),
			$utf->utf8ToHtmlEntities(_JC_TPL_ABUSE_REPORT),
			$utf->utf8ToHtmlEntities(_JC_TPL_GOLAST_PAGE),
			$utf->utf8ToHtmlEntities(_JC_TPL_GOLINK_LAST));
			
		$text = str_replace($word, $replacement, $text);

		return $text;
	}

	# shorten long URL
	function shortenURL($ret){
		
		# Need to pad with a space so that the regex works
		$ret = ' '.$ret;
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "$1<a href='$2' rel='nofollow'>$2</a>", $ret);
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "$1<a href='http://$2' rel='nofollow'>$2</a>", $ret);
		$this->_shortenURL($ret);
		$ret = preg_replace("#(\s)([a-z0-9\-_.]+)@([^,< \n\r]+)#i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $ret);	
		$ret = substr($ret, 1);
		return($ret);
	}

	# only shorten the url enclosed within <a tags, we assume the link has been properly created
	function _shortenURL(&$ret){
	   $links = explode('<a', $ret);
	   $countlinks = count($links);
	   for ($i = 0; $i < $countlinks; $i++){
			$link = $links[$i];			
			$link = (preg_match('#(.*)(href=")#is', $link)) ? '<a'.$link : $link;
	
			$begin = strpos($link, '>') + 1;
			$end = strpos($link, '<', $begin);
			$length = $end - $begin;
			$urlname = substr($link, $begin, $length);

			$chunked = (strlen($urlname) > 50 && preg_match('#^(http://|ftp://|www\.)#is', $urlname)) ? substr_replace($urlname, '...', 30, -10) : $urlname;
			$ret = str_replace('>'.$urlname.'<', '>'.$chunked.'<', $ret); 
	
	   }
	} 	
	
	
	# Prep the data for 1 comment for display
	function prepData(&$data, $item_num, $cssClass, $addAdminPanel = true) {
		global $option, $task, $Itemid, $_JC_CONFIG;
		
		$this->cms->load('libraries','user');
		@include_once ($this->cms->get_path('root')."/components/com_jomcomment/languages/".$_JC_CONFIG->get('language'));

		$pcTemplatePath = $this->cms->get_path('live').'/components/com_jomcomment/templates/';
		$pcTemplate_comment = $pcTemplatePath.$_JC_CONFIG->get('template');
		$pcSmileyPath = $this->cms->get_path('live').'/components/com_jomcomment/templates/images/';

		$data->adminPanel = "";
		$data->gravatar = "";
		$data->comment = jcNl2BrStrict($data->comment);
		$data->comment = $this->encodeBracket($data->comment);

		# Process BBcode tags and smilies
		if ($_JC_CONFIG->get('useBBCode')) {
			if (!class_exists('HTML_BBCodeParser') AND !function_exists('BBCode')) {
				include_once (JC_COM_PATH.'/bbcode.php');
			}

			$data->comment = BBCode($data->comment);
			if($_JC_CONFIG->get('useSmilies')){
				$data->comment = jcDecodeSmilies($data->comment);
			}
			
		} else {
			$data->comment = jcStripBbcode($data->comment);
		}

		# set up text wrapping for super long word
		if ($_JC_CONFIG->get('textWrap')) {
			$data->comment = jcTextwrap($data->comment, 55);
			$data->title = jcTextwrap($data->title, 55);
		}
		
		# Create onclick link for voting, reporting
		# for com_content, use js shortcuts
		if($data->option == 'com_content'){
			$data->onclick_voteup 	= "jcVt('{$data->id}', 1)";
			$data->onclick_votedown = "jcVt('{$data->id}', -1)";
			$data->onclick_report = "jcRpt('{$data->id}')";
		}else{
			$data->onclick_voteup 	= "jax.call('jomcomment', 'jcxVote', 1, '{$data->id}', '$data->option');";
			$data->onclick_votedown = "jax.call('jomcomment', 'jcxVote', -1, '{$data->id}', '$data->option');";
			$data->onclick_report 	= "jax.call('jomcomment', 'jcxReport', '{$data->id}', '{$data->option}',  window.location + '#comment-{$data->id}');";
		}
		


		# Fix utf-8 data
		if (jcIsValidtf8($data->comment)) {
			$data->comment = $this->_utf8->utf8ToHtmlEntities($data->comment);
		}

		if (jcIsValidtf8($data->name)) {
			$data->name = $this->_utf8->utf8ToHtmlEntities($data->name);
		}

		if (jcIsValidtf8($data->title)) {
			$data->title = $this->_utf8->utf8ToHtmlEntities($data->title);
		}

		if (empty ($data->title))
			$data->title = "...";
		if (empty ($data->name))
			$data->name = $this->_utf8->utf8ToHtmlEntities( _JC_GUEST_NAME );

		$isAdmin = (strtolower($this->cms->user->usertype) == 'editor' || strtolower($this->cms->user->usertype) == 'publisher' || strtolower($this->cms->user->usertype) == 'manager' || strtolower($this->cms->user->usertype) == 'administrator' || strtolower($this->cms->user->usertype) == 'super administrator');

		
		/*$template->assign("{adminPanel}", "");
		if ($isAdmin) 
		{
			//$template->assign("{adminPanel}", "<div class=\"jcAdminPanel\" id=\"jc_adminPanel_pc_$item->id\"><a href=\"#\" onclick=\"jc_unpublishPost('{pcId}');return false;\">Unpublish</a></div>");
		}
		*/

		// Include avatar support.
		$avatar = '';

		// Instantiate a new avatar object
		include_once(JC_LIB_PATH . '/avatar.class.php');

		switch($_JC_CONFIG->get('gravatar')){
		    case 'fireboard':
		        $avatar = new JCAvatarFireboard($data->user_id);
		        break;
			case 'gravatar':
			    $avatar = new JCAvatarGravatar($data->user_id, $data->email);
				break;
			case 'cb':
				$avatar = new JCAvatarCB($data->user_id);
				break;
			case 'smf':
			    $avatar = new JCAvatarSMF($data->user_id, $data->email);
			    break;
			default:
			    $avatar= new JCAvatarDefault($data->user_id);
			    break;
		}

		$avLinkStart = "";
		$avLinkEnd = "";
		global $ItemId;
		// Get avatar image from respective avatar providers.
		$avatarImage    = $avatar->img();
		$avatarLink     = $avatar->link($data->user_id, $data->email, $ItemId);

		if($avatarImage){
			$data->gravatar = '<div class="avatarImg">';

			if($avatarLink)
				$data->gravatar	.= '<a href="' . $avatarLink . '">' . $avatarImage . '</a>';
			else
				$data->gravatar	.= $avatarImage;

			$data->gravatar	.= '</div>';
		}

		# Add website link
		if (!empty ($data->website)) {
			if ($data->website == "#") {
				$data->website = "";
			} else {
				# if http:// is missing, add it
				if (strpos($data->website, "http") === false)
					$data->website = "http://".$data->website;
			}
		}

		# Reformat the date
		if ($_JC_CONFIG->get('dateFormat')) {
			$data->date = @ strftime($_JC_CONFIG->get('dateFormat'), strtotime($data->date));
		}
		
		// Set the hidden if rating is too low, If it is already set, 
		// We don't hev to set it up again. It has been set by the caller
		if(!isset($data->hidden))
			$data->hidden = (($data->voted < (-1 * $_JC_CONFIG->get('minVoteCount'))) && (intval($_JC_CONFIG->get('minVoteCount')) != 0));

		$data->style = $cssClass;
		$data->itemNum = $item_num;

		if ($isAdmin AND $addAdminPanel) {
			$data->adminPanel = '<div class="jcAdminPanel" id="jc_adminPanel_pc_{id}">
						            	<a href="#" onclick="jax.call(\'jomcomment\', \'jcxEdit\', \'{id}\');return false;">Edit</a>&nbsp;|&nbsp;
						                <a href="#" onclick="jc_unpublishPost(\'pc_{id}\', \'{option}\', \'{id}\');return false;">Unpublish</a>&nbsp;
						            </div><div id="pc_edit_{id}">';

			$data->adminPanel = str_replace('{id}', $data->id, $data->adminPanel);
			$data->adminPanel = str_replace('{option}', $data->option, $data->adminPanel);
		}

		$data->comment = str_replace("href='www", "href='http://www", $data->comment);

		# re=nofollow
		if ($_JC_CONFIG->get('linkNofollow')) {
			$data->comment = str_replace("href=", "rel=\"nofollow\" href=", $data->comment);
		}

		# close admins' edit block
		if ($isAdmin && $addAdminPanel) {
			$data->adminPanel .= '</div>';
		}
		
		unset ($template);
		return stripslashes($data->comment);
	}
	
	function object_to_array($obj) {
       $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
       $arr = array();
       foreach ($_arr as $key => $val) {
               $val = (is_array($val) || is_object($val)) ? $this->object_to_array($val) : $val;
               $arr[$key] = $val;
       }
       return $arr;
	}
	
	
	# Return BBCODE toolbar 
	function getBBCodeToolbar($path){
		global $_JC_CONFIG;
		
		$smilies  = array (
			":)"     => $path.'/smilies/smiley-toolbar.gif',
			";)"     => $path.'/smilies/wink-toolbar.gif',
			":D"     => $path.'/smilies/cheesy-toolbar.gif',
			";D"     => $path.'/smilies/grin-toolbar.gif',
			">:("    => $path.'/smilies/angry-toolbar.gif',
			":("     => $path.'/smilies/sad-toolbar.gif',
			":o"     => $path.'/smilies/shocked-toolbar.gif',
			"8)"     => $path.'/smilies/cool-toolbar.gif',
			":P"     => $path.'/smilies/tongue-toolbar.gif',
			":-*"    => $path.'/smilies/kiss-toolbar.gif',
			":\'("   => $path.'/smilies/cry-toolbar.gif'
		);
		
		$smiliesAlt  = array (
			":)"     => 'smile',
			";)"     => 'wink',
			":D"     => 'laugh',
			";D"     => 'grin',
			">:("    => 'angry',
			":("     => 'sad',
			":o"     => 'shocked',
			"8)"     => 'cool',
			":P"     => 'tongue',
			":-*"    => 'kiss',
			":\'("   => 'cry'
		);

		$bbCodeToolbar = '<div id="bb_container" style="width:100.1%"><div id="bb_main">';
		
		$bbCodeToolbar .= '<div class="bb_item bb_itemImg" style="width:13px;"><img class="bb_itemImg" src="'. $path.'/smilies/bbcode_front.gif" alt="quote" border="0"/></div>';
		$bbCodeToolbar .= '<div class="bb_item"><a href="javascript:void(0);" tabindex="-1" onclick="jc_encloseText(\'[b]\', \'[/b]\', jax.$(\'jc_comment\')); return false;"><img class="bb_itemImg" src="'. $path.'/smilies/bold.gif" alt="bold"   border="0"/></a></div>';
		$bbCodeToolbar .= '<div class="bb_item"><a href="javascript:void(0);" tabindex="-1" onclick="jc_encloseText(\'[i]\', \'[/i]\', jax.$(\'jc_comment\')); return false;"><img class="bb_itemImg" src="'. $path.'/smilies/italicize.gif" alt="italicize"  border="0"/></a></div>';
		$bbCodeToolbar .= '<div class="bb_item"><a href="javascript:void(0);" tabindex="-1" onclick="jc_encloseText(\'[u]\', \'[/u]\', jax.$(\'jc_comment\')); return false;"><img class="bb_itemImg" src="'. $path.'/smilies/underline.gif" alt="underline" border="0"/></a></div>';
		$bbCodeToolbar .= '<div class="bb_item"><a href="javascript:void(0);" tabindex="-1" onclick="jc_encloseText(\'[s]\', \'[/s]\', jax.$(\'jc_comment\')); return false;"><img class="bb_itemImg" src="'. $path.'/smilies/strike.gif" alt="strike" border="0"/></a></div>';
		$bbCodeToolbar .= '<div class="bb_item"><a href="javascript:void(0);" tabindex="-1" onclick="jc_encloseText(\'[url]\', \'[/url]\', jax.$(\'jc_comment\')); return false;"><img class="bb_itemImg" src="'. $path.'/smilies/url.gif" alt="url" border="0"/></a></div>';
		$bbCodeToolbar .= '<div class="bb_item"><a href="javascript:void(0);" tabindex="-1" onclick="jc_encloseText(\'[img]\', \'[/img]\', jax.$(\'jc_comment\')); return false;"><img class="bb_itemImg" src="'. $path.'/smilies/img.gif" alt="image"  border="0"/></a></div>';
		$bbCodeToolbar .= '<div class="bb_item"><a href="javascript:void(0);" tabindex="-1" onclick="jc_encloseText(\'[quote]\', \'[/quote]\', jax.$(\'jc_comment\')); return false;"><img class="bb_itemImg" src="'. $path.'/smilies/quote.gif" alt="quote"  border="0"/></a></div>';
        $bbCodeToolbar .= '<div class="bb_item bb_itemImg" style="width:13px;"><img class="bb_itemImg" src="'. $path.'/smilies/bbcode_front.gif" alt="quote" border="0"/></div>';

		if($_JC_CONFIG->get('useSmilies')){
			foreach ($smilies as $key => $value) {
				$bbCodeToolbar .= '<div class="bb_item"><a href="javascript:void(0);" tabindex="-1" onclick="jc_addText(\' '.$key.'\', \'jc_comment\'); return false;"><img class="bb_itemImg" src="'.$value.'" alt="'.$smiliesAlt[$key].'" title="'.$smiliesAlt[$key].'" border="0" /></a></div>';
			}
		}

		
		$bbCodeToolbar .= "</div></div>";
		return $bbCodeToolbar;
	}
	
	
	# Return just the (HTML formatted) comment part of jom comment
	function getCommentsHTML(&$data){
		global $_JC_CONFIG, $_JOMCOMMENT, $mainframe;

		$cacheid = "";
		if(is_array($data)){
			$cacheid = strval(count($data));
		}
		
		$comments_tpl 	= new AzrulJXCachedTemplate(serialize($data). $this->cms->user->id .$_JC_CONFIG->get('template') );
		
		if(!$comments_tpl->is_cached()){
			$this->cms->load('libraries', 'input');
			$dataArray = array();
			$styleOffset = 0;
			$createdBy	 = 0;
			
			# The data could be an array or a single data. Convert it all to array. 
			# if it is a single data, we need to make sure we get the corret style
			if(is_array($data)){
				$dataArray = $data;
			} else if(isset($data)){
				$dataArray = array();
				$dataArray[] = $data;
				$numComment  = $_JOMCOMMENT->_dataMgr->getNumComment($data->contentid, $data->option);
				$styleOffset = intval(!($numComment & 1));
			}else {
				$dataArray = array();
			}
			
			# If the data is for "com_content", we need to find the content author 
			# to apply the author specific css
			if($dataArray)
				if($dataArray[0]->option == 'com_content'){
					$createdBy = jcGetContentAuthor($dataArray[0]->contentid);
				}							
							
			
			$styles = explode(",", $_JC_CONFIG->get('cycleStyle'));
			array_walk($styles, "jcTrim");
			$numStyle = count($styles);
			$styleCount = 1;
			$size =  @count($dataArray);
			for($i = 0; $i < $size; $i++) {
				$style = ($styleCount+  $styleOffset) % $numStyle;
				$style = $styles[$style];
				if (isset($dataArray[$i]->created_by) && ($dataArray[$i]->user_id != 0) && ($dataArray[$i]->user_id == $dataArray[$i]->created_by)) {
					$style .= " ". $_JC_CONFIG->get('authorStyle');
				}
				
				$this->prepData($dataArray[$i], $i+1, $style);
				$dataArray[$i]->style = $style;
				
				# Filter the javascript xss
				$dataArray[$i]->comment = $this->cms->input->xss_clean($dataArray[$i]->comment);
				$dataArray[$i]->comment = $this->censorText(stripslashes($dataArray[$i]->comment));
				$dataArray[$i]->title   = $this->censorText($dataArray[$i]->title);
				$dataArray[$i]->name    = $this->censorText($dataArray[$i]->name);
				
				# apply the shorted URL filter
				$dataArray[$i]->comment = $this->shortenURL($dataArray[$i]->comment);
				$dataArray[$i]->title 	= $this->shortenURL($dataArray[$i]->title);
				
				// Add mouseover/mouseout effects
				$dataArray[$i]->hover	= '';
				if($_JC_CONFIG->get('allowvote'))
					$dataArray[$i]->hover	= "onmouseover=\"jax.$('comment_act-{$dataArray[$i]->id}').style.display = 'block';\" onmouseout=\"jax.$('comment_act-{$dataArray[$i]->id}').style.display = 'none';\"";

				$styleCount++;
			}
			
			// Make sure $dataArray is not empty
			if(!$dataArray){
				$dataArray = array();
			}
			$comments_tpl->set('adminPanel', ""); 
			$comments_tpl->set('comments', $dataArray);
			$comments_tpl->set('debugview', false);
			$comments_tpl->set('votes',$_JC_CONFIG->get('allowvote'));
		}
		

		if($_JC_CONFIG->get('overrideTemplate')){
			$customTemplatePath	= JC_CUSTOM_TPL . '/comment.tpl.html';
			$filename = file_exists($customTemplatePath) ? $customTemplatePath : JC_COM_PATH.'/templates/_default/comment.tpl.html';
		} else {
			$filename = JC_COM_PATH."/templates/" .$_JC_CONFIG->get('template') .'/comment.tpl.html';
			$filename = file_exists($filename) ? $filename : JC_COM_PATH.'/templates/_default/comment.tpl.html';
		}
		$html = $comments_tpl->fetch_cache($filename);
		$html = trim($html); 
		
		# Censored code cannot be applied here since it will affect the untranslated
		# test as well		
		$html = $this->_translateTemplate($html);
		return $html;
	}

	/**
	 * Process all the comments
	 */
	function prepAll(&$dataArray, $cid, $option, $contentObj) {
		global $_JC_CONFIG, $_JOMCOMMENT, $Itemid, $mainframe;
		
		$this->cms->load('libraries','user');
		$this->cms->load('helper','url');

		#Check if mambots/system/pc_includes/template.php was included.
		if(!defined('AzrulJXTemplate')){
		    	include_once($this->cms->get_path('plugins') . '/system/pc_includes/template.php');
		}
		
		$tpl	=  new AzrulJXTemplate(); // this is the outer template
		

		$comments  = array();
		$comments['count']	= jcCountComment($cid, $option);
		
		#echo $comments['count'];
		# Hide/show settings
		$show = array();
		$show['name'] 		= $_JC_CONFIG->get('moreInfo');
		$show['email'] 		= $_JC_CONFIG->get('fieldEmail');
		$show['title'] 		= $_JC_CONFIG->get('fieldTitle');
		$show['website'] 	= $_JC_CONFIG->get('fieldWebsite');
		$show['feed'] 		= $_JC_CONFIG->get('useRSSFeed');
		$show['trackback'] 	= $_JC_CONFIG->get('enableTrackback');
		$show['bbcode']		= $_JC_CONFIG->get('useBBCode');
		$show['useSmilies'] = $_JC_CONFIG->get('useSmilies');
		$show['captcha']	= $this->cms->user->username ? $_JC_CONFIG->get('useCaptchaRegistered') : $_JC_CONFIG->get('useCaptcha'); 
		$show['allow_guest']= !empty($this->cms->user->username) ? true : $_JC_CONFIG->get('anonComment');
		$show['inputform']	= true;
		$show['last']		=  
		
		$show['hide_show_form']		= $_JC_CONFIG->get('slideForm');
		$show['hide_show_comment']	= $_JC_CONFIG->get('slideComment');
		
		$show['start_form_hidden']		= $_JC_CONFIG->get('startFormHidden');
		$show['start_comment_hidden']	= $_JC_CONFIG->get('startAreaHidden');
		
		$show['sharethis']		= $_JC_CONFIG->get('showShareToolbar');
		$show['hitstats']		= $_JC_CONFIG->get('showHitsStats');
		$show['subscribe']  	= $_JC_CONFIG->get('allowSubscription');
		$show['favorites']  	= $_JC_CONFIG->get('allowFav');
		$show['allowvote']      = $_JC_CONFIG->get('allowvote');
		$show['sharebutton']    = $_JC_CONFIG->get('showShareButton');
		$show['emailbutton']    = $_JC_CONFIG->get('showEmailButton');
		
		$show['goto_last_page'] = false;

		$show['terms']          = $_JC_CONFIG->get('showTerms');
		$show['termsText']      = $_JC_CONFIG->get('termsText');
		# Content related info
		$doc = array();		
		$doc['option']		= $option;
		$doc['id']			= $cid;
		
		# Captcha info
		$captcha = array();
		$captcha['show']	= $show['captcha'];
		$captcha['sid']	 	= $_JOMCOMMENT->getSid();
		$captcha['img']		= $this->cms->get_path('live').'/index2.php?option=com_jomcomment&amp;task=img&amp;jc_sid='. $captcha['sid'];	
			
		# Rss FEED
		$feed = array();
		$feed['show']		= $show['feed'];
		$feed['link']   = cmsSefAmpReplace('index.php?option=com_jomcomment&task=rss&contentid=' . $cid . '&opt=' . $option);
		
		// Current URL
		$uri    = isset($_SERVER['REQUEST_URI']) ? cmsSefAmpReplace(ltrim($_SERVER['REQUEST_URI'])) : '';

		# $my object, just use $my
		$my_arr = array();
		$my_arr = $this->object_to_array($this->cms->user);
		
		# Locking
		$lock = array();
		$lock['locked'] = strpos($contentObj->text, "{jomcomment_lock}") || strpos($contentObj->text, "{jomcomment lock}");
		if($option == 'com_content'){
			if($lockafter = $_JC_CONFIG->get('lockAfter')){
				$this->cms->db->query("SELECT `publish_up` FROM #__content WHERE id='$cid'");
				$pubup = $this->cms->db->get_value();
				if(time() > (strtotime($pubup) + (86400*$lockafter))){
					$lock['locked'] = true;
				}
			}
		}
		$lock['date']	= false;
		
		# Site information
		$site = array();
		$site['live_site'] = $this->cms->get_path('live');
		$site['site_path'] = $this->cms->get_path('root');
		$site['template_path'] 	= "";
		$site['com_path']		= "";
		$site['bot_path']		= "";
		$site['id']				= $cid;
		$site['option']			= $option;
		
		# Trackbacks
		if(!defined('JCTrackback'))
		    include_once(JC_LIB_PATH . '/trackback.class.php');
		$tb = new JCTrackback();

		$trackback['show'] 		= $show['trackback'];
		$trackback['text']		= $_JC_CONFIG->get('enableTrackback') ? $tb->lists($cid, $option) : NULL;
		$trackback['link']      = cmsSefAmpReplace('index.php?option=com_jomcomment&task=trackback&id=' . $cid . '&opt=' . $option);
		$trackback['count']     = $tb->lists($cid, $option, true);
		
		$show['inputform']	= (!$lock['locked'] && ($show['allow_guest'])) || 
							( !$show['allow_guest'] && !empty($this->cms->user->username));
		# If we're in printing mode pop=1, remove comment form
		if(isset($_GET['pop'])) $show['inputform'] = false;		
		
		# Add pagination if necessary, We need to strip the data if pagination is active
		if($_JC_CONFIG->get('paging') && ($comments['count'] > $_JC_CONFIG->get('paging'))){
			include_once ($this->cms->get_path('root')."/includes/pageNavigation.php");

			$total = $comments['count'];

			$this->cms->load('libraries', 'pagination');
			$config = array();
				
			$config['total_rows'] = $total;
			$config['base_url'] = $_SERVER['REQUEST_URI'];
			$config['per_page'] = $_JC_CONFIG->get('paging');
	
			$this->cms->pagination->initialize($config);
			
			
			$limitstart = $this->cms->pagination->get_page(); 
			$limit = $config['per_page'];
 
			$comments['text']	= $this->getCommentsHTML($dataArray);
	
			$pagination =  $this->cms->pagination->create_links();
			$pagesLinks = '<div id="jcPaging">'.$pagination.'</div>';
			$tpl->set('pagingLink', $pagesLinks); 			

			# If we're not at the last page, do not show the input form
			if($total > ($limitstart + $limit)){
				$show['inputform']	= false;
			}

			// Only whos the last page link if we're not on the last page
			$show['goto_last_page'] = $this->cms->pagination->last_link();
			 
			if($lock['locked'] or $show['inputform'] or !$show['allow_guest']){
				$show['goto_last_page'] = '';
			} 
			$tpl->set('last_page_link', $this->cms->pagination->last_link());
		} else {
			$comments['text']	= $this->getCommentsHTML($dataArray);
		}
// 		$comments['text']	= $this->getCommentsHTML($dataArray);
		$subscribeOn = $_JC_CONFIG->get('defaultSubscription') ? ' checked="checked" ' : '';
		$tpl->set('subscribeOn', $subscribeOn); 
		$tpl->set('feed', $feed);
		$tpl->set('show', $show);
		$tpl->set('captcha', $captcha);
		$tpl->set('my', $my_arr);
		$tpl->set('lock', $lock);
		$tpl->set('site', $site);
		$tpl->set('trackback', $trackback);
		$tpl->set('doc', $doc);
		$tpl->set('uri', $uri);
		$tpl->set('bbcode', $this->getBBCodeToolbar(JC_BOT_LIVEPATH));
		$tpl->set('comments', $comments);
		$tpl->set('debugview', false);
		$tpl->set('sharethis', $this->_getShareToolbar($cid, $option,$show));
		$content = "";

		// Template overrides
		if ($_JC_CONFIG->get('overrideTemplate')){
			$customTemplatePath	= JC_CUSTOM_TPL . '/index.tpl.html';
			if(file_exists($customTemplatePath))
				$content = trim($tpl->fetch($customTemplatePath));
			else
				$content = trim($tpl->fetch(JC_COM_PATH.'/templates/_default/index.tpl.html'));
		} else {	
			if(file_exists(JC_COM_PATH.'/templates/' .$_JC_CONFIG->get('template') .'/index.tpl.html'))
				$content = trim($tpl->fetch(JC_COM_PATH.'/templates/' .$_JC_CONFIG->get('template') .'/index.tpl.html'));
			else
				$content = trim($tpl->fetch(JC_COM_PATH.'/templates/_default/index.tpl.html'));
		}
		$html = $this->_translateTemplate($content);
		return $this->_cleaupOutput($html);
		
	}
	
	function _cleaupOutput($html){
		global $_JC_CONFIG;
		
		# Clean up the content
		$search = array ("&lt;", "&gt;");
		$replace = array ("<", ">");
		$html = str_replace($search, $replace, $html);
		
		# Change relative image url to template folder
		$images_path = 'src="'.$this->cms->get_path('live').'/components/com_jomcomment/templates/'. $_JC_CONFIG->get('template').'/';
		$html = str_replace('src="', $images_path, $html);
		$html = str_replace($images_path.'http', 'src="http', $html);
		$html = str_replace('src="images', 'src="'. JC_BOT_LIVEPATH .'/templates/'.$_JC_CONFIG->get('template').'/images/', $html);
		$html = jcFixLiveSiteUrl($html);	
		
		return $html;
	}

	/**
	 * Return the blog view HTML codes
	 */
	function getBlogView($cid) {

	}

	# Apply the word censor to the given text
	function censorText($text){
		global $_JC_CONFIG;
		
		if ($_JC_CONFIG->get('censoredWords')) {
			$censoredWords = explode(",", $_JC_CONFIG->get('censoredWords'));
			array_walk($censoredWords, "jcTrim");
			$replaceWords = $censoredWords;
			$count = 0;
			foreach ($replaceWords as $word) {
				$cword = "";
				$word = trim($word);
				
				// Only word longer than 2 character wil be censored
				if(isset($word) && strlen($word) > 2){
					for ($i = 0; $i < @strlen($word); $i++)
						$cword .= "*";
	
					$cword[0] = @$word[0];
					$cword[strlen($word) - 1] = @$word[strlen($word) - 1];
					$replaceWords[$count] = $cword;
					$count++;
				}
			}

			$count = 0;
			foreach ($censoredWords as $word) {
				$word = trim($word);
				
				// Only word longer than 2 character wil be censored
				if(isset($word) && @strlen($word) > 2){
					$censoredWords[$count] = $word;
					$count++;
				}
			}

			if(is_array($text)){
			    for($i=0;$i < count($text); $i++){
				    if(is_array($censoredWords) || is_array($replaceWords)){
						for($b = 0; $b < count($censoredWords); $b++){
						    $text[$i] = jcStrIReplace($censoredWords[$b], $replaceWords[$b] , $text[$i]);
						}
            		}else
						$text[$i] = jcStrIReplace($censoredWords, $replaceWords, $text[$i] );
				}
			}else {
			    if(is_array($censoredWords) || is_array($replaceWords)){
					for($b = 0; $b < count($censoredWords); $b++){
					    $text = jcStrIReplace($censoredWords[$b], $replaceWords[$b] , $text);
					}
	    		}else
					$text = jcStrIReplace($censoredWords, $replaceWords, $text );
			}
		}
		
		return $text;
	}

	// Return the topmost 'share' toolbar, no template used at the moment
	function _getShareToolbar($id, $option, $show){
		// Load user library
		$this->cms->load('libraries','user');
		$this->cms->load('helper', 'url');

		$title 		= ( 'com_myblog' == $option || 'com_content' == $option ) ? jcContentTitle($id) : 'n/a';
		$title 		= urlencode($title);
		$busyimg 	= $this->cms->get_path('live') .'/components/com_jomcomment/busy.gif';
		$link       = cmsSefAmpReplace('index.php?opotion=com_jomcomment&task=myfavorites&Itemid=' . jcGetItemId());
		
		$html = '<div style="position:relative;">
				 <div class="commentBlogView commentTools" id="commentTools">';

		if($show['favorites']){
			$userStatus = $this->cms->user->id != 0 ? 'fav_re' : 'fav_un';
			
            # We dont want to display the link to the guest
		    $html   .= "
				<div class=\"jctools jcfav\">
				<a href=\"javascript:void(0);\" onclick=\"jax.call('jomcomment','jcxMyFav', {$id},'{$option}');\"> _JC_TPL_FAVORITE </a>
				</div>";
		}
		
		if($show['sharebutton']){
			$html .= "
				<div class=\"jctools jcshare\"> 
				<a href=\"javascript:void(0);\" onclick=\"jax.call('jomcomment','jcxShowBookmarkThis', {$id},'{$option}');\"> _JC_TPL_BOOKMARK </a>
				</div>";
		}

		if($show['emailbutton']){
			$html   .= "<div class=\"jctools jcemail\">
			            	<a href=\"javascript:void(0);\" onclick=\"jax.call('jomcomment', 'jcxShowEmailThis', {$id},'{$option}'); \">_JC_TPL_MAILTHIS</a>
						</div>";
					

		}
		
		// We don't know the hits if we're not in com_content
		if( $show['hitstats'] && ('com_content' == $option || 'com_myblog' == $option)){
			$html .= '<div class="show-hit"> _JC_TPL_HITS: '.jcCountContentHit($id).'</div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	

	function _truncateLink($url, $mode = '0', $trunc_before = '', $trunc_after = '...') {
		if (1 == $mode) {
			$url = preg_replace("/(([a-z]+?):\\/\\/[A-Za-z0-9\-\.]+).*/i", "$1", $url);
			$url = $trunc_before.preg_replace("/([A-Za-z0-9\-\.]+\.(com|org|net|gov|edu|us|info|biz|ws|name|tv|eu)).*/i", "$1", $url).$trunc_after;
		}
		elseif (($mode > 10) && (strlen($url) > $mode)) {
			$url = $trunc_before.substr($url, 0, $mode).$trunc_after;
		}
		return $url;
	}

	/**
	 * mode: 0=full url; 1=host-only ;11+=number of characters to truncate after
	 */
	function _hyperlinkUrls($text, $mode = '0', $trunc_before = '', $trunc_after = '...', $open_in_new_window = true) {
		$text = ' '.$text.' ';
		$new_win_txt = ($open_in_new_window) ? ' target="_blank"' : '';

		# Hyperlink Class B domains
		$text = preg_replace("#([\s{}\(\)\[\]])([A-Za-z0-9\-\.]+)\.(com|org|net|gov|edu|us|info|biz|ws|name|tv|eu|mobi)((?:/[^\s{}\(\)\[\]]*[^\.,\s{}\(\)\[\]]?)?)#ie", "'$1<a href=\"http://$2.$3$4\" title=\"http://$2.$3$4\"$new_win_txt>'.$this->_truncateLink(\"$2.$3$4\", \"$mode\", \"$trunc_before\", \"$trunc_after\").'</a>'", $text);

		# Hyperlink anything with an explicit protocol
		$text = preg_replace("#([\s{}\(\)\[\]])(([a-z]+?)://([A-Za-z_0-9\-]+\.([^\s{}\(\)\[\]]+[^\s,\.\;{}\(\)\[\]])))#ie", "'$1<a href=\"$2\" title=\"$2\"$new_win_txt>'.$this->_truncateLink(\"$4\", \"$mode\", \"$trunc_before\", \"$trunc_after\").'</a>'", $text);

		# Hyperlink e-mail addresses
		$text = preg_replace("#([\s{}\(\)\[\]])([A-Za-z0-9\-_\.]+?)@([^\s,{}\(\)\[\]]+\.[^\s.,{}\(\)\[\]]+)#ie", "'$1<a href=\"mailto:$2@$3\" title=\"mailto:$2@$3\">'.$this->_truncateLink(\"$2@$3\", \"$mode\", \"$trunc_before\", \"$trunc_after\").'</a>'", $text);

		return substr($text, 1, strlen($text) - 2);
	}
	
	
}
