<?php

(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Direct Access to this location is not allowed.');
global $jc_configString, $jc_defaultVals, $mainframe;

if(!defined('_JC_JOMCOMENT_CONFIG'))
{
	class JCConfig
	{
		var $_config 	= null;
		var $_configString = "";
		var $_defaultVars = "";
		var $_tableName 	= "#__jomcomment_config";
		var $db = null;
		var $enable               = "1";
		var $language             = "english.php";
		var $autoLang             = "0";
		var $autoPublish          = "1";
		var $anonComment          = "1";
		var $moreInfo             = "1";
		var $useBBCode            = "1";
		var $useSmilies           = "1";
		var $useRSSFeed           = "1";
		var $autoUpdate           = "0";
		var $updatePeriod         = "300";
		var $staticContent        = "0";
		var $limitSection         = "0";
		//var $sections             = "0";
		var $limitCategory		  = "1";
		var $categories			  = "1,2,3";
		var $notifyAdmin          = "0";
		var $notifyEmail          = "";
		var $useCaptcha           = "0";
		var $blockDomain          = "";
		var $blockUsers           = "";
		var $blockWords           = "";
		var $censoredWords        = "";
		var $postInterval         = "30";
		var $template             = "default";
		var $sortBy               = "1";
		var $cycleStyle           = "jomentry1,jomentry2";
		var $textWrap             = "55";
		var $alertBgColor         = "#FAD163";
		var $aletrFontColor       = "#000000";
		var $dateFormat           = "%B %d, %Y";
		var $useReadMore          = "1";
		var $useSelectiveReadMore = "0";
		var $gravatar             = "gravatar";
		var $gWidth               = "40";
		var $gHeight              = "40";
		var $hideForm             = "1";
		var $modGuest             = "0";
		var $fieldWebsite         = "1";
		var $fieldTitle           ="1";
		var $useCaptchaRegistered = "0";
		var $showBlogViewLink     = "1";
		var $showCommentCount	  = "1";
		var $showHitCount		  = "1";
		var $linkNofollow         = "1";
		var $startFormHidden      = "0";
		var $startAreaHidden      = "0";
		var $slideComment         = "0";
		var $slideForm            = "0";
		var $linkGravatar         = "none";
		var $spamLinkStuff        = "1";
		var $spamMaxLink          = "2";
		var $commentMinLen        = "8";
		var $commentMaxLen        = "5000";
		var $maxCommentHalfHour   = "20";
		var $authorStyle          = "jomauthor";
		var $notifyAuthor         = "0";
		var $useEmailSubs         = "1"; // allow email subscription to comment
		var $fieldEmail           = "1";
		var $paginate             = "0";
		var $multiLanguage		 = "0";
		var $enableTrackback	 = "0";
		var $trackbackShow		 = "10";
		var $useLinkBack		 = "1";
		var $smfPrefix			 = "smf";
		var $smfWrapped			 = "1";
		var $smfPath			 = "";
		var $optimiseEncoding	 = "0";
		var $lockAfter			 = "0";
		var $remoteSpam			 = "0";
		var $username			 = "name";
		var $paging				 = "0";	// Pagination, 0 = no pagination
		var $akismetKey			 = "";
		var $allowedTags		 = "";
		var $extComSupport		 = "1";
		var $unpublishReported	 = "20";
		var $minVoteCount		 = "5";
		var $allowvote			 = "1";
		var $allowFav			 = "1";
		var $showShareButton	 = "1";
		var $showEmailButton	 = "1";
		var $showHitsStats		 = "1";
		var $allowSubscription	 = "1";
		var $defaultSubscription = "0";
		var $showShareToolbar 	 = "1";
		var $termsText           = "By submitting your comments we reserve the right, at our sole discretion, to change, modify, add, or delete your comments and portions of these Terms of Use at any time without further notice.";
		var $showTerms           = "1";
		var $checkMultiPaste	 = "1";
		var $checkUserAgent 	 = "1";
		var $disableFrontPage    = "0";

		var $overrideTemplate	 = "0";

		function JCConfig(){
			$this->db =& cmsInstance('CMSDb');
									
			$this->db->query("SELECT value FROM $this->_tableName WHERE name='all'");
			$this->_configString = $this->db->get_value();
			
			//echo $this->_configString; exit;
			
			# Save default config in the database if none exist
			if(!$this->_configString){
				global $mainframe;

				# Start with default language file
				if (file_exists(JC_COM_PATH . "languages/" . $mainframe->getCfg('lang') . ".php"))
					$this->language = $mainframe->getCfg('lang') . '.php';
				
				# Set nitification email to default joomla admin email
				$this->notifyEmail = $mainframe->getCfg('mailfrom');
				
				# insert default values	
				$default_vars = get_class_vars('JCConfig');
				$this->_configString = "";
				foreach ($default_vars as  $name => $value) {
					if(substr($name, 0, 1) != "_")
						$this->_configString .= "\$$name = \"" . strval($value) ."\";\n";
				}
				
							
				
				$this->db->query("INSERT INTO $this->_tableName SET value='$this->_configString', name='all'");
				
							
			} else if(substr($this->_configString, 0, 4) == '$pc_'){
				# If the data is in old format, we need to update them
				$this->_configString = str_replace('$pc_', '$', $this->_configString);
				$this->db->query("UPDATE {$this->_tableName} SET value='{$this->_configString}', name='all'");
				
					
			} else if(strpos($this->_configString, '$sections')){
				# If the data contain '$section', we need to convert them to category listing
// 				$sections = "";
// 				eval($this->_configString);
// 				$sectionsArray = explode(",", $sections);
// 				$sections = str_replace(",", '","', $sections);
// 				$sections = "\"$sections\"";
// 				
// 				$this->db->query("SELECT `id` FROM #__categories WHERE `section` IN ($sections)");
// 				$cats = $this->db->get_object_list();
// 				foreach($cats as $cat){
// 					$this->categories .= "$cat->id,";
// 				}
// 				$this->categories = substr($this->categories, 0, -1);
			}
			
			// For some reason, $this->_configString might contain some dirty stuff,
			// towads the beginning of the string. Filter it out 
			$this->_configString = substr($this->_configString , strpos($this->_configString, '$enable'));
			
			$cfg = str_replace('$', '$this->', $this->_configString);
			eval($cfg);
			
			
			
			# Need to set up multi language support (JoomFish)
			if($this->autoLang){
			    global $mainframe;
				$lang_file = $mainframe->getCfg('lang') . ".php";
				if(defined('JC_COM_PATH')){
					if(file_exists(JC_COM_PATH ."languages/$lang_file")){
						$this->language = $lang_file;
					}
                }
			}
			
			# compatbility for version 1.6 upwards
			if($this->dateFormat == "F j, Y"){
			    $this->dateFormat= "%B %d, %Y";
			}
			
			if(substr($this->template, -5) == ".html"){
			    $this->template = substr($this->template, 0, -5);
			}
			
			# If template is not available, revert to 'default' template
			if (!file_exists(JC_COM_PATH."/templates/" . $this->template)) {
			    $this->template = "default";
			}
			
			# Set section to all section/category if none is selected
// 			if($this->sections == "0"){
// 				$this->db->query('SELECT id FROM #__sections');
// 				$secs = $this->db->get_value();
// 				$this->sections = "";
// 				for($i = 0; $i < count($secs); $i++){
// 					$this->sections .= "," . strval($secs[$i]);
// 				}
// 				
// 			}

			# Set categories to all if none is selected
			if(empty($this->categories)){
				$this->db->query("SELECT `id` FROM #__categories");
				$cats = $this->db->get_object_list();
				foreach($cats as $cat){
					$this->categories .= "$cat->id,";
				}
				$this->categories = substr($this->categories, 0, -1);
			}
		}
		
		# Return current config string. We also need to load up uninitialised
		# configuration		 	 		
		function getConfigString(){
			$varString = $this->_defaultVars . $this->_configString;
			return $varString;
		}
		
		function get($varname, $default="0"){
			if(isset($this->$varname)){
				return $this->$varname;
			}else{
				return $default;
			}
		}
		
		function addBlockedIP($ip) { 
			$this->db->query("SELECT value FROM $this->_tableName WHERE name='all'");
			$configStr = $this->db->get_value();
			$configStr = str_replace('$blockDomain= "', '$blockDomain= "' . $ip . ',', $configStr);
			$this->db->query("UPDATE $this->_tableName SET value='$configStr' WHERE name='all'");
		}
		
		function addBlockedUser($username) { 
			$this->db->query("SELECT value FROM {$this->_tableName} WHERE name='all'");
			$configStr = $this->db->get_value();
			$configStr = str_replace('$blockUsers= "', '$blockUsers= "' . $username . ',', $configStr);
			$this->db->query("UPDATE $this->_tableName SET value='$configStr' WHERE name='all'");
		}
		
		# Take all $_POST vars, create a string and save it	 		
		function save(){
			$config = "";
			
			$postvar = array_keys($_POST);
			$objvars = get_object_vars ($this);

			foreach ($objvars as $key => $val) {
			    if($key{0} != '_' && $key !='db'){

				    if(isset($_POST[$key])){
				        $val = $_POST[$key];
					} else {
					    $val = "0";
					}

					if (is_array($val)) {
						$ls = implode(",", $val);
						$config .= "\$$key= \"$ls\";\n";
					} else {
						$config .= "\$$key= \"$val\";\n";
					}
				}
			}


			//$config = addslashes($config);
 			//print_r($config);
 			//exit;
			$this->db->query("UPDATE $this->_tableName SET value='$config', name='all'");
			
		}
	}
		
	define('_JC_JOMCOMENT_CONFIG', 1);
}
