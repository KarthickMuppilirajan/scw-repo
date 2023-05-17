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
 * user signup page.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
require_once($CFG->dirroot . '/user/editlib.php');
require_once($CFG->libdir . '/authlib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/roles/lib.php');
require_once($CFG->dirroot.'/lib/accesslib.php');

// Try to prevent searching for sites that allow sign-up.
if (!isset($CFG->additionalhtmlhead)) {
    $CFG->additionalhtmlhead = '';
}
$CFG->additionalhtmlhead .= '<meta name="robots" content="noindex" />';
if (!$authplugin = signup_is_enabled()) {
    print_error('notlocalisederrormessage', 'error', '', 'Sorry, you may not use this page.');
}

//HTTPS is required in this page when $CFG->loginhttps enabled
$PAGE->https_required();

$newaccount = get_string('registration');
$login      = get_string('login');
$PAGE->set_url('/login/signup.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('login');
$PAGE->set_title($newaccount);
$PAGE->set_heading($SITE->fullname);
$PAGE->navbar->add($login);
$PAGE->navbar->add($newaccount);
$PAGE->set_pagelayout('login');
////////////moodle default////////////////////////
// If wantsurl is empty or /login/signup.php, override wanted URL.
// We do not want to end up here again if user clicks "Login".
if (empty($SESSION->wantsurl)) {
    $SESSION->wantsurl = $CFG->wwwroot . '/';
} else {
    $wantsurl = new moodle_url($SESSION->wantsurl);
    if ($PAGE->url->compare($wantsurl, URL_MATCH_BASE)) {
        $SESSION->wantsurl = $CFG->wwwroot . '/';
    }
}

if (isloggedin() and !isguestuser()) {
    // Prevent signing up when already logged in.
    echo $OUTPUT->header();
    echo $OUTPUT->box_start();
    $logout = new single_button(new moodle_url($CFG->httpswwwroot . '/login/logout.php',
        array('sesskey' => sesskey(), 'loginpage' => 1)), get_string('logout'), 'post');
    $continue = new single_button(new moodle_url('/'), get_string('cancel'), 'get');
    echo $OUTPUT->confirm(get_string('cannotsignup', 'error', fullname($USER)), $logout, $continue);
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer();
    exit;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$mform_signup = $authplugin->signup_form();

if ($mform_signup->is_cancelled()) {
		redirect($CFG->wwwroot.'/login/signup.php');	

} else if ($user = $mform_signup->get_data()) {
////////////////////////////////////////////create user/////////////////////////////////////////////////////////////////		
	$user->firstname=ucfirst($user->firstname);
	$user->lastname=ucfirst($user->lastname);
	$middlename=$user->middlename;
	$random_string=generateRandomString(8);	
    // Add missing required fields.
    $user->username='a'.strtolower($random_string);
    $user->password=ucfirst($user->username).'#1';
    $user = signup_setup_new_user($user);
    $user->confirmed=0;
    $user->middlename=$middlename;
/*	echo '<pre>';
	print_r($user);
	exit;*/
	$record = $user;
//	user_create_user($record);
 	$record->id = user_create_user($record);	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////insert in user details table///////////////////////////////////////////////
$user_details_record = new stdClass();
$user_details_record->id = NULL;
$user_details_record->profession=$record->profession;
if($record->profession==2) ///set payment details only for recent graduates
{
	$user_details_record->payment_status=0;
	$user_details_record->amount=60;
}
$user_details_record->approval_status = 0;
$user_details_record->user_id = $record->id;
$user_details_record->random_url = $random_string;
$user_details_record->payment_url_status = 1;
$user_details_record->payment_url_creation = time();
$user_details_record->payment_url_expiration = time()+(7*24*60*60);
$DB->insert_record('user_details', $user_details_record);
/////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////role create/assign (professional,recent graduates///////////////////
///////////////for professonal
if($record->profession==1)
{
	$role_record = $DB->get_record('role', array ('shortname' => 'professional'));
	if(empty($role_record))
	{
		$professional_roleid = create_role('Professional Role', 'professional', 'Role created with arch type student', 'student');
		$contextlevels[10] = 10;
		set_role_contextlevels($professional_roleid, $contextlevels);	
	}
	else
	{
		$professional_roleid = $role_record->id;
	}
	$roleid=$professional_roleid;
}
////////////////for recent graduates
if($record->profession==2)
{
	$role_record = $DB->get_record('role', array ('shortname' => 'recent_graduates'));
	if(empty($role_record))
	{
        $recent_graduates_roleid = create_role('Recent Graduates Role', 'recent_graduates', 'Role created with arch type student', 'student');
		$contextlevels[10] = 10;
		set_role_contextlevels($recent_graduates_roleid, $contextlevels);	
	}
	else
	{
		$recent_graduates_roleid = $role_record->id;
	}
	$roleid=$recent_graduates_roleid;
///////////////////////////payment mail to recent graduates///////////////////////////	
	$supportuser = core_user::get_support_user();	
    $data = new stdClass();	
    $user = $record;	
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
	print_r($messagehtml);*/
    // Directly email rather than using the messaging system to ensure its not routed to a popup or jabber.
	//email_to_user($user, $from, $subject, $messagetext, $messagehtml = '', $attachment = '', $attachname = '',$usetrueaddress = true, $replyto = '', $replytoname = '', $wordwrapwidth = 79)
	email_to_user($user, $supportuser, $subject, $message, $messagehtml);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
    $contextid = 1;
    role_assign($roleid, $record->id , $contextid);    	/////////////////////assign role
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($record->profession==1)
		redirect($CFG->wwwroot.'/login/registration_success_professional.php');	
	else
		redirect($CFG->wwwroot.'/login/registration_success_student.php');	
}

// make sure we really are on the https page when https login required
$PAGE->verify_https_required();

echo $OUTPUT->header(); ?>
<div class="signup-blk" id="swc_signup">
<?php echo $OUTPUT->render($mform_signup); ?>
</div>
<?php
echo $OUTPUT->footer();

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
<script type="text/javascript">
require(['jquery'], function( $ ) {
    //Disable cut copy paste
   $('#id_email').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   $('#id_confirm_email').bind('cut copy paste', function (e) {
        e.preventDefault();
    });

   
    //Disable mouse right click
    $("#id_email").on("contextmenu",function(e){
        return false;
    });
    $("#id_confirm_email").on("contextmenu",function(e){
        return false;
    });

});
</script>