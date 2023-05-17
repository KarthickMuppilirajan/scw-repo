<?php
require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/authlib.php');
require_once($CFG->dirroot.'/user/filters/lib.php');
require_once($CFG->dirroot.'/user/lib.php');

global $PAGE,$USER,$DB;

require_login();
$yes_flush = optional_param('yes_flush','',PARAM_TEXT);

if(!confirm_sesskey()){
  redirect($CFG->wwwroot.'/');
}

$PAGE->set_context(context_system::instance());

$cond = (local_scwgeneral_check_scwsales() || local_scwgeneral_check_scwadmin()); 
if($cond){
	
	if($yes_flush=="Yes"){
		// Banner Flush
        $DB->execute("UPDATE {local_scwbanner} SET banner_delete='1' ");
		// Interviews Flush
		$DB->execute("UPDATE {local_scwinterviews} SET interview_delete='1' ");
		//Videos
		$DB->execute("UPDATE {local_scwvideos} SET video_delete='1' ");
		// Events Flush
		$DB->execute("UPDATE {local_scwevents} SET event_delete='1' ");
		
		// Delete USER
		$users = get_users_listing();
		
		foreach($users as $cuser){
			$cond = ( local_scwgeneral_check_scwsales($cuser->id) || local_scwgeneral_check_scwadmin($cuser->id) || is_siteadmin($cuser->id) );
			if($cond){
				continue;
			}
			$user = $DB->get_record('user', array('id' => $cuser->id, 'deleted' => 0), '*', MUST_EXIST);
			user_delete_user($user);
		}
		
		// Delete Newsletter and Subscribers
		$DB->delete_records('local_scwnewsletter_users');
		$DB->delete_records('local_scwnewsletter_messages');
		$DB->delete_records('local_scw_mail_index');
		$DB->delete_records('local_scw_mail_messages');
		$DB->delete_records('local_scw_mail_messages_user');
		$DB->delete_records('local_mylinks');
		
		//$DB->execute("TRUNCATE TABLE {local_scwnewsletter_users}");
		//$DB->execute("TRUNCATE TABLE {local_scwnewsletter_messages}");
		
		
		redirect($CFG->wwwroot.'/my','Successfully flushed site data');
	}
	
}else{
	redirect($CFG->wwwroot.'/');
} ?>