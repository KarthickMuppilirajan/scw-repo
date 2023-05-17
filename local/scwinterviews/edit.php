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
require_once('edit_form.php');
global $PAGE, $USER, $CFG, $DB;
require_login();
$id = optional_param('id', 0, PARAM_INT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$afmonth = $time + 30 * 3600 * 24;
$day = date("j", $afmonth);
$mon = date("n", $afmonth);
$year = date("Y", $afmonth);

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

$textfieldoptions = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=> 99, 'maxbytes'=> $CFG->maxbytes, 'context' => $systemcontext);

$editoroptions = array('accepted_types' => 'web_image',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
);

if ($id) {
    $editoroptions['context'] = $systemcontext;
    $editoroptions['subdirs'] = file_area_contains_subdirs($systemcontext, 'local_scwinterviews', 'summary', $interviews->id);
    $interviews = file_prepare_standard_editor($interviews, 'summary', $editoroptions, $systemcontext, 'local_scwinterviews', 'summary', $interviews->id);
} else {
    $editoroptions['context'] = $systemcontext;
    $editoroptions['subdirs'] = 0;
    $interviews = file_prepare_standard_editor($interviews, 'summary', $editoroptions, $systemcontext, 'local_scwinterviews', 'summary', $interviews->id);
}

$args = array(
        'editoroptions' => $editoroptions,
		
    );
	
$editform = new scwinterviews_edit_form(null, $args);
$editform->set_data($interviews);
	
if ($editform->is_cancelled()) {
	redirect($CFG->wwwroot.'/local/scwinterviews/admin.php');
}else if ($cnddata = $editform->get_data()) {
	//echo "Data Fetch";
	$interviews->interview_heading = $cnddata->interview_heading;
	//$interviews->summary      = $cnddata->summary_editor['text'];
	$interviews->summary = '';
    $interviews->summaryformat = FORMAT_HTML;
	$interviews->interview_company = $cnddata->interview_company;
	$interviews->interview_contact = $cnddata->interview_contact;
	$interviews->interview_priority = $cnddata->interview_priority;
	$interviews->interview_share = $cnddata->interview_share;
	$interviews->interview_status = $cnddata->interview_status;
	$interviews->interview_expires_by= $cnddata->interview_expires_by;

	$url = $CFG->wwwroot.'/local/scwinterviews/admin.php';
	
			//priority check
		$interviewarr = array('interview_delete' => '0' ,'interview_status' => '1','interview_priority' => $cnddata->interview_priority);
		$priority_check = $DB->get_record('local_scwinterviews', $interviewarr , '*', IGNORE_MULTIPLE); 
		
		if(!empty($priority_check->id)){
			$priority = new stdClass;
			$priority->interview_status = 0;
			$priority->id = $priority_check->id;
			 $DB->update_record('local_scwinterviews', $priority);
		}

    if (empty($interviews->id)) {
        $interview_id = $DB->insert_record('local_scwinterviews', $interviews);
		$interviews->id = $interview_id;
		$msg = 'Interview added successfully.';
    } else {
		
		$interview_id = $interviews->id;
        $DB->update_record('local_scwinterviews', $interviews);
		$msg = 'Interview updated successfully.';
    }
	$cnddata->id = $interviews->id;
	$cnddata = file_postupdate_standard_editor($cnddata, 'summary', $editoroptions, $systemcontext, 'local_scwinterviews', 'summary', $interviews->id);

    $DB->update_record('local_scwinterviews', $cnddata);
	
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
		<div id="interview_name"></div>
		<div id="interview_description"></div>
		<br>
		<div id="interview_info"></div>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
   </div>
  </div>
</div>  ';

echo '  <div class="modal fade" id="prioritymodal" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
     <div class="modal-header">
         <h4 class="modal-title">Prority already exist</h4>
     </div>
     <div class="modal-body">
     </div>
      <div class="modal-footer">
	  <button type="button" class="btn btn-brown" id="confirm_priority">Yes</button>
        <button type="button" class="btn btn-default" id="cancel_priority">No</button>
      </div>
   </div>
  </div>
</div>  ';


echo $OUTPUT->footer();
?>
<script type="text/javascript">
require(['jquery'], function( $ ) {	
var ed = "<?php echo $day; ?>";
var em = "<?php echo $mon; ?>";
var ey = "<?php echo $year; ?>";	

$("#id_preview").click(function(){
$(".modal-title").html($("#id_interview_heading").val());
var content = tinyMCE.get("id_summary_editor").getContent();
var info ='Contact:'+$("#id_interview_contact").val();
$("#interview_description").html(content);
$("#interview_info").html(info);
$("#previewmodal").modal('show');
});	
	
$(document).on("click","#id_clear",function(){
    $("#id_interview_heading").val("");
	tinyMCE.activeEditor.setContent('');
    $("#id_interview_contact").val("");
    $("#id_interview_company").val("");
	$("#id_interview_priority").val("");
	$("#id_interview_status").prop('checked', true);
	$("#id_interview_share").prop('checked', true);
	$("#id_interview_expires_by_day").val(ed);
	$("#id_interview_expires_by_month").val(em);
	$("#id_interview_expires_by_year").val(ey);
	$(".fp-file-delete").trigger("click");
	$(".fp-dlg-butconfirm").trigger("click");
  });
  
$('#id_interview_priority').change(function(){
	var interview_id = $("input[name=id]").val();
	var priority=$(this).val();
			var pdata= { 
			'priority': priority,
			'interview_id':interview_id
		};
		$.ajax({
				url: 'ajax.php', 
				type: "POST",
				data: pdata,
				dataType: "json",
				success : function(res){
					if(res.status=="Success"){
						return true;
					}else{
						$('#prioritymodal').modal('show');
						$('#prioritymodal .modal-body').html("<b>"+res.interview_priority+"<br>Are you sure to over write?</b>");
					}
				}
			});
	
});
$('#confirm_priority').on('click',function(){
	$('#prioritymodal').modal('hide');
});
$('#cancel_priority').on('click',function(){
	$("#id_interview_priority").val("");
	$('#prioritymodal').modal('hide');
	
});
$('#id_interview_status').on('click',function(){
	var priority=$('#id_interview_priority').val();
	if($(this).is(':checked'))
	$("#id_interview_priority").val(priority).trigger("change");
});
});
</script>