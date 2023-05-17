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
 * @package local-newsletter
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once('compose_form.php');
require('lib.php');

require_login(); 

global $PAGE,$USER,$CFG;
$userid = $USER->id;

$title = 'Send Newsletter';

$site = get_site();
$fullname = $site->fullname;
$systemcontext = context_system::instance();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwnewsletter/compose.php');
$PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
$PAGE->navbar->add(get_string('managenewsletter','local_scwnewsletter'),new moodle_url('/local/scwnewsletter/newsletters.php'));

$PAGE->set_pagelayout('admin');
$PAGE->set_title($title);
$url = $CFG->wwwroot.'/local/scwnewsletter/newsletters.php';

if(!has_capability('local/scwnewsletter:addnewsletter', $systemcontext) ){
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("addaccessdenied","local_scwnewsletter");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwnewsletter/error', array('title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	));
	echo $OUTPUT->footer();
	exit;
}

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

$textfieldoptions = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=> 2, 'maxbytes'=> $CFG->maxbytes, 'context' => $systemcontext,'enable_filemanagement' => false);

$compose = new stdClass();
$compose->id = null;

$editoroptions = array('accepted_types' => 'web_video',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
);

$editoroptions['context'] = $systemcontext;
$editoroptions['subdirs'] = 0;
$compose = file_prepare_standard_editor($compose, 'message', $editoroptions, $systemcontext, 'local_scwnewsletter', 'message', $compose->id);

$args = array(
        'editoroptions' => $editoroptions,
    );
	
$composeform = new newsletter_compose_form(null,$args);

$composeform->set_data($compose);

if ($composeform->is_cancelled()) {
	redirect($CFG->wwwroot.'/local/scwnewsletter/newsletters.php');
}else if ($data = $composeform->get_data()) {
	
	
	$compose->user_id = $userid;
	$compose->title = $data->subject;
	$compose->message = '';
    $compose->messageformat = FORMAT_HTML;
	$compose->timecreated = $time;
	
	$compose_id = $DB->insert_record('local_scwnewsletter_messages', $compose);
	$data->id = $compose_id;
	
	$data = file_postupdate_standard_editor($data, 'message', $editoroptions, $systemcontext, 'local_scwnewsletter', 'message', $compose_id);
	$DB->update_record('local_scwnewsletter_messages', $data);
	if($compose_id){
		scwnewsltter_send_newsletter($compose_id,$data->user_type);
		$msg = 'Newsletter has been sent.';
		redirect($url, $msg);
	}
}

/**
 * // $PAGE->set_heading($title);
 */

echo $OUTPUT->header();
echo "<br><h3> Send Newsletter</h3>";
$composeform->display();

echo $OUTPUT->footer();
?>

<div class="modal fade" id="previewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
     <div class="modal-header">
         <h4 class="modal-title"></h4>
     </div>
     <div class="modal-body">
		<div id="newsletter_description" style="overflow:hidden;"></div>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
   </div>
  </div>
</div>
<script type="text/javascript">
require(['jquery'], function( $ ) {	
$("#id_preview").click(function(){
	$(".modal-title").html($("#id_subject").val());
	
	$("#newsletter_description").html(tinyMCE.get("id_message_editor").getContent());
	$("#previewmodal").modal('show');
});

$("#id_clear").click(function(){
	$("#id_subject").val('');
	$("#newsletter_description").val('');
	tinyMCE.activeEditor.setContent('');

});	

});
</script>