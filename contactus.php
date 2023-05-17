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

require("config.php");
require_once('contactus_form.php');
require_once($CFG->dirroot.'/local/scwgeneral/lib.php');
global $PAGE,$USER;

$title = 'Contact Us';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/contactus.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();


$contactus_form = new contactus_form();
$mailsend=0;
if ($cnddata = $contactus_form->get_data()) {
	$firstname = $cnddata->firstname;
	$lastname = $cnddata->lastname;
	$registered = $cnddata->registered;
	$email = $cnddata->email;
	$country = $cnddata->country;
	$message = $cnddata->message;
	$date=date('m-d-Y',$time);
	$mail.='<p>&nbsp;</p>';
	$mail.='<b>Name: </b>'.$firstname.' '.$lastname;
	$mail.='<p>&nbsp;</p>';
	$mail.='<b>'.get_string('registered_status').': </b>';
	$mail.=($registered=="1") ? "Yes":"No";
	$mail.='<p>&nbsp;</p>';
	$mail.='<b>Email: </b>'.$email;
	$mail.='<p>&nbsp;</p>';
	$countries = local_scwgeneral_get_countries();
	$mail.='<b>Country: </b>'.$countries[$country];
	$mail.='<p>&nbsp;</p>';
	$mail.='<b>Message: </b>'.nl2br($message);	
	///////////////////////////contact us mail///////////////////////////	
    $supportuser = core_user::get_support_user();	
    $data = new stdClass();	
    $user = new stdClass();	
	
	$user->firstname='admin';
	$user->lastname='User';
	$user->email='info@supplychainwir.com';	
	$user->id=1;
    $user->mailformat = 1;  // Always send HTML version as well.

	$data->name =  $user->firstname.' '.$user->lastname;
	$data->mail =  $mail;
	$subject = get_string('contactus_mail_subject', '', date('M d, Y'));
	$message       = get_string('contactus_mail_content', '', $data);
    $messagehtml   = text_to_html($message);

/*	echo '<pre>';
	print_r($subject);
	print_r($user);
	print_r($supportuser);
	print_r($data);
	print_r($messagehtml);*/
    // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
	//email_to_user($user, $from, $subject, $messagetext, $messagehtml = '', $attachment = '', $attachname = '',$usetrueaddress = true, $replyto = '', $replytoname = '', $wordwrapwidth = 79)
//	$mailsend=email_to_user($user, $supportuser, $subject, $message, $messagehtml);
$mailsend=1;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}

echo $OUTPUT->header();
?>

<div class="contactus-blk">
<h4><i class="fa fa-envelope"></i>Contact Us</h4>

<?php 
if($mailsend)
{
	echo '<h4>Mail send successfully, SCW Team will contact you soon</h4>
';	

}
else
$contactus_form->display();
?>

</div>

<?php
echo $OUTPUT->footer();