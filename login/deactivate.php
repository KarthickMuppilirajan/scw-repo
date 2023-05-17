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

require("../config.php");
require_once('deactivate_form.php');
require_once($CFG->dirroot.'/local/scwgeneral/lib.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/authlib.php');
require_once($CFG->dirroot.'/user/filters/lib.php');
require_once($CFG->dirroot.'/user/lib.php');
global $PAGE,$USER,$DB;

require_login();

$title = 'Deactivate account';
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/login/deactivate.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();


$deactivate_form = new deactivate_form();
if ($deactivate_form->is_cancelled()) {
    redirect($CFG->wwwroot);
} 
elseif ($cnddata = $deactivate_form->get_data()) 
{
	$deactive_comments=$cnddata->deactivate_comments;
	if(trim($deactive_comments))
	{
		$deactive_comments='NA';
	}
	///////////////////////////deactivate mail to admin///////////////////////////	
	$supportuser = core_user::get_support_user();	
//	$supportuser->email='praburaj@fourbends.com';	
    $supportuser->mailformat = 1;  // Always send HTML version as well.
    $data = new stdClass();	
	$user = $DB->get_record('user', array('id' => $USER->id), '*', MUST_EXIST);
    $user->mailformat = 1;  // Always send HTML version as well.
	user_delete_user($user); //delete user
	$subject = get_string('deactivate_mail_subject','' ,$user->firstname.' '.$user->lastname);
	$data->mail = '<br> <p><b>Name: </b>'.$user->firstname.' '.$user->lastname.'</p><p><b>Email: </b>'.$user->email.'</p><p><b>Comments: </b>'.$deactive_comments;
    $message       = get_string('deactivate_mail_content', '', $data);
    $messagehtml   = text_to_html($message);
/*	echo '<pre>';
	print_r($subject);
	print_r($user);
	print_r($supportuser);
	print_r($data);
	print_r($messagehtml);*/

    // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
	//email_to_user($user, $from, $subject, $messagetext, $messagehtml = '', $attachment = '', $attachname = '',$usetrueaddress = true, $replyto = '', $replytoname = '', $wordwrapwidth = 79)
	email_to_user($supportuser, $user, $subject, $message, $messagehtml);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	redirect($CFG->wwwroot.'/login/deactivated.php');	
}

echo $OUTPUT->header();
?>

<div class="contactus-blk">
<h4><i class="fa fa-envelope"></i>Deactivate account</h4>
<p align="center">Sorry that you are leaving. We would appreciate if you can leave us a message as to why you are deleting, that would help us to improve our service offering & user experience</p>
<?php 
$deactivate_form->display();
?>
<p align="center">Thanks for being with us this far. <br />++ Note that all your profile settings, messages and connections will be purged. '</p>
</div>

<?php
echo $OUTPUT->footer();