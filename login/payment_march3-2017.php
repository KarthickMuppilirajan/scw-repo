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
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->set_pagelayout('coursecategory');
$PAGE->set_title('Subcription');
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/login/payment.php');
$mform = new payment_form();
?>
<?php
if ($mform->is_cancelled()) {
} else if ($payment_form = $mform->get_data()) {
	$random_url=$payment_form->random_url;
	$user_details_record=$DB->get_record('user_details', array('random_url' => $random_url));
	$user_record=$DB->get_record('user', array('id' => $user_details_record->id));
	$firstname=$user_record->firstname;
	$lastname=$user_record->lastname;
	$record= new stdClass();
	$record->id=$user_record->id;
	$record->password_url_creation=time();
	$record->password_url_expiration=time()+(7*24*60*60);
    $sql = $DB->update_record('user_details', $record);
	//echo '<pre>';
//	print_r($user_record);
	//print_r($user_details_record);
	core_login_process_password_reset_request_new($user_record);/////////////////////////send forgot password mail by email
	redirect($CFG->wwwroot.'/login/payment.php', 'Password reset mail sent successfully');	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();