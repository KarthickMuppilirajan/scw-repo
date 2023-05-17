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

require("../../config.php");
require_once('compose_form.php');
require_once('lib.php');

require_login(); 

global $PAGE,$USER;
$userid = $USER->id;
$reply_to = optional_param('reply_to', 0, PARAM_INT);
$user_id = optional_param('user_id', 0, PARAM_INT);

if($reply_to){
	$mail=local_scwmail_get_reply($reply_to,$userid);
	$mail->to=$mail->user_id;
	
}else{
	$mail = new stdClass;
	$mail->id=null;
	$mail->user_id = null;
}


$title = 'My mail';
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();


$site = get_site();
$fullname = $site->fullname;
$systemcontext = context_system::instance();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwmail/index.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$url = $CFG->wwwroot.'/local/scwmail/index.php';

$textfieldoptions = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=> 2, 'maxbytes'=> $CFG->maxbytes, 'context' => $systemcontext,'enable_filemanagement' => false);

$args = array(
        'editoroptions' => $textfieldoptions,
		'user_id' => $user_id
    );
	
$composeform = new mail_compose_form(null,$args);

$composeform->set_data($mail);

if ($composeform->is_cancelled()) {
	redirect($CFG->wwwroot.'/local/scwmail/index.php');
}else if ($maildata = $composeform->get_data()) {
	//echo "Data Fetch";
	
	$mail = new stdClass;
	$mail->subject = $maildata->subject;
	$mail->content = $maildata->message['text'];
	$mail->time = $time ;
	
    if (!empty($userid)) {
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

			foreach($maildata->to as $key=>$value){ 
				if($value){
					local_scwmail_create_index($value, 'inbox',$mail->id,$time);
					local_scwmail_add_recipient('to',$value,$mail->id);
				}
			}
			if(!empty($maildata->bcc)){
				foreach($maildata->bcc as $key=>$value){ 
					if($value) {
						local_scwmail_create_index($value, 'inbox',$mail->id,$time);
						local_scwmail_add_recipient('bcc',$value,$mail->id);
					}
				}	
			}
		}
		
		$msg = 'Your message has been sent.';
		redirect($url, $msg);
    } 

}

/**
 * // $PAGE->set_heading($title);
 */

echo $OUTPUT->header();
echo "<br><h3> Compose</h3>";
$composeform->display();

echo $OUTPUT->footer();
?>
<script type="text/javascript">
require(['jquery'], function( $ ) {
setTimeout(function(){
	console.log(tinymce.editors.length);
	if(tinymce.editors.length>0)
	 $('.mceButton.mce_image,.mceButton.mce_moodlemedia').remove(); 
}, 2000);
	

	
});
</script>