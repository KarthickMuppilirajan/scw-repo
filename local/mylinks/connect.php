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
 * Support local plugin.
 *
 * @package    local_mylinks
 * @copyright  2016 Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
define('AJAX_SCRIPT', true);

require_once('../../config.php');
require_once($CFG->dirroot.'/local/scwmail/lib.php');
require_login(); 
global $PAGE;

$PAGE->set_context(context_system::instance());
$connecter_id = required_param('connecter_id', PARAM_RAW);
$connected_id = optional_param('connected_id', 0, PARAM_INT);
$action = required_param('action', PARAM_RAW);

$userid = $USER->id;
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$msg_arr = array();

if($connecter_id && $action=="connect"){
	$connecter = new stdClass;
	$connecter->id = null;
	$connecter->user_id=$userid;
	$connecter->connected_id=$connecter_id;
	$connecter->connected_time=$time;
	$connecter->action='sent';
	$connecter->block_notes='';
	
	$query_insert = $DB->insert_record('local_mylinks',$connecter);
	if($query_insert){
		
	$connecter = new stdClass;
	$connecter->id = null;
	$connecter->user_id=$connecter_id;
	$connecter->connected_id=$userid;
	$connecter->connected_time=$time;
	$connecter->connection_status=0;
	$connecter->action='received';
	$connecter->block_notes='';
	
	$query_insert = $DB->insert_record('local_mylinks',$connecter);		
	
	$sent_user=local_scwmail_get_user_details($userid);
	$connecting_user=local_scwmail_get_user_details($connecter_id);
	$mail_notification_status=get_scwmail_notification_status($connecter_id);
	
	$mergeduser = new stdClass();
	$mergeduser->sentuser=$sent_user->firstname;
	$mergeduser->receiveuser= $connecting_user->firstname;
	$mergeduser->sentuser_id= $sent_user->id;
	$mergeduser->profile_link= $CFG->wwwroot."/local/mylinks/profile.php?user_id=".$sent_user->id;
	
	$mail = new stdClass;
	$mail->subject = get_string('connect_mail_subject','local_mylinks',$sent_user);
	$mail->content = get_string('connect_mail_content_inbox', 'local_mylinks',$mergeduser);
	$mail->time = $time ;
	
    if (!empty($sent_user->id)) {
        $msg_id = $DB->insert_record('local_scw_mail_messages', $mail);
		$mail->id = $msg_id;
		if($mail->id){
			$mail->message_id = $mail->id;
			$mail->user_id = $userid;
			$mail->role = 'from';
			$mail->unread = 0;
			$mail->starred =  0;
			$mail->deleted =  0;			
			$message_id = $DB->insert_record('local_scw_mail_messages_user', $mail);
			
			local_scwmail_create_index($userid, 'sent',$mail->id,$time);
			local_scwmail_create_index($connecter_id, 'inbox',$mail->id,$time);
			local_scwmail_add_recipient('to',$connecter_id,$mail->id);
			
			///////////////////////////send connection request email to concern user///////////////////////////	
			if($mail_notification_status==1){
				$supportuser = core_user::get_support_user();	
				$subject = get_string('connect_mail_subject','local_mylinks',$sent_user);
				$message       = get_string('connect_mail_content', 'local_mylinks',$mergeduser);
				$messagehtml   = text_to_html($message);
				email_to_user($connecting_user, $supportuser, $subject, $message, $messagehtml);
			}
		}
	}
	
		$msg_arr['message']  = "sent";
		echo json_encode($msg_arr);
	}

}else{
	$update_sent = $DB->execute("UPDATE {local_mylinks} SET `connection_status` = '1' WHERE `connected_id` = '$connecter_id' AND `user_id`=$connected_id");
	
	$update_received = $DB->execute("UPDATE {local_mylinks} SET `connection_status` = '1' WHERE  `connected_id`='$connected_id' AND `user_id`='$connecter_id'");		
	$msg_arr['message']  = "connected";
		echo json_encode($msg_arr);
}

?>