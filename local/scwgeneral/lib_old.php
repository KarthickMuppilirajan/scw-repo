<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package local-scwbanner
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$domainnames = array("sit.supplychainwire.com", "www.supplychainwire.com", "4blabs.com");
$servername = $_SERVER['SERVER_NAME'];
if(!in_array($servername,$domainnames)){
	die();
}

$allowed_domains = $_SERVER['SERVER_NAME'];

function local_scwgeneral_pluginfile($course, $cm, $context, $filearea, $args,
                               $forcedownload, array $options=array()) {
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_scwgeneral', $filearea, $args[0], '/', $args[1]);
    send_stored_file($file);
}

function local_scwgeneral_get_industry($fl=1,$name='industry',$default='',$params=array("id" => "cmbindustry" , "class" => "form-control")){
    $pages = get_config('local_scwgeneral', 'industry');
    $apages = explode("\n", $pages);
    $indoptions = ($fl==1) ? array() : array('' => '--Select Industry --');
    foreach($apages as $apage){
		$apage = trim($apage);
        $arpage = explode("|",$apage);
		list($pshort, $pname) = $arpage;
        $indoptions[$pshort] = $pname;
	}
	if($fl==1){
	    return $indoptions;
	}else{
        $select = html_writer::select($indoptions, $name, $default,false,$params);
		return $select;
	}
    
}

function local_scwgeneral_get_farea($fl=1,$name='farea',$default='',$params=array("id" => "cmbfarea" , "class" => "form-control")){
    $pages = get_config('local_scwgeneral', 'farea');
    $apages = explode("\n", $pages);
	$faoptions = ($fl==1) ? array() : array('' => '--Select Functional Area--');
    foreach($apages as $apage){
		$apage = trim($apage);
        $arpage = explode("|",$apage);
		list($pshort, $pname) = $arpage;
		if($pshort=='distribution')
		$pshort='distributions';//replace slung to fix repeting		
        $faoptions[$pshort] = $pname;
	}
	if($fl==1){
	    return $faoptions;
	}else{
        $select = html_writer::select($faoptions, $name, $default,false,$params);
		return $select;
	}
}

function local_scwgeneral_get_countries($fl=1,$name='country',$default='',$params=array("id" => "cmbcountry" , "class" => "form-control")) {
	$countries = get_string_manager()->get_list_of_countries(true);
	$coptions = ($fl==1) ? $countries : array_merge(array('' => '--Select Country --', 'GB' => 'United Kingdom'), $countries);
	$coptions = array_unique($coptions);
	if($fl==1){
	    return $coptions;
	}else{
        $select = html_writer::select($coptions, $name, $default,false,$params);
		return $select;
	}
}

function local_scwgeneral_home_functional_area(){
    global $DB;
	  $qry = "SELECT *
       FROM {user} as u , {user_details} as ud 
        WHERE u.id=ud.user_id and u.suspended!='1' and u.deleted!='1' AND ud.profession = '1' AND  ud.is_searchable = '1' AND ud.approval_status = '1' AND ud.functional_area is not NULL ";
    $fresult = $DB->get_records_sql($qry);

	foreach($fresult as $row)
	{
		$functional_area=$row->functional_area;
		$farea = local_scwgeneral_get_farea();
		foreach($farea as $faslug => $faname ){
/*			if($faslug=='distribution')
			$faslug='distributions';*/
			if(strstr($functional_area,$faslug)) //compare both array and count if exists
			{
					@$arr[$faslug]['cnt']+=1;		
			}			
		}	
	}
	
	$dbfarea = array();
	$finalfarea = array();
    foreach($fresult as $frow){
       // $dbfarea[$frow->functional_area] = $frow->fcnt;
    }
    $farea = local_scwgeneral_get_farea();
	/*	echo '<pre>';
	print_r($arr);
	print_r($farea);
	echo '</pre>';
	exit;*/
	foreach($farea as $faslug => $faname ){
		$facount = isset($dbfarea[$faslug])?$dbfarea[$faslug]:'0';
		$params = array("profession" => "1", "country" => "",
                "industry" => "", "farea" => $faslug
            );
        $faurl = new moodle_url('/local/mylinks/search.php', $params);		
		if(@$arr[$faslug]['cnt'])
		$facount=$arr[$faslug]['cnt'];
		else
		$facount=0;
		$finalfarea[] = array('slug' => $faslug, 'name' => $faname , 'count' => $facount, 'faurl' => $faurl->__toString() );
	}
    return $finalfarea;
}

function local_scwgeneral_front_farea(){
    global $CFG, $OUTPUT;
    $fareas = local_scwgeneral_home_functional_area();
    $foddarea = array();
    $fevenarea = array();
    foreach($fareas as $k => $farea) {
        $params = array("profession" => "1", "country" => "",
                "industry" => "", "farea" => $farea["slug"]
            );
        $faurl = new moodle_url('/local/mylinks/search.php', $params);
        $faitem = '<li><a href="'.$faurl.'"><i class="fa fa-caret-right"></i>'.$farea["name"].' <span>'.$farea["count"].'</span></a></li>'."\n";
        if ($k % 2 == 0) {
            $fevenarea[] = $farea;
        } else {
            $foddarea[] = $farea;
        }
    }
    
	$fareatemplate = $OUTPUT->render_from_template('local_scwgeneral/farea', ['fodditems' => $foddarea, 'fevenitems' => $fevenarea]);
	return $fareatemplate;
}

function local_scwgeneral_check_scwsales($userid=null){
    global $USER;
    if (empty($userid) && is_siteadmin()) {
        return true;
    }
    $uid = empty($userid) ? $USER->id : $userid ;
	$syscontext = context_system::instance();
    $roles = get_user_roles($syscontext, $uid);
    foreach($roles as $role){
        if($role->shortname=="scwsales"){
            return true;
        }
    }
    return false;
}

