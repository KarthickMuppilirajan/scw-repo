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
 * @package local-scwmail
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_scwmail_get_connected_users(){
	global $DB,$CFG,$OUTPUT,$USER;
	$userid = $USER->id;

		 $sql=" SELECT u.*,ue.connection_status as status FROM {user} u JOIN {local_mylinks} ue ON (u.id=ue.connected_id) WHERE ue.connection_status = 1 AND u.id NOT IN(1,2,$userid) AND ue.user_id=$userid"; 
		$result = $DB->get_records_sql($sql);
		return $result;
}

function local_scwmail_create_index($userid, $type,$message_id,$time) {
        global $DB;

        $record = new stdClass;
        $record->user_id = $userid;
        $record->type = $type;
        $record->message_id = $message_id;
		$record->time = $time;
		$record->unread = 0;

        $DB->insert_record('local_scw_mail_index', $record);
    }
 function local_scwmail_add_recipient($role, $userid,$messageid) {
        global $DB;

        assert(in_array($role, array('to', 'cc', 'bcc')));

        $record = new stdClass;
        $record->message_id = $messageid;
        $record->user_id = $userid;
        $record->role =  $role;
        $record->unread = 0;
        $record->starred =  0;
        $record->deleted =  0;
        $DB->insert_record('local_scw_mail_messages_user', $record);
    }	
	
function local_scwmail_fetch_index($userid, $type,$per_page,$offset) {
		global $DB,$CFG,$USER;
		$url = $CFG->wwwroot.'/local/scwmail/compose.php';
		$userid = $USER->id;
		$output="";
		
		//$output = '<br/><h4>Mail box</h4>';
		//$output .= '<br/><button class="btn btn-ash btn-delete">Delete</button>  <a href="'.$url.'"><button class="btn btn-sm btn-ashblk pull-right">Compose mail</button></a>';
		$table = new html_table();
		$table->head = array ();
        $table->colclasses = array();
		$table->rowclasses = array();
		$table->head[] = '<input type="checkbox" name="delete" class="delete_mail">';
        $table->head[] = "Date";
        $table->attributes['class'] = 'table mailbox';
		$table->head[] = "From";
		$table->head[] = "Subject";
		$table->head[] = "Message";
		//$table->head[] = "View";
		
		$ctable = 'local_scw_mail_index';
		$conditions = array('user_id' => $userid, 'type' => $type);
		
		
         $sql = "SELECT m.id, m.subject, m.content, m.draft, DATE_FORMAT(FROM_UNIXTIME(m.time), '%m/%d/%y %h:%i:%s') AS 'time',mi.message_id,mi.unread,mi.id AS 'indexid' FROM {local_scw_mail_messages} m JOIN {local_scw_mail_index} mi ON m.id=mi.message_id AND mi.user_id=$userid WHERE mi.type='inbox' AND m.time >= UNIX_TIMESTAMP(DATE(NOW() - INTERVAL 60 DAY)) GROUP BY mi.message_id ORDER BY m.time DESC LIMIT $offset ,$per_page";
		 
        $result = $DB->get_records_sql($sql);
		
		if($result){
				
			foreach ($result as $crow) {
				$id = $crow->message_id;
				$indexId= $crow->indexid;
				$sentuser=local_scwmail_fetch_sent_user($id);
				// check for deleted users
				if(empty($sentuser)) continue;
				$unreead= local_scwmail_get_mail_status($id);
				$unreead = $unreead->unread;
				if($unreead=='0'){
					$table->rowclasses[]='bold';
				}else{
					$table->rowclasses[]='';
				}
				$deleted = local_scwmail_get_mail_status($id);
				$deleted = $deleted->deleted;
				if($deleted==1)
				continue;
				$row = array();
				$row[] = '<input type="checkbox" name="delete[]" class="message_id" value="'.$id.'"> <input type="hidden"  name="message_id[]" value="'.$id.'">';
				$row[] = ucfirst($crow->time);
				$row[] = $sentuser->firstname;
				$row[] = $crow->subject;
				$row[] = substr($crow->content, 0, 50); 
				//$row[] = '<a href="view.php?msg_id='.$id.'"><p>View <span class="glyphicon glyphicon-eye-open"></span></p></a>';
	
				$table->data[] = $row;
			}
		}
		else{
			$row = array();
				$row[] = '';
				$row[] = '';
				$row[] = '<b style="color:red">You do not have any mail</b>';
				$row[] = '';
				$row[] = '';
				$row[] = '';
				$table->data[] = $row;
		}
		//$row = array ();
		//$table->data[] = $row;
		
		$output .= html_writer::start_tag('form', array('name'=>'msg_delete','id'=>'msg_delete','action'=>'delete.php','method'=>'post'));
		$output .='<input type="hidden" name="message_id" class="delete_msg_id" value="">';
		$output .='<input type="hidden" name="action" value="delete">';
		$output .= html_writer::end_tag('form');
		$output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
        $output .= html_writer::table($table);
        $output .= html_writer::end_tag('div');
		return $output;
    }	

