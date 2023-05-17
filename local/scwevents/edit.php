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
	$events->event_modified_by = $USER->id;
/*	echo 'start'.date('d MY h.i a',$events->event_startdate);
	echo '<br>end'.date('d MY h.i a',$events->event_enddate);
	echo '<br>now'.date('d MY h.i a',$time);*/
    $PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
    $PAGE->navbar->add(get_string('scwbanner:manageevents','local_scwevents'), new moodle_url('/local/scwevents/admin.php'));
    $PAGE->navbar->add(get_string('scwbanner:editevent','local_scwevents'));

}else{
	$events = new stdClass;
	$pagedesc = 'Add Events';
	$pageparams = array();
	$events->id = null;
	$events->event_created = $time;
	$events->event_modified = $events->event_created;
	$events->event_created_by = $USER->id;
	$events->event_modified_by = $USER->id;
    $PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
    $PAGE->navbar->add(get_string('scwbanner:manageevents','local_scwevents'), new moodle_url('/local/scwevents/admin.php'));
    $PAGE->navbar->add(get_string('scwbanner:addevent','local_scwevents'));
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

$editoroptions = array('accepted_types' => 'web_video',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
);

$editoroptions['context'] = $syscontext;
$editoroptions['subdirs'] = 0;

	
$events = file_prepare_standard_editor($events, 'event_description', $editoroptions, $syscontext, 'local_scwevents', 'event_description', $events->id);


$args = array(
        'editoroptions' => $editoroptions,
    );



$editform = new events_edit_form(null, $args);

/*echo '<pre>';
 print_r($events);
 echo '</pre>';*/
$editform->set_data($events);
	
?>
<?php
	

if ($cnddata = $editform->get_data()) {
	$events->event_name = $cnddata->event_name;
	$events->event_description = '';
    $events->messageformat = FORMAT_HTML;
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
		$events->id = $event_id;
		$msg = 'Event added successfully.';
    } else {
        $DB->update_record('local_scwevents', $events);
		$msg = 'Event updated successfully.';
    }	
	$cnddata->id = $events->id;			
	
	$cnddata = file_postupdate_standard_editor($cnddata, 'event_description', $editoroptions, $syscontext, 'local_scwevents', 'event_description', $events->id);

    $DB->update_record('local_scwevents', $cnddata);

    redirect($url, $msg);
	
	}



echo $OUTPUT->header();
echo $OUTPUT->heading($pagedesc);


$editform->display();
	echo '  <div class="modal fade" id="previewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
     <div class="modal-header">
         <h4 class="modal-title"></h4>
     </div>
     <div class="modal-body">
		<div id="event_name"></div>
		<div id="event_info"></div>
		<div id="event_description" style="overflow:hidden;"></div>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
   </div>
  </div>
</div>  ';

echo $OUTPUT->footer(); 
?>
<script type="text/javascript">
require(['jquery'], function( $ ) {	
$("#id_clear").click(function(){
$("#id_event_name").val('');
$("#id_event_description").val('');
tinyMCE.activeEditor.setContent('');
$("#id_event_country").val('');
$("#id_event_state").val('');
$("#id_event_city").val('');
$("#id_event_address").val('');

var d = new Date();
var mon = d.getMonth();
var day= d.getDate();
var year= d.getFullYear();
var hrs= d.getHours();
var mins= d.getMinutes();
$("#id_event_startdate_day").val(day);
$("#id_event_enddate_day").val(day);
$("#id_event_startdate_month").val(mon);
$("#id_event_enddate_month").val(mon);
$("#id_event_startdate_year").val(year);
$("#id_event_enddate_year").val(year);
$("#id_event_startdate_hour").val(hrs);
$("#id_event_enddate_hour").val(hrs);
$("#id_event_startdate_minute").val('0');
$("#id_event_enddate_minute").val('0');
});	


$("#id_preview").click(function(){
$(".modal-title").html($("#id_event_name").val());
var month = new Array();
month[0] = "January";
month[1] = "February";
month[2] = "March";
month[3] = "April";
month[4] = "May";
month[5] = "June";
month[6] = "July";
month[7] = "August";
month[8] = "September";
month[9] = "October";
month[10] = "November";
month[11] = "December";
n=parseInt($("#id_event_startdate_month").val())-1;
var n = month[n]; 
var info=$("#id_event_startdate_day").val()+' '+n+' '+$("#id_event_startdate_year").val()+' '+$("#id_event_address").val()+', '+$("#id_event_city").val()+', '+$("#id_event_state").val()+', '+$("#id_event_country").val()+'<br><br>';
$("#event_info").html(info);
//$("#event_description").html($("#id_event_description").val());
$("#event_description").html(tinyMCE.get("id_event_description_editor").getContent());
	$("#previewmodal").modal('show');
});	
	});
</script>

