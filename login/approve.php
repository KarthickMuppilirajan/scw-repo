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
require_once('payment_form.php');
require_once($CFG->dirroot.'/local/scwgeneral/lib.php');

require_login();

$appcond = (local_scwgeneral_check_scwsales() || local_scwgeneral_check_scwadmin());

if(!$appcond){
	$url = $CFG->wwwroot.'/';
	redirect($url);
}

$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->set_title('Approve');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_url('/login/payment.php');
$mform = new payment_form();
@$email=$_POST['email'];
$success=0;
if($email)
{
	$user_record=$DB->get_record('user', array('email' => $email));
	$userdetail = $DB->get_record('user_details', array('user_id' => $user_record->id));
	/*echo '<pre>';
	print_r($user_record);
	exit;*/
	$record= new stdClass();
	$record->id=$user_record->id;
	$record->confirmed=1;
	$sql = $DB->update_record('user', $record);	
	
	$record1= new stdClass();
	$record1->id = $userdetail->id;
	$record1->user_id=$user_record->id;
	$record1->approval_status=1;
	$sql1 = $DB->update_record('user_details', $record1);

	if($user_record)
	{
		$success=1;
		core_login_process_password_reset_request_new($user_record);/////////////////////////send forgot password mail by email	
	}
}
echo $OUTPUT->header();
if($success==0)
{
?>
<div class="subscription-blk">
<h4>Approve</h4>
<div class="subscription-contnt">
<h5>Temporarily Approve professional</h5>
<form method="post" action="">
<label>Email </label> <input type="text" name="email" />
<input type="submit" value="Approve" />
</form>
</div>
</div>
<?php 
}
echo $OUTPUT->footer();