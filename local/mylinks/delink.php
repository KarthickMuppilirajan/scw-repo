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
 

require_once('../../config.php');
require_once($CFG->dirroot.'/local/scwmail/lib.php');
require_login(); 
global $PAGE,$USER;



$user_id=$USER->id;

$PAGE->set_context(context_system::instance());

$connected_id = optional_param('connected_id', 0, PARAM_INT);
$action = optional_param('action', 0, PARAM_TEXT);
$block_notes= optional_param('block_notes', 0, PARAM_TEXT);


$url = $CFG->wwwroot.'/local/mylinks/profile.php?user_id='.$connected_id;

if($connected_id && $action=="delink"){
	
	$delete_link = $DB->execute("DELETE FROM {local_mylinks}  WHERE `connected_id` = '$connected_id' AND `user_id`='$user_id'");
	$delete_link1 = $DB->execute("DELETE FROM {local_mylinks}  WHERE `connected_id` = '$user_id' AND `user_id`='$connected_id'");
	$msg = 'User has been De-linked successfully.';
		redirect($url, $msg);
	
}

if($connected_id && $action=="block"){
	
	$block_user = $DB->execute("UPDATE {local_mylinks} SET `connection_status`=2,`block_notes`='$block_notes'  WHERE  `connected_id` = $connected_id AND `user_id`=$user_id");
	$block_user = $DB->execute("UPDATE {local_mylinks} SET `connection_status`=2  WHERE `user_id` = $connected_id AND `connected_id`=$user_id");
	$msg = 'User has been Blocked successfully.';
		redirect($url, $msg);
	
}

if($connected_id && $action=="unblock"){
	
	$block_user = $DB->execute("UPDATE {local_mylinks} SET `connection_status`=1,`block_notes`=''  WHERE  `connected_id` = $connected_id AND `user_id`=$user_id");
	$block_user = $DB->execute("UPDATE {local_mylinks} SET `connection_status`=1,`block_notes`=''  WHERE `user_id` = $connected_id AND `connected_id`=$user_id");
	$msg = 'User has been Un-Blocked successfully.';
		redirect($url, $msg);
	
}
?>