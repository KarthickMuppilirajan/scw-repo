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
 * @package    local_support
 * @copyright  2016 Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../config.php');
require_once($CFG->libdir.'/authlib.php');
require_once(__DIR__ . '/lib.php');
global $CFG, $DB, $PAGE;

require_login();


$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->set_title('SCW Users approve');
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/login/admin_approve.php');

$eventids = optional_param('event_ids','0', PARAM_TEXT);
$eventact = optional_param('event_action','0', PARAM_TEXT);

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
/*
if(empty($eventids)){
	print_error('errordata');
}
*/
$action = optional_param('action','0',PARAM_INT);
$id = optional_param('id','0',PARAM_INT);
$user_record=$DB->get_record('user', array('id' => $id));
$user_details_record = $DB->get_record('user_details', array('user_id' => $user_record->id));
$return_url=$CFG->wwwroot .'/login/scwuser.php';
$mailsent=0;
if($action==4)
{
	$aeventids = explode(",",$eventids);
	if($eventact=='dissaprove')
	{
		foreach ($aeventids as $eid) {		
		unset($user_record);
		unset($user_details_record);
		$user_record=$DB->get_record('user', array('id' => $eid));
		$user_record->confirmed=0;
		$sql = $DB->update_record('user', $user_record);	
		
		$user_details_record = $DB->get_record('user_details', array('user_id' => $user_record->id));
		$user_details_record->approval_status=0;
		$sql1 = $DB->update_record('user_details', $user_details_record);				
		$mailsent=1;
	}
	}
	else
	{
		foreach ($aeventids as $eid) {		
		unset($user_record);
		unset($user_details_record);
		$user_record=$DB->get_record('user', array('id' => $eid));
		$user_record->confirmed=1;
		$sql = $DB->update_record('user', $user_record);	
		
		$user_details_record = $DB->get_record('user_details', array('user_id' => $user_record->id));
		$user_details_record->approval_status=1;
		$sql1 = $DB->update_record('user_details', $user_details_record);		
		
		unset($user_record);
		$user_record=$DB->get_record('user', array('id' => $eid));
		/*		echo '<pre>';
		print_r($user_record);
		echo '</pre>';*/
		
		$user=$user_record;
		$resetrecord = core_login_generate_password_reset($user);
		$sendresult = send_password_change_confirmation_email_new($user, $resetrecord);		
		$mailsent=1;
	}
	}
	
	

}
if($action==1)
{

	/*echo '<pre>';
	print_r($user_record);
	exit;*/
	$user_record->confirmed=1;
	$sql = $DB->update_record('user', $user_record);	
	
	$user_details_record->approval_status=1;
	$sql1 = $DB->update_record('user_details', $user_details_record);

	if($user_record)
	{
		unset($user_record);
		$user_record=$DB->get_record('user', array('id' => $id));
/*		echo '<pre>';
		print_r($user_record);
		echo '</pre>';*/
//		core_login_process_password_reset_request_new($user_record);/////////////////////////send forgot password mail by email	
		$user=$user_record;
		$resetrecord = core_login_generate_password_reset($user);
		$sendresult = send_password_change_confirmation_email_new($user, $resetrecord);		
		$mailsent=1;
	}
}
if($action==3)
{

	/*echo '<pre>';
	print_r($user_record);
	exit;*/
	$user_record->confirmed=0;
	$sql = $DB->update_record('user', $user_record);	
	
	$user_details_record->approval_status=0;
	$sql1 = $DB->update_record('user_details', $user_details_record);
	$mailsent=1;
}
if($action==2)
{
///////////////////////////payment mail to recent graduates///////////////////////////	
	if($user_record)
	{

	$user_details_record->payment_url_creation = $time;
	$sql1 = $DB->update_record('user_details', $user_details_record);

	$supportuser = core_user::get_support_user();	
    $data = new stdClass();	
    $user = $user_record;	
	$subject = get_string('payment_mail_subject');
	$data->name =  $user->firstname.' '.$user->lastname;
    $data->link  = $CFG->wwwroot .'/login/payment.php?random_url='. $user_details_record->random_url;
	$data->amount =  '60.00';
    $message       = get_string('payment_mail_content', '', $data);
    $messagehtml   = text_to_html($message);
/*	echo '<pre>';
	print_r($subject);
	print_r($user);
	print_r($supportuser);
	print_r($data);
	print_r($messagehtml);
	exit;*/
    // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
	//email_to_user($user, $from, $subject, $messagetext, $messagehtml = '', $attachment = '', $attachname = '',$usetrueaddress = true, $replyto = '', $replytoname = '', $wordwrapwidth = 79)
	if(email_to_user($user, $supportuser, $subject, $message, $messagehtml))
	$mailsent=1;
	}
}

echo $OUTPUT->header();
if($mailsent)
if($action==3)
echo '<h1>User Disapproved</h1><a href="'.$return_url.'">Back</a>';	
elseif($action==2)
echo '<h1>Mail sent</h1><a href="'.$return_url.'">Back</a>';	
elseif($action==1)
echo '<h1>User Approved</h1><a href="'.$return_url.'">Back</a>';	
elseif($action==4)
{
	if($eventact=='dissaprove')
	echo '<h1>User[S] Disapproved</h1><a href="'.$return_url.'">Back</a>';	
	else
	echo '<h1>User[S] Approved</h1><a href="'.$return_url.'">Back</a>';	
}

echo $OUTPUT->footer();
?>
<script type="text/javascript">
require(['jquery'], function( $ ) {	
});
</script>
