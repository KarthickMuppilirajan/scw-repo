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
 
//define('AJAX_SCRIPT', true);

require_once('../../config.php');
require_login(); 
global $PAGE;

$message_id = required_param('message_id', PARAM_RAW);
$action = required_param('action', PARAM_RAW);

$userid = $USER->id;
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$msg_arr = array();
$url = $CFG->wwwroot.'/local/scwmail/index.php';

if($message_id && $action=="delete"){

	global $DB,$CFG,$USER;
	$message_id = explode(',', $message_id);
	//print_r($message_id); exit;
	/*foreach ($message_id as $msg) {
		$update = $DB->execute("DELETE FROM {local_scw_mail_index} WHERE message_id=$msg AND user_id=$userid");	
		$update = $DB->execute("DELETE FROM {local_scw_mail_messages} WHERE id=$msg");	
	}*/
	foreach ($message_id as $msg) {
		$update = $DB->execute("UPDATE {local_scw_mail_messages_user} SET `deleted` = '1' WHERE `message_id` = '$msg' AND user_id=$userid AND (role='to' OR role='bcc')");
	}

	//echo json_encode($msg_arr);
	$msg = 'Your message(s) has been deleted.';
		redirect($url, $msg);
}

?>