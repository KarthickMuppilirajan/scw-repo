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

$bannerids = required_param('banner_ids', PARAM_TEXT);
$banneract = required_param('banner_action', PARAM_TEXT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

if(empty($bannerids)){
	print_error('errordata');
}

$syscontext = context_system::instance();
//$PAGE->set_heading($fullname);
$PAGE->set_pagelayout('admin');
$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwbanner/banner_action.php');
$returnurl = $CFG->wwwroot.'/local/scwbanner/admin.php';

if ( !has_capability('local/scwbanner:editbanner', $syscontext)  ) {
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("editaccessdenied","local_scwbanner");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwbanner/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}

$abannerids = explode(",",$bannerids);

	foreach ($abannerids as $bid) {
		$obj = new stdClass();
		$obj->id = $bid;
		$obj->banner_status = ($banneract=="enabled") ? '1' : '0';
		$obj->banner_modified = $time;
		$obj->banner_modified_by = $USER->id;
		$DB->update_record('local_scwbanner', $obj, true);
	}

    $bannermsg = get_string('bannerupdatemessage', 'local_scwbanner');
	redirect($returnurl, $bannermsg);
	exit;