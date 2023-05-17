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
 * @package local-scwvideo
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');

global $CFG, $USER, $DB;
require_login();

$videoids = required_param('video_ids', PARAM_TEXT);
$videoact = required_param('video_action', PARAM_TEXT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

if(empty($videoids)){
	print_error('errordata');
}

$syscontext = context_system::instance();
//$PAGE->set_heading($fullname);
$PAGE->set_pagelayout('admin');
$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwvideos/video_action.php');
$returnurl = $CFG->wwwroot.'/local/scwvideos/admin.php';

if ( !has_capability('local/scwvideos:editvideo', $syscontext)  ) {
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("editaccessdenied","local_scwvideos");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwvideos/error', array('title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	));
	echo $OUTPUT->footer();
	exit;
}

$avideoids = explode(",",$videoids);

	foreach ($avideoids as $vid) {
		$obj = new stdClass();
		$obj->id = $vid;
		$obj->video_status = ($videoact=="enabled") ? '1' : '0';
		$obj->video_modified = $time;
		$obj->video_modified_by = $USER->id;
		$DB->update_record('local_scwvideos', $obj, true);
	}

    $videomsg = get_string('videoupdatemessage', 'local_scwvideos');
	redirect($returnurl, $videomsg);
	exit;