function local_scwmail_fetch_mail($userid, $type,$msg_id) {
global $DB,$CFG,$USER,$OUTPUT;
		$url = $CFG->wwwroot.'/local/scwmail/compose.php';
		$inbox = $CFG->wwwroot.'/local/scwmail/index.php';
		$userid = $USER->id;
        $page = optional_param('page','0',PARAM_INT);

		
		$ctable = 'local_scw_mail_index';
		$conditions = array('user_id' => $userid, 'type' => $type);
		
		$output="";
		$cc_user_name="";
		
         $sql = "SELECT m.id, m.subject, m.content, m.draft, DATE_FORMAT(FROM_UNIXTIME(m.time), '%m/%d/%y %h:%i:%s') AS 'time',mi.message_id,mi.unread,mi.id AS 'indexid' FROM {local_scw_mail_messages} m JOIN {local_scw_mail_index} mi ON  m.id=mi.message_id AND mi.user_id=$userid WHERE m.id=$msg_id AND  mi.type='inbox' AND m.time >= UNIX_TIMESTAMP(DATE(NOW() - INTERVAL 60 DAY)) GROUP BY mi.message_id ORDER BY m.time DESC";
		 
        $result = $DB->get_records_sql($sql);
		
		if($result){
			
			foreach ($result as $crow) {
				$id = $crow->id;
				$indexid= $crow->indexid;
				$user=local_scwmail_fetch_sent_user($msg_id);
				$cc= local_scwmail_get_to_cc($id);
				$to_user_name=array();
				$cc_user_name=array();
				foreach($cc as $to){
					if($to->role=="bcc"){
						$cc_user=local_scwmail_get_user_details($to->user_id);
						if($to->user_id==$userid){
							$cc_user_name[]="Me";
						}else{
							$cc_user_name[]=$cc_user->firstname;
						}
					}
					
					if($to->role=="to"){
						
						$to_user=local_scwmail_get_user_details($to->user_id);							
						if($to->user_id==$userid){
							$to_user_name[]="Me";
						}else{
							$to_user_name[]=$to_user->firstname;
						}
					}
				}
				$connection_info= local_scwmail_get_connection_status($user->user_id);
				if($connection_info==1){
					$replybtn='<div class="btn-group">
									<a href="compose.php?reply_to='.$id.'" class="btn btn-sm btn-brown">Reply</a>
								</div>';
				}else{
					$replybtn="";
				}
					$prof = new stdClass;
					$prof = local_scwmail_get_user($user->user_id);
					if(!empty($cc_user_name)){
						$cc_user_name = implode(",",array_reverse($cc_user_name));
						$cc_display='<h6>CC: '.$cc_user_name.'</h6>';
					}else{
						$cc_display="";
					}

				$output='
					<div class="container-fluid well col-md-12">
						<div class="row-fluid">
							<div class="col-md-6">
								<a href="'.$CFG->wwwroot.'/local/mylinks/profile.php?user_id='.$prof->id.'">'.$OUTPUT->user_picture($prof, array('size'=>64, 'alttext'=>false,'link'=>false)).'</a>
								<a href="'.$CFG->wwwroot.'/local/mylinks/profile.php?user_id='.$prof->id.'"><h3>'.$user->firstname.'</h3></a>
								<h6>'.$crow->time.'</h6>
								<h6>To: '.implode(",",array_reverse($to_user_name)).'</h6>
								'.$cc_display.'
								
							</div>

							
							<div class="col-md-6">
							<div class="pull-right">
							
									<form name="msg_delete" class="form-submit" id="msg_delete" action="delete.php" method="post">
										<input name="message_id" class="delete_msg_id" value="'.$id.'" type="hidden">
										<input name="action" value="delete" type="hidden">
										<div class="btn-group">
											<button class="btn btn-sm btn-brown delete-view" data-id="'.$id.'" type="button">Delete</button>
										</div>
										'.$replybtn.'
										<div class="btn-group">
											<a class="btn btn-sm btn-brown" type="button" href="'.$inbox.'">Back to Inbox</a>
										</div>
										
									</form>			
								</div>

							</div>		
								
							
							<div class="col-md-12 mail-details">
								<h3>'.$crow->subject.'</h3>
								<h6>'.$crow->content.'</h6>
							</div>												
							
					</div>
					</div>
					
				';
			
			}
		
		}
		return $output;	
	
}
	
