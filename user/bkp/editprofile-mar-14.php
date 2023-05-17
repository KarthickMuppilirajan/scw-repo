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
 * Allows you to edit a users profile
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_user
 */

require_once('../config.php');
require_once($CFG->libdir.'/gdlib.php');
require_once($CFG->dirroot.'/user/editprofile_form.php');
require_once($CFG->dirroot.'/user/editlib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');

global $USER,$DB;
require_login();

// HTTPS is required in this page when $CFG->loginhttps enabled.
$PAGE->https_required();
$userid = optional_param('id', $USER->id, PARAM_INT);    // User id.
$course = optional_param('course', SITEID, PARAM_INT);   // Course id (defaults to Site).
$returnto = optional_param('returnto', null, PARAM_ALPHA);  // Code determining where to return to after save.

$user = $DB->get_record('user', array('id' => $USER->id), '*', MUST_EXIST);

$userdetails = $DB->get_record('user_details', array('user_id' => $USER->id), '*');

$syscontext = context_system::instance();
$personalcontext = context_user::instance($user->id);

$editurl = new moodle_url('/user/editprofile.php');

$PAGE->set_url('/user/editprofile.php', array());

if (!$course = $DB->get_record('course', array('id' => $course))) {
    print_error('invalidcourseid');
}

$PAGE->set_pagelayout('scwpage');
$PAGE->set_context($syscontext);

// Display page header.
$streditmyprofile = get_string('editmyprofile');
$strparticipants  = get_string('participants');
$userfullname     = fullname($user, true);

$PAGE->set_title("$course->shortname: $streditmyprofile");

if(!empty($userdetails)){
	$args = array('userdetails' => $userdetails, 'usermain' => $user);
}else{
	$args = array('userdetails' => '', 'usermain' => '' );
}

$editusers = new stdClass();
$editusers->id = $user->id;
$editusers->firstname = $user->firstname;
$editusers->lastname = $user->lastname;
$editusers->middlename = $user->middlename;
$editusers->email = $user->email;
$editusers->country = !empty($user->country) ? $user->country : 'GB';
$editusers->phone1 = $user->phone1;
$editusers->city = $user->city;

$sql = "SELECT * FROM {files} WHERE `contextid` = '".$personalcontext->id."' AND `component` LIKE 'user' AND `filearea` LIKE 'draft' AND filesize > 0 order by id desc limit 1";
$presult = $DB->get_record_sql($sql);

if(!empty($presult)){
  $draftitemid = $presult->itemid;
}else{
  $draftitemid = 0;	
}

$filemanageroptions = array('maxbytes'       => $CFG->maxbytes,
                             'subdirs'        => 0,
                             'maxfiles'       => 1,
                             'accepted_types' => 'web_image');
file_prepare_draft_area($draftitemid, $personalcontext->id, 'user', 'newicon', 0, $filemanageroptions);

$editusers->imagefile = $draftitemid;

$args["filemanageroptions"] = $filemanageroptions;
							 
$userform = new editprofile_form(null, $args);
							 
if(!empty($userdetails)){
    $editusers->is_searchable = $userdetails->is_searchable;
    $editusers->receive_newsletter = $userdetails->receive_newsletter;
    $editusers->receive_email = $userdetails->receive_email;
	$editusers->industry = !empty($userdetails->industry) ? $userdetails->industry : 'education';
    $editusers->functional_area =  !empty($userdetails->functional_area) ? $userdetails->functional_area : 'supply-chain-management-for-marketing';
	$editusers->summary = $userdetails->summary;
}

$userform->set_data($editusers);

if ($usernew = $userform->get_data()) {
    $usermain = new stdClass();
    $usermain->id = $usernew->id;
	$usermain->firstname = $usernew->firstname;
    $usermain->lastname = $usernew->lastname;
    $usermain->middlename = $usernew->middlename;
    $usermain->email = $usernew->email;
    $usermain->country = $usernew->country;
    $usermain->phone1 = $usernew->phone1;
	$usermain->city = $usernew->city;
    $DB->update_record('user', $usermain);
	
	core_user::update_picture($usernew, $filemanageroptions);

    if(!empty($userdetails)){
        $userdetails->industry = $usernew->industry;
        $userdetails->functional_area =  $usernew->functional_area;
		$userdetails->is_searchable = $usernew->is_searchable;
        $userdetails->receive_newsletter = $usernew->receive_newsletter;
        $userdetails->receive_email = $usernew->receive_email;
		$userdetails->summary = $usernew->summary;
        $DB->update_record('user_details', $userdetails);
    }

	$msg = 'Successfull updated';
	redirect($editurl, $msg);

}


echo $OUTPUT->header();
?>
<style type="text/css">
#swc_signup .fdescription{
    display:none;
}
</style>

<div class="signup-blk" id="swc_signup" style="width:100%">
<h4><i class="fa fa-users"></i>Edit Profile</h4>
<?php $userform->display(); ?>
</div>

<?php
// And proper footer.
echo $OUTPUT->footer();

