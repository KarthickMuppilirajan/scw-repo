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

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');

global $CFG, $USER, $DB;
require_login();

$eventids = required_param('event_ids', PARAM_TEXT);
$eventact = required_param('event_action', PARAM_TEXT);

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

if(empty($eventids)){
	print_error('errordata');
}

$syscontext = context_system::instance();
//$PAGE->set_heading($fullname);
$PAGE->set_pagelayout('admin');
$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwbanner/event_action.php');
$returnurl = $CFG->wwwroot.'/local/scwevents/admin.php';

if ( !has_capability('local/scwevents:editevent', $syscontext)  ) {
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("editaccessdenied","local_scwevents");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwbanner/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}

$aeventids = explode(",",$eventids);

	foreach ($aeventids as $eid) {
		$obj = new stdClass();
		$obj->id = $eid;
		$obj->event_status = ($eventact=="enabled") ? '1' : '0';
		$obj->event_modified = $time;
		$obj->event_modified_by = $USER->id;
		$DB->update_record('local_scwevents', $obj, true);
	}

    $eventmsg = get_string('eventupdatemessage', 'local_scwevents');
	redirect($returnurl, $eventmsg);
	exit;