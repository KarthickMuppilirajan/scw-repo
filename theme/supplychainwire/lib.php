<?php
// This file is part of The Bootstrap Moodle theme
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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package theme_supplychainwire
 * @author Fourbends Dev Team (http://www.fourbends.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function scw_grid($hassidepre, $hassidepost) {

    if ($hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-6 col-sm-push-3 col-lg-8 col-lg-push-2');
        $regions['pre'] = 'col-sm-3 col-sm-pull-6 col-lg-2 col-lg-pull-8';
        $regions['post'] = 'col-sm-3 col-lg-2';
    } else if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-9 col-sm-push-3 col-lg-10 col-lg-push-2');
        $regions['pre'] = 'col-sm-3 col-sm-pull-9 col-lg-2 col-lg-pull-10';
        $regions['post'] = 'emtpy';
    } else if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-9 col-lg-10');
        $regions['pre'] = 'empty';
        $regions['post'] = 'col-sm-3 col-lg-2';
    } else if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-12');
        $regions['pre'] = 'empty';
        $regions['post'] = 'empty';
    }

    if ('rtl' === get_string('thisdirection', 'langconfig')) {
        if ($hassidepre && $hassidepost) {
            $regions['pre'] = 'col-sm-3  col-sm-push-3 col-lg-2 col-lg-push-2';
            $regions['post'] = 'col-sm-3 col-sm-pull-9 col-lg-2 col-lg-pull-10';
        } else if ($hassidepre && !$hassidepost) {
            $regions = array('content' => 'col-sm-9 col-lg-10');
            $regions['pre'] = 'col-sm-3 col-lg-2';
            $regions['post'] = 'empty';
        } else if (!$hassidepre && $hassidepost) {
            $regions = array('content' => 'col-sm-9 col-sm-push-3 col-lg-10 col-lg-push-2');
            $regions['pre'] = 'empty';
            $regions['post'] = 'col-sm-3 col-sm-pull-9 col-lg-2 col-lg-pull-10';
        }
    }
    return $regions;
}

function theme_supplychainwire_page_init(moodle_page $page) {
    //$page->requires->jquery();
	//$page->requires->js('/theme/supplychainwire/javascript/jquery.form.js');
    $page->requires->js('/theme/supplychainwire/javascript/custom.js');
	$page->requires->js('/lib/cookies.js');
}

function theme_supplychainwire_get_inbox_count($userid,$type){
    global $DB,$CFG,$USER;
    $sql = "SELECT *FROM {local_scw_mail_messages_user} WHERE `unread` = '0'  AND `user_id`=$userid AND (`role`='to' OR role='bcc')";		
    $records = $DB->get_records_sql($sql);
    return count($records);	
}

function theme_supplychainwire_get_pending_connect($userid){
    global $DB,$CFG,$USER;
    $sql = "SELECT * FROM {local_mylinks} WHERE user_id='$userid' AND connection_status=0 AND action='received'";		
    $records = $DB->get_records_sql($sql);
    return count($records);		
}

function theme_supplychainwire_check_profile(){
    global $DB, $CFG, $USER, $PAGE;
    $ptype = $PAGE->pagetype;
    $prfurl = $CFG->wwwroot.'/user/editprofile.php';
    $fillmsg = get_string('filldetails', 'local_scwgeneral');
	$skippages = array("user-editprofile", "user-ajx-add-more","local-scwmail-refresh_mail","local-mylinks-refresh_link");
	
	if(in_array($ptype,$skippages)){
        return '';
	}
    if (isloggedin() and !isguestuser()) {
        $user = $DB->get_record('user', array('id' => $USER->id), '*', MUST_EXIST);		
	    require_once($CFG->dirroot."/local/scwgeneral/lib.php");
        $cond = ( local_scwgeneral_check_scwsales() || local_scwgeneral_check_scwadmin());
        if(!$cond){
            $userdetails = $DB->get_record('user_details',array("user_id" => $USER->id));
			if(!empty($userdetails)){
                $companyinfo = local_scw_general_companyinfo($USER->id, 2);
                $educationinfo = local_scw_general_educationinfo($USER->id, 2);
                $ncm = $userdetails->no_company;
                $ned = $userdetails->no_education;
				
				// check company info
				if($userdetails->profession=="1"){
                    if($ncm!=count($companyinfo)){
                        redirect($prfurl, $fillmsg);
					}
                    if($ncm==count($companyinfo)){
                        foreach($companyinfo as $company){
                            $job = $company["job"];
                            $cname = $company["cname"];
							$ccnd = (empty($job) || empty($cname));
                            if ($ccnd) {
                                redirect($prfurl, $fillmsg);
                            }
                        }
                    }
                    $cndfarea = ( empty($userdetails->functional_area) || empty($userdetails->industry) );
                    if($cndfarea){
                        redirect($prfurl, $fillmsg);
                    }
				}
				
                if($userdetails->profession=="2"){
                    if( empty($userdetails->sniff_keyword) ){
                        redirect($prfurl, $fillmsg);
                    }
                }
				
                // Check company info end, Check education info start.

                if($ned!=count($educationinfo)){
                    redirect($prfurl,'Please fill the details');
                }
                if($ned==count($educationinfo)){
                    foreach($educationinfo as $education){
                        $institution = $education["institution"];
                        $city = $education["city"];
						$country = $education["country"];
                        $ecnd = (empty($institution) || empty($city) || empty($country));
                        if ($ecnd) {
                            redirect($prfurl, $fillmsg);
                        }
                    }
                }
                // Check education info end, Check basic fields.
				
                $chkcond1 = ( empty($user->firstname) || empty($user->lastname) || empty($user->phone1) );
                $chkcond2 = ( empty($user->country) || empty($user->city) || empty($user->phone1) || empty($userdetails->summary));
				
                if($chkcond1 || $chkcond2){
                    redirect($prfurl, $fillmsg);
                }

			}
	    }
    }else{
		return '';
	}
}