function local_scwgeneral_check_scwadmin($userid=null){
    global $USER;
    if (empty($userid) && is_siteadmin()) {
        return true;
    }
	$uid = empty($userid) ? $USER->id : $userid ;
    $syscontext = context_system::instance();
    $roles = get_user_roles($syscontext, $uid);
    foreach($roles as $role){
        if($role->shortname=="scwadmin"){
            return true;
        }
    }
    return false;
}

function local_scw_get_months(){
    $months = array("" => "Month", 
            "jan" => "January", "feb" => "February", "mar" => "March", "april" => "April",
            "may" => "May", "june" => "June", "july" => "July", "august" => "August", "september" => "September",
            "october" => "October", "november" => "November", "december" => "December"
    );
	return $months;
}

function local_scw_get_years(){
    $myear = date("Y",time());
    $years = array("" => "Year");
    for($year=1970;$year<=$myear;$year++){
         $years[$year] = $year;
    }
    return $years;
}

function local_scw_valid_url($str)
{
	if (empty($str))
	{
		return FALSE;
	}
	elseif (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $str, $matches))
	{
		if (empty($matches[2]))
		{
			return FALSE;
		}
		elseif ( ! in_array(strtolower($matches[1]), array('http', 'https'), TRUE))
		{
			return FALSE;
		}

		$str = $matches[2];
	}

	// PHP 7 accepts IPv6 addresses within square brackets as hostnames,
	// but it appears that the PR that came in with https://bugs.php.net/bug.php?id=68039
	// was never merged into a PHP 5 branch ... https://3v4l.org/8PsSN
	if (preg_match('/^\[([^\]]+)\]/', $str, $matches) && ! is_php('7') && filter_var($matches[1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== FALSE)
	{
		$str = 'ipv6.host'.substr($str, strlen($matches[1]) + 2);
	}

	return (filter_var('http://'.$str, FILTER_VALIDATE_URL) !== FALSE);
}

function local_scw_general_companyinfo($userid,$fl=1){
    global $CFG,$OUTPUT,$DB;
    if(empty($userid)){
        return '';
    }
    $rcompanyinfo = $DB->get_records("user_company_info", array("user_id" => $userid),"currently_working desc,company_row desc");
	$company = array();
    $months = local_scw_get_months();
	foreach($rcompanyinfo as $companyinfo){
        $from = $months[$companyinfo->from_month].' '.$companyinfo->from_year;
        $to = $months[$companyinfo->to_month].' '.$companyinfo->to_year;
        $current = ($companyinfo->currently_working==1)? "Currently Working" : "Worked";
        $company[] = array("job" => $companyinfo->job_title,
            "cname" => $companyinfo->company,
		    "from" => $from,
		    "to" => $to,
		    "current" => $current
        );
    }
	
    if($fl==2){
       return $company; 
    }
    if(!empty($company)){
	    $companytemplate = $OUTPUT->render_from_template('local_scwgeneral/companyinfo', array('companyinfo' => $company));
        return $companytemplate;	
	}
    return '';
}

function local_scw_general_educationinfo($userid,$fl=1){
    global $CFG,$OUTPUT,$DB;
    if(empty($userid)){
        return '';
    }
    $reducationinfo = $DB->get_records("user_education_info", array("user_id" => $userid),"edu_row desc");
	$education = array();
    $countries = local_scwgeneral_get_countries();
	foreach($reducationinfo as $educationinfo){
        $from = $educationinfo->from_year;
        $to = $educationinfo->to_year;
        $country = isset($countries[$educationinfo->edu_country]) ? $countries[$educationinfo->edu_country] : '-';
        $education[] = array("institution" => $educationinfo->edu_institution,
            "city" => $educationinfo->edu_city,
			"country" => $country,
		    "from" => $from,
		    "to" => $to,
        );
    }
    if($fl==2){
       return $education; 
    }
    if(!empty($education)){
	    $educationtemplate = $OUTPUT->render_from_template('local_scwgeneral/educationinfo', array('educationinfo' => $education));
        return $educationtemplate;	
	}
    return '';
}

function local_scwgeneral_mylinks_name($userid, $profession){
	
    $name = "";
    if($profession==1){
        $companies = local_scw_general_companyinfo($userid,2);
        if (!empty($companies)) {
			foreach($companies as $company){
				if($company['current']=="Currently Working"){
					$name = "<span><b> ".$company["cname"]." </b></span>";	
					break;
				}else{
					$name = "<span><b> ".$company["cname"]." </b></span>";	
				}
			}
        }
    }

    if($profession==2){
        $education = local_scw_general_educationinfo($userid,2);
        if (!empty($education)) {
            $fedu = end($education);
            $name = "<span><b> ".$fedu["institution"]." </b></span>";	
        }
		
    }
    return $name;
}

function local_scwgeneral_cron(){
    global $DB;
    $now = new DateTime("now", core_date::get_server_timezone_object());
    $time = $now->getTimestamp();
    $time = $time - (60*24*60*60);

    // Banner Flush
    $DB->execute("UPDATE {local_scwbanner} SET banner_delete='1' WHERE banner_created <= '$time' ");

    // Interviews Flush
    $DB->execute("UPDATE {local_scwinterviews} SET interview_delete='1' WHERE interview_created <= '$time' ");

    //Videos
    $DB->execute("UPDATE {local_scwvideos} SET video_delete='1' WHERE video_created <= '$time'");

	// Events Flush
    $DB->execute("UPDATE {local_scwevents} SET event_delete='1' WHERE event_created <= '$time' ");	
}