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
require_once($CFG->dirroot.'/local/scwgeneral/lib.php');

require_once('edit_form.php');
global $USER;
require_login();

$id = optional_param('id', 0, PARAM_INT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

if ($id) {
	$events = $DB->get_record('local_scwevents', array('id' => $id), '*', MUST_EXIST);
	$pagedesc = 'Edit Events';
	$pageparams = array('id' => $id);
	$events->event_modified = $time;
	$banners->event_modified_by = $USER->id;
}else{
	$events = new stdClass;
	$pagedesc = 'Add Events';
	$pageparams = array();
	$events->id = null;
	$events->event_created = $time;
	$events->event_modified = $events->event_created;
	$events->event_created_by = $USER->id;
	$events->event_modified_by = $USER->id;
}

$site = get_site();
$fullname = $site->fullname;
$syscontext = context_system::instance();
//$PAGE->set_heading($fullname);
$PAGE->set_pagelayout('admin');
$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwevents/edit.php', $pageparams);

if ( !has_capability('local/scwevents:editevent', $syscontext) && ($id > 0) ) {
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("editaccessdenied","local_scwbanner");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwevents/error', array('title' => $etitle, 'message' => $emessage , 'slogo' => $slogo));
	echo $OUTPUT->footer();
	exit;
}

if(!has_capability('local/scwevents:addevent', $syscontext) && ($id == "0") ){
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("addaccessdenied","local_scwevents");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwevents/error', array('title' => $etitle, 'message' => $emessage , 'slogo' => $slogo));
	echo $OUTPUT->footer();
	exit;
}

$descriptionoptions = array('maxfiles' => 5, 'maxbytes' => $CFG->maxbytes, 'trusttext' => true, 'context' => $syscontext,
    'subdirs' => file_area_contains_subdirs($syscontext, 'local_scwevents', 'event_description', $events->id));
	
$events = file_prepare_standard_editor($events, 'event_description', $descriptionoptions, $syscontext, 'local_scwevents', 'event_description', $events->id);


$editform = new events_edit_form(null, array('descriptionoptions'=>$descriptionoptions));
$events->event_description_editor['text']=str_replace('brokenfile.php#','draftfile.php',$events->event_description_editor['text']);  //rename brokenfile
$events->event_description_editor['text']=str_replace('brokenfile.php','draftfile.php',$events->event_description_editor['text']);

$events->event_description=$events->event_description_editor;

/*echo '<pre>';
 print_r($events);
 echo '</pre>';*/
$editform->set_data($events);


if ($editform->is_cancelled()) {
	redirect($CFG->wwwroot.'/local/scwevents/admin.php');
}else if ($cnddata = $editform->get_data()) {
	$events->event_name = $cnddata->event_name;
	$events->event_description = $cnddata->event_description['text'];
	$events->event_country = $cnddata->event_country;
	$events->event_state = $cnddata->event_state;
	$events->event_city = $cnddata->event_city;
	$events->event_address = $cnddata->event_address;
	$events->event_startdate = $cnddata->event_startdate;
	$events->event_enddate = $cnddata->event_enddate;
	$events->event_share = $cnddata->event_share;
	$events->event_status = $cnddata->event_status;
	$url = $CFG->wwwroot.'/local/scwevents/admin.php';
	
    if (empty($events->id)) {
        $event_id = $DB->insert_record('local_scwevents', $events);
		$event->id = $event_id;
		$msg = 'Event added successfully.';
    } else {
        $DB->update_record('local_scwevents', $events);
		$msg = 'Event updated successfully.';
    }	
    redirect($url, $msg);
	
	}



echo $OUTPUT->header();
echo $OUTPUT->heading($pagedesc);


$editform->display();

echo $OUTPUT->footer();


