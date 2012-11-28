<?php

defined ( '_JEXEC') or die ('Restricted access');

?>
<script type="text/javascript">
function processForm1(form) {
	
	if ( form.searchKey.value == '' ) {
		alert('Please enter search keyword(s)');
		return false;
	}
	
	return true;
}

function processForm2(form) {
	return true;
	
	var flag = false;
	for (var i=0; i < 30; i++){
		// if (form.searchTopics[i].checked) flag = true;
	}
	
	
	return flag;
}
</script>

<p class="contentheading"> Selected Articles on Tobacco and Health Disparities</p>
<?php


    if (strlen($this->errMsg)>0) echo "<div id='errormsg'><b>".$this->errMsg."</b></div>\n";
	
    if (count($this->bibSpecs)>0) {
	?>
        <div id="searchresultswrap">
        <b>Search Results:</b>
        <ul class="searchresult">
		<?php
		foreach ( $this->bibSpecs as $result)
							echo "<li>".$result["summary"]."</li>\n";
		?>

        </ul></div>
	<?php }
	
	// not used
	$searchTopics = array(
		'acculturation',
		'African Americans',
		'age',
		'American Indians / Alaskan Natives',
		'Asian American / Pacific Islanders',
		'cessation / treatment',
		'correctional facilities',
		'disabilities',
		'elderly',
		'gender',
		'general disparities',
		'geography',
		'international',
		'Latinos / Hispanics',
		'LGBT (lesbian, gay, bisexual, transgendered)',
		'low income',
		'media',
		'mental health',
		'nicotine',
		'occupation / social class',
		'policy',
		'prevalence',
		'prevention',
		'race / ethnicity',
		'religion',
		'rural / urban',
		'secondhand smoke',
		'tobacco',
		'women',
		'youth',
		);	

        ?>
	<form action="index.php?option=com_pubmed&task=results&Itemid=<?php echo $this->itemid; ?>" method="post" name="search" onSubmit="return processForm1 (this)">	
    <input type="hidden" name="submitAction" value="searchBib">
    <b style="font-size:10pt;">Search Articles by KEYWORD:</b><br><br>
    <table border=0 cellpadding=0 cellspacing=0>
    <tr>
        <td align="right" valign="top"><input type="text" name="searchKey" value="<?php echo htmlentities($this->searchKey)?>" size=26 style="font-size:9pt;"></td>
        <td valign="top" style="width:50px;">&nbsp;</td>
        <td valign="top" align="right"><input type="submit" value="go"></td>
    </tr>
    <tr>
        <td align="right" valign="top" style="font-size:8pt; color:#999999;">
        <b>ex</b>: Tobacco Control&nbsp;&nbsp;<br>
        &nbsp;</td>
        <td valign="top"></td>
        <td valign="top"></td>
    </tr>
    </table>
    </form>

	<form action="index.php?option=com_pubmed&task=results&Itemid=<?php echo $this->itemid; ?>" method="post" name="search" onSubmit="return processForm2 (this)">
    <input type="hidden" name="submitAction" value="searchBib2">
    <b style="font-size:10pt;">Search Articles by TOPIC:</b><br>
    <table border=0 cellpadding=0 cellspacing=0>
    <tr>
        <td valign="top"><br>
        <table border=0 cellpadding=1 cellspacing=0>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[0]"<?php if ($this->searchTopics[0]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">acculturation</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[1]"<?php if ($this->searchTopics[1]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">African Americans</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[2]"<?php if ($this->searchTopics[2]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">age</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[3]"<?php if ($this->searchTopics[3]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">American Indians / Alaskan Natives</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[4]"<?php if ($this->searchTopics[4]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">Asian American / Pacific Islanders</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[5]"<?php if ($this->searchTopics[5]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">cessation / treatment</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[6]"<?php if ($this->searchTopics[6]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">correctional facilities</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[7]"<?php if ($this->searchTopics[7]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">disabilities</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[8]"<?php if ($this->searchTopics[8]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">elderly</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[9]"<?php if ($this->searchTopics[9]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">gender</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[10]"<?php if ($this->searchTopics[10]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">general disparities</td></tr>
        </table>&nbsp;</td>
    
        <td valign="top"></td>
        <td valign="top"><br>
        <table border=0 cellpadding=1 cellspacing=0>

        <tr><td valign="top"><input type="checkbox" name="searchTopics[11]"<?php if ($this->searchTopics[11]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">geography</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[12]"<?php if ($this->searchTopics[12]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">international</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[13]"<?php if ($this->searchTopics[13]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">Latinos / Hispanics</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[14]"<?php if ($this->searchTopics[14]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">LGBT (lesbian, gay, bisexual, transgendered)</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[15]"<?php if ($this->searchTopics[15]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">low income</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[16]"<?php if ($this->searchTopics[16]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">media</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[17]"<?php if ($this->searchTopics[17]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">mental health</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[18]"<?php if ($this->searchTopics[18]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">nicotine</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[19]"<?php if ($this->searchTopics[19]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">occupation / social class</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[20]"<?php if ($this->searchTopics[20]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">policy</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[21]"<?php if ($this->searchTopics[21]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">prevalence</td></tr>
        </table>&nbsp;</td>
    
        <td valign="top"></td>
        <td valign="top"><br>
        <table border=0 cellpadding=1 cellspacing=0>
		
		<!--Note: due to coding algorith used, forced to code each search topic explicitly to accomodate searchTopic = 29 -->
        <tr><td valign="top"><input type="checkbox" name="searchTopics[29]"<?php if ($this->searchTopics[29]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">prevention</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[22]"<?php if ($this->searchTopics[22]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">race / ethnicity</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[23]"<?php if ($this->searchTopics[23]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">religion</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[24]"<?php if ($this->searchTopics[24]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">rural / urban</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[25]"<?php if ($this->searchTopics[25]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">secondhand smoke</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[26]"<?php if ($this->searchTopics[26]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">tobacco</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[27]"<?php if ($this->searchTopics[27]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">women</td></tr>
        <tr><td valign="top"><input type="checkbox" name="searchTopics[28]"<?php if ($this->searchTopics[28]=="on") echo " checked"; ?>></td><td valign="top" class="searchtopic">youth</td></tr>
        </table><br><br>
        <div align="center"><input type="submit" value="go"></div>
        &nbsp;</td>
    </tr>
    </table>
    </form>