function local_scwmail_fetch_sent_user($message_id){
	global $DB,$CFG,$USER;
			 $sql ="SELECT * FROM {user} u  JOIN  {local_scw_mail_index} mi  ON (mi.message_id=$message_id) AND (u.id=mi.user_id) WHERE mi.type = 'sent' AND u.deleted != '1' GROUP BY u.id";
			//$sql=" SELECT * FROM {local_scw_mail_index} mi JOIN {user} u ON (mi.user_id=u.id) WHERE mi.type = 'sent' and mi.message_id=$message_id";  
			$user = $DB->get_record_sql($sql);
			return $user;
}
function local_scwmail_get_to_cc($msg_id){
	global $DB,$CFG,$USER;
			$sql=" SELECT * FROM {local_scw_mail_messages_user} WHERE message_id=$msg_id";  
			$cc = $DB->get_records_sql($sql);
			return $cc;	
}
function local_scwmail_get_user_details($user_id){
	global $DB,$CFG,$USER;
			$sql=" SELECT * FROM  {user} WHERE id = $user_id";  
			$user = $DB->get_record_sql($sql);
			return $user;	
}
function local_scwmail_get_reply($msg_id,$user_id){
	global $DB,$CFG,$USER;
	$mail = new stdClass;
			$sql=" SELECT * FROM {local_scw_mail_messages} m JOIN {local_scw_mail_index} mi ON (mi.message_id=m.id) WHERE mi.message_id=$msg_id AND type = 'inbox'";  
			$mail_inbox = $DB->get_record_sql($sql);
			
			$sql=" SELECT m.*,mi.user_id AS user FROM {local_scw_mail_messages} m JOIN {local_scw_mail_index} mi ON (mi.message_id=m.id) WHERE mi.message_id=$msg_id AND type = 'sent'";  
			$mail_sent = $DB->get_record_sql($sql);
			
			if (strpos($mail_inbox->subject, 'RE:') === false) {
				$subject="RE:".$mail_inbox->subject;
			}else{
				$subject=$mail_inbox->subject;
			}
			
			$mail->subject=$subject;	
			$mail->user_id=$mail_sent->user;
			return $mail;
}
function local_scwmail_get_inbox_count($userid,$type){
		global $DB,$CFG,$USER;
		 $sql = "SELECT m.id, m.subject, m.content, m.draft, DATE_FORMAT(FROM_UNIXTIME(m.time), '%m/%d/%y %h:%i:%s') AS 'time',mi.message_id,mi.unread,mi.id AS 'indexid' FROM {local_scw_mail_messages} m JOIN {local_scw_mail_index} mi ON m.id=mi.message_id AND mi.user_id=$userid WHERE mi.type='inbox' GROUP BY mi.message_id ORDER BY m.time DESC";		
		 $records = $DB->get_records_sql($sql);
		 return count($records);	
}

function local_scwmail_update_unread_mail($userid,$type,$msg_id){
	global $DB,$CFG,$USER;
	$userid = $USER->id;
	//$update = $DB->execute("UPDATE {local_scw_mail_index} SET `unread` = '1' WHERE `message_id` = '$msg_id' AND `type`='$type'");
	$update = $DB->execute("UPDATE {local_scw_mail_messages_user} SET `unread` = '1' WHERE `message_id` = '$msg_id' AND user_id=$userid AND (role='to' OR role='bcc')");
		return $update;
}
function local_scwmail_get_mail_status($msg_id){
	global $DB,$CFG,$USER;
	$userid = $USER->id;
	//$update = $DB->execute("UPDATE {local_scw_mail_index} SET `unread` = '1' WHERE `message_id` = '$msg_id' AND `type`='$type'");
	$result = $DB->get_record_sql("SELECT `unread`,`deleted` from {local_scw_mail_messages_user} WHERE `message_id` = '$msg_id' AND user_id=$userid AND (role='to' OR role='bcc')");
	return $result;
}
 function local_scwmail_get_connection_status($user_id){
		global $DB,$CFG,$OUTPUT,$USER;
		$userid = $USER->id;
		$ctable = 'local_mylinks';
		$result = $DB->get_record_sql("SELECT connection_status from {local_mylinks} WHERE connected_id = $user_id AND user_id=$userid");
		if($result)
		return $result->connection_status;
	}

function local_scwmail_get_user($user_id){
	global $DB,$CFG,$OUTPUT,$USER;
	$user = $DB->get_record('user', array('id'=>$user_id));
	return $user;
}

function get_scwmail_notification_status($user_id){
	global $DB,$CFG,$OUTPUT,$USER;
	$result = $DB->get_record_sql("SELECT receive_email from {user_details} WHERE user_id = $user_id");
	if($result)
		return $result->receive_email;
}