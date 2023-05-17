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
 * @package local-scwvideos
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');

require_once('edit_form.php');
global $USER;
require_login();
$id = optional_param('id', 0, PARAM_INT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

if ($id) {
	$videos = $DB->get_record('local_scwvideos', array('id' => $id), '*', MUST_EXIST);
	$pagedesc = 'Edit Video';
	$pageparams = array('id' => $id);
	$videos->video_modified = $time;
	$videos->video_modified_by = $USER->id;
    $PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
    $PAGE->navbar->add(get_string('managevideos','local_scwvideos'), new moodle_url('/local/scwvideos/admin.php'));
    $PAGE->navbar->add(get_string('editvideo','local_scwvideos'));
}else{
	$videos = new stdClass;
	$pagedesc = 'Add Video';
	$pageparams = array();
	$videos->id = null;
	$videos->video_created = $time;
	$videos->video_modified = $time;
	$videos->video_created_by = $USER->id;
	$videos->video_modified_by = $USER->id;
    $PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
    $PAGE->navbar->add(get_string('managevideos','local_scwvideos'), new moodle_url('/local/scwvideos/admin.php'));
    $PAGE->navbar->add(get_string('addvideo','local_scwvideos'));
}

$site = get_site();
$fullname = $site->fullname;
$syscontext = context_system::instance();
$PAGE->set_pagelayout('admin');
$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwvideos/edit.php', $pageparams);

if ( !has_capability('local/scwvideos:editvideo', $syscontext) && ($id > 0) ) {
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("editaccessdenied","local_scwvideos");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwvideos/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}

if(!has_capability('local/scwvideos:addvideo', $syscontext) && ($id == "0") ){
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("addaccessdenied","local_scwvideos");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwvideos/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}




$textfieldoptions = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=> 2, 'maxbytes'=> $CFG->maxbytes, 'context' => $syscontext);

$thumboptions = array('subdirs' => 0,
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => 1,
    'accepted_types' => 'web_image'
);

$editoroptions = array('accepted_types' => '*',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
	'accepted_types' => 'web_video'
);

if ($id) {
    $editoroptions['context'] = $syscontext;
    $editoroptions['subdirs'] = file_area_contains_subdirs($syscontext, 'local_scwvideos', 'video_content', $videos->id);
    $videos = file_prepare_standard_editor($videos, 'video_content', $editoroptions, $syscontext, 'local_scwvideos', 'video_content', $videos->id);
} else {
    $editoroptions['context'] = $syscontext;
    $editoroptions['subdirs'] = 0;
    $videos = file_prepare_standard_editor($videos, 'video_content', $editoroptions, $syscontext, 'local_scwvideos', 'video_content', $videos->id);
}

$args = array(
        'editoroptions' => $editoroptions,
		'thumboptions' => $thumboptions
    );
$editform = new videos_edit_form(null, $args);
 
$draftitemid = file_get_submitted_draft_itemid('video_thumb');
 
file_prepare_draft_area($draftitemid, $syscontext->id, 'local_scwvideos', 'video_thumb', $videos->id,
                        $thumboptions);
 
$videos->video_thumb = $draftitemid;
$editform->set_data($videos);

if ($editform->is_cancelled()) {
	redirect($CFG->wwwroot.'/local/scwvideos/admin.php');
}else if ($cnddata = $editform->get_data()) {
    $videos->video_heading = $cnddata->video_heading;
    $videos->video_description = $cnddata->video_description;
    $videos->video_porder = $cnddata->video_porder;
    $videos->video_status = $cnddata->video_status;
    $videos->video_share = $cnddata->video_share;
    $videos->video_content = '';
    $videos->video_content_format = FORMAT_HTML;
    $url = $CFG->wwwroot.'/local/scwvideos/admin.php';
	
    if (empty($videos->id)) {
        $video_id = $DB->insert_record('local_scwvideos', $videos);
		$videos->id = $video_id;
		$msg = 'Video added successfully.';
    } else {
        $DB->update_record('local_scwvideos', $videos);
		$msg = 'Video updated successfully.';
    }

    file_save_draft_area_files($cnddata->video_thumb, $syscontext->id, 'local_scwvideos', 'video_thumb',
                   $videos->id, array('subdirs' => 0, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => 1));

    // Update the video content
    $cnddata = file_postupdate_standard_editor($cnddata, 'video_content', $editoroptions, $syscontext, 'local_scwvideos', 'video_content', $videos->id);
    $DB->set_field('local_scwvideos', 'video_content', $cnddata->video_content, array('id' => $videos->id));
    $DB->set_field('local_scwvideos', 'video_contentformat', $cnddata->video_content_format, array('id' => $videos->id));
	
	//$cnddata = file_postupdate_standard_filemanager($cnddata, 'video_thumb', $attachmentoptions, $context,
                                              'local_scwvideos', 'video_thumb', $videos->id);

    //$DB->update_record('local_scwvideos', $cnddata);
	
    redirect($url, $msg);
}



echo $OUTPUT->header();
echo $OUTPUT->heading($pagedesc);


$editform->display();

echo $OUTPUT->footer();


