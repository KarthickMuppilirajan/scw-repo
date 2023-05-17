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
 * @package local-candidates
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');
require_once('edit_form.php');
global $PAGE, $USER, $CFG, $DB;
require_login();
$id = optional_param('id', 0, PARAM_INT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
if ($id) {

	$interviews = $DB->get_record('local_scwinterviews', array('id' => $id), '*', MUST_EXIST);
	$pagedesc = 'Edit Interviews';
	$pageparams = array('id' => $id);
	$interviews->interview_modified = $time;
	$interviews->interview_modified_by = $USER->id;
	$PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
    $PAGE->navbar->add(get_string('manageinterviews','local_scwinterviews'), new moodle_url('/local/scwinterviews/admin.php'));
    $PAGE->navbar->add(get_string('editinterview','local_scwinterviews'));
	
}else{
	$interviews = new stdClass;
	$pagedesc = 'Add Interviews';
	$pageparams = array();
	$interviews->id = null;
	$interviews->interview_created = $time;
	$interviews->interview_modified = $interviews->interview_created;
	$interviews->interview_created_by = $USER->id;
	$interviews->interview_modified_by = $USER->id;
	$PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
    $PAGE->navbar->add(get_string('manageinterviews','local_scwinterviews'), new moodle_url('/local/scwinterviews/admin.php'));
    $PAGE->navbar->add(get_string('addinterview','local_scwinterviews'));
}

$site = get_site();
$fullname = $site->fullname;
$systemcontext = context_system::instance();
//$PAGE->set_heading($fullname);
$PAGE->set_pagelayout('admin');
$PAGE->set_context($systemcontext);
$PAGE->set_url('/local/scwinterviews/edit.php', $pageparams);

if ( !has_capability('local/scwinterviews:editinterview', $systemcontext) && ($id > 0) ) {
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

if(!has_capability('local/scwinterviews:addinterview', $systemcontext) && ($id == "0") ){
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("addaccessdenied","local_scwinterviews");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwinterviews/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}

$summaryoptions = array('maxfiles' => 99, 'maxbytes' => $CFG->maxbytes, 'trusttext' => true, 'context' => $systemcontext,
    'subdirs' => file_area_contains_subdirs($systemcontext, 'local_scwinterviews', 'summary', $interviews->id));
	
$interviews = file_prepare_standard_editor($interviews, 'summary', $summaryoptions, $systemcontext, 'local_scwinterviews', 'summary', $interviews->id);

$editform = new scwinterviews_edit_form(null, array('summaryoptions'=>$summaryoptions));
 
$editform->set_data($interviews);
	
if ($editform->is_cancelled()) {
	redirect($CFG->wwwroot.'/local/scwinterviews/admin.php');
}else if ($cnddata = $editform->get_data()) {
	//echo "Data Fetch";
	$interviews->interview_heading = $cnddata->interview_heading;
	$interviews->summary      = $cnddata->summary_editor['text'];
	$interviews->interview_company = $cnddata->interview_company;
	$interviews->interview_contact = $cnddata->interview_contact;
	$interviews->interview_priority = $cnddata->interview_priority;
	$interviews->interview_share = $cnddata->interview_share;
	$interviews->interview_status = $cnddata->interview_status;
	$interviews->interview_expires_by= $cnddata->interview_expires_by;

	$url = $CFG->wwwroot.'/local/scwinterviews/admin.php';

    if (empty($interviews->id)) {
        $interview_id = $DB->insert_record('local_scwinterviews', $interviews);
		$interviews->id = $interview_id;
		$msg = 'interview added successfully.';
    } else {
		
		$interview_id = $interviews->id;
        $DB->update_record('local_scwinterviews', $interviews);
		$msg = 'interview updated successfully.';
    }
		
    redirect($url, $msg);
}

echo $OUTPUT->header();
echo $OUTPUT->heading($pagedesc);
$editform->display();

echo $OUTPUT->footer();
?>
  <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
     <div class="modal-header">
         <h4 class="modal-title">Preview</h4>
     </div>
     <div class="modal-body">
        <p><b>Heading</b> : <?php echo $interviews->interview_heading;?> </p>
		<p><b>Content</b> : <?php echo $interviews->summary;?> </p>
		<p><b>Company</b> : <?php echo $interviews->interview_company;?> </p>
		<p><b>Contact</b> : <?php echo $interviews->interview_contact;?> </p>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
   </div>
  </div>
</div>  

<script>
$("#getCodeModal").modal('show');
</script>