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
 * @package    local_scwnewsletter
 * @copyright  2016 Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 

require_once('../../config.php');
require_login(); 
global $PAGE,$USER;

$PAGE->set_context(context_system::instance());

$subscriber_id = optional_param('subscriber_id', 0, PARAM_INT);
$action = optional_param('action', 0, PARAM_TEXT);


$url = $CFG->wwwroot.'/local/scwnewsletter/subscribers.php';

if($subscriber_id && $action=="delete"){
	
	$delete_link = $DB->execute("DELETE FROM {local_scwnewsletter_users}  WHERE `id` = '$subscriber_id'");
	$msg = 'User has been Deleted successfully.';
		redirect($url, $msg);
	
}
else if($subscriber_id && $action=="unsubscribe"){
	$block_user = $DB->execute("UPDATE {local_scwnewsletter_users} SET `status`=0 WHERE  `id` = $subscriber_id");
	$msg = 'User has been Unsubscribed successfully.';
		redirect($url, $msg);
}
else if($subscriber_id && $action=="subscribe"){
	$block_user = $DB->execute("UPDATE {local_scwnewsletter_users} SET `status`=1 WHERE  `id` = $subscriber_id");
	$msg = 'User has been Subscribed successfully.';
		redirect($url, $msg);
}
?>