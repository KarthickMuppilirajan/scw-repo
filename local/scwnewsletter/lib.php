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
 * @package local-scwnewsletter
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_scwnewsletter_pluginfile($course, $cm, $context, $filearea, $args,
                               $forcedownload, array $options=array()) {
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_scwnewsletter', $filearea, $args[0], '/', $args[1]);
    send_stored_file($file);
}

function scwnewsltter_send_newsletter($id,$user_type){
	global $DB,$CFG,$OUTPUT,$USER;
	$curr_user= $USER->id;
	
	$newsletter=scwnewsletter_get_message($id);
	

	if(in_array(3,$user_type)){
		$table="local_scwnewsletter_users";
		
		//$results = $DB->get_records($table,array('status' => $id));

		$results = $DB->get_records_sql('SELECT * FROM {local_scwnewsletter_users} WHERE status!=0');

		$supportuser = core_user::get_support_user();	
				
		foreach($results as $result){
			//setting dummy object for email_to_user required fields
			$emailuser = new stdClass;
			$emailuser->email=$result->subscriber_email;
			$emailuser->firstname=$result->subscriber_name;
			$emailuser->lastname=$result->subscriber_name;
			$emailuser->maildisplay = true;
			$emailuser->mailformat = 1;
			$emailuser->id=-99;
			$emailuser->firstnamephonetic=$result->subscriber_name;
			$emailuser->lastnamephonetic=$result->subscriber_name;
			$emailuser->middlename=$result->subscriber_name;
			$emailuser->alternatename=$result->subscriber_name;
			
			///////////////////////////send connection request email to concern user///////////////////////////	
			
			$usertype="subscriber";
			$message_final = scwnewsletter_message($emailuser->firstname,$newsletter['message'],$result->id,$usertype);
			email_to_user($emailuser, $supportuser, $newsletter['title'], $newsletter['message'], $message_final);
			set_time_limit(0);	
			
			
		}
		
		
	}
	if(in_array(2,$user_type)){
		
		$supportuser = core_user::get_support_user();		
		
		$sql ="SELECT U.*,UD.* FROM {user_details} UD JOIN {user} U ON (U.id=UD.user_id) WHERE UD.profession=2 AND U.suspended!='1' and  U.deleted != '1' AND UD.receive_newsletter='1' AND UD.approval_status = '1'";  
		 
		$results = $DB->get_records_sql($sql);
		
		foreach($results as $result){
			//setting object for email_to_user required fields
			

			$user = scwnewsletter_get_user($result->user_id); 
			///////////////////////////send connection request email to concern user///////////////////////////	
			$usertype="user";
			$message_final = scwnewsletter_message($user->firstname,$newsletter['message'],$user->id,$usertype);
			email_to_user($user, $supportuser, $newsletter['title'], $newsletter['message'], $message_final);
			set_time_limit(0);			
		}
		
	}
	
		if(in_array(1,$user_type)){
		
		$supportuser = core_user::get_support_user();		
		 $sql ="SELECT U.*,UD.* FROM {user_details} UD JOIN {user} U ON (U.id=UD.user_id) WHERE UD.profession=1 AND U.suspended!='1' and  U.deleted != '1' AND UD.receive_newsletter='1' AND UD.approval_status = '1'"; 
		 
		$results = $DB->get_records_sql($sql);
		foreach($results as $result){
			//setting  object for email_to_user required fields
			
			$user = scwnewsletter_get_user($result->user_id); 
			///////////////////////////send connection request email to concern user///////////////////////////	
			$usertype="user";
			$message_final = scwnewsletter_message($user->firstname,$newsletter['message'],$user->id,$usertype);
			email_to_user($user, $supportuser, $newsletter['title'], $newsletter['message'], $message_final);	
			set_time_limit(0);	
			
			
		}
		
	}
		
}
function scwnewsltter_insert_newsletter($user,$title,$message){
	global $DB,$CFG,$OUTPUT,$USER;
	$now = new DateTime("now", core_date::get_server_timezone_object());
	$time = $now->getTimestamp();

	$record = new stdClass();
	$record->title = $title;
	$record->message_editor = 'Welcome';
	$record->timecreated = $time;
	$record->user_id = $user;
	$lastinsertid = $DB->insert_record('local_scwnewsletter_messages', $record);
	return;
}

function scwnewsletter_get_user($user_id){
	global $DB,$CFG,$OUTPUT,$USER;
	$user = $DB->get_record('user', array('id'=>$user_id));
	return $user;
}

function scwnewsletter_message($firstname,$message,$user_id,$usertype){
		global $DB,$CFG,$OUTPUT,$USER;
		$CFG_url = $CFG->wwwroot;
		$message       = get_string('email_template', 'local_scwnewsletter', array("user" => $firstname, "message" => $message,"user_id"=>$user_id,'siteurl'=>$CFG_url,'user_type'=>$usertype));
		$messagehtml   = text_to_html($message);	
		return $messagehtml;
}

function scwnewsletter_get_message($id){
		global $DB,$CFG,$OUTPUT,$USER;
		$syscontext = context_system::instance();
		$newsletter = $DB->get_record('local_scwnewsletter_messages', array('id' => $id), '*', MUST_EXIST);
		$voptions = array('accepted_types' => '*',
		'maxbytes' => $CFG->maxbytes,
		'maxfiles' => EDITOR_UNLIMITED_FILES,
		'trusttext'=>false,
		'noclean'=>true,
	);
	$voptions['context'] = $syscontext;
	$voptions['subdirs'] = file_area_contains_subdirs($syscontext, 'local_scwnewsletter', 'message', $newsletter->id);
	
	$newsletter_content = file_rewrite_pluginfile_urls($newsletter->message, 'pluginfile.php', $syscontext->id, 'local_scwnewsletter', 'message', $newsletter->id);
	$newsletter_content = format_text($newsletter_content, $newsletter->message, $voptions, $newsletter->id);
	
	$arr_newsletter = array();
	$arr_newsletter['title'] = $newsletter->title;
	$arr_newsletter['message'] = $newsletter_content;
	
	return $arr_newsletter;
	
}
function scwnewsletter_unsubscribe($id,$type){
	global $DB,$CFG,$OUTPUT,$USER;
	if($type=="subscriber")
	{

		$sql ="SELECT COUNT(id) FROM {local_scwnewsletter_users} WHERE id=$id AND status=1"; 
		$row = $DB->count_records_sql($sql); 
		if($row>0){
			$obj = new stdClass();
			$obj->id = $id;
			$obj->status = 0;
			$res= $DB->execute("UPDATE {local_scwnewsletter_users} SET status = 0 WHERE id=$id");
				return true;
			}else{
				return false;
			}
	}
	else{
		$sql ="SELECT COUNT(user_id) FROM {user_details} WHERE user_id=$id AND receive_newsletter=1"; 
		$row = $DB->count_records_sql($sql); 
		if($row>0){
		$obj = new stdClass();
		$obj->user_id = $id;
		$obj->receive_newsletter = 0;
		$res= $DB->execute("UPDATE {user_details} asm SET receive_newsletter = 0 WHERE user_id=$id");
			return true;
		}else{
			return false;
		}
		
	}
	
}
?>