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
 * @package local-scwinterviews
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');

global $CFG, $USER, $DB;
require_login();

$interviewids = required_param('interview_ids', PARAM_TEXT);
$interviewact = required_param('interview_action', PARAM_TEXT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

if(empty($interviewids)){
	print_error('errordata');
}

$syscontext = context_system::instance();
//$PAGE->set_heading($fullname);
$PAGE->set_pagelayout('admin');
$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwinterviews/interview_action.php');
$returnurl = $CFG->wwwroot.'/local/scwinterviews/admin.php';

if ( !has_capability('local/scwinterviews:editinterview', $syscontext)  ) {
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("editaccessdenied","local_scwinterviews");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwinterviews/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}

$ainterviewids = explode(",",$interviewids);

	foreach ($ainterviewids as $bid) {
		$obj = new stdClass();
		$obj->id = $bid;
		$obj->interview_status = ($interviewact=="enabled") ? '1' : '0';
		$obj->interview_modified = $time;
		$obj->interview_modified_by = $USER->id;
		$DB->update_record('local_scwinterviews', $obj, true);
	}

    $interviewmsg = get_string('interviewupdatemessage', 'local_scwinterviews');
	redirect($returnurl, $interviewmsg);
	exit;