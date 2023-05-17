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
    'accepted_types' => 'web_image',
	'context' => $syscontext
);

$editoroptions = array('accepted_types' => 'web_video',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
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
 
//$draftitemid = file_get_submitted_draft_itemid('video_thumb');
 
/* file_prepare_draft_area($draftitemid, $syscontext->id, 'local_scwvideos', 'video_thumb', $videos->id,
                        $thumboptions); */

$videos = file_prepare_standard_filemanager($videos, 'video_thumb', $thumboptions, $syscontext, 'local_scwvideos', 'video_thumb', $videos->id);
 
//$videos->video_thumb = $draftitemid;
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
	
	
	 //priority check
	  $videoarr = array('video_delete' => '0','video_porder' => $cnddata->video_porder,'video_status' => '1');
	  $priority_check = $DB->get_record('local_scwvideos', $videoarr , '*', IGNORE_MULTIPLE);
	  
	  if(!empty($priority_check->id)){
		  $priority = new stdClass;
		  $priority->video_status = 0;
		  $priority->id = $priority_check->id;
		   $DB->update_record('local_scwvideos', $priority);
	  }
	  
    if (empty($videos->id)) {
        $video_id = $DB->insert_record('local_scwvideos', $videos);
		$videos->id = $video_id;
		$msg = 'Video added successfully.';
    } else {
        $DB->update_record('local_scwvideos', $videos);
		$msg = 'Video updated successfully.';
    }

    $cnddata->id = $videos->id;
	$cnddata = file_postupdate_standard_editor($cnddata, 'video_content', $editoroptions, $syscontext, 'local_scwvideos', 'video_content', $videos->id);
	
	$cnddata = file_postupdate_standard_filemanager($cnddata, 'video_thumb', $thumboptions, $syscontext,
                                              'local_scwvideos', 'video_thumb', $videos->id);

    $DB->update_record('local_scwvideos', $cnddata);
	
    redirect($url, $msg);
}



echo $OUTPUT->header();
echo $OUTPUT->heading($pagedesc);


$editform->display();
?>

<div class="modal fade" id="previewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
     <div class="modal-header">
         <h4 class="modal-title" id="video_title">Video Preview</h4>
     </div>
     <div class="modal-body">
		<div id="video_thumb"></div>
		<div id="video_description"></div>
		<br>
		<div id="video_content_info">
		   
		</div>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
   </div>
  </div>
</div>

<?php

echo $OUTPUT->footer();

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
</div>';

?>
<script type="text/javascript">
var mpl = '';
require(['jquery','theme_bootstrap/bootstrap'], function( $ ) {
	
  $("#id_preview").click(function(){
	  var vdesc = $("#id_video_description").val();
	  var psdesc = '<p><strong>Video Description</strong></p>';
	  $("#video_description").html(psdesc+vdesc);
	  var vtitle = $("#id_video_heading").val();
	  $("#video_title").html(vtitle);
	  var ptdesc = '<p><strong>Video Thumb</strong></p>';
	  var vthumb = $("#fitem_id_video_thumb_filemanager").find(".fp-thumbnail").html() || '';
	  $("#video_thumb").html(ptdesc+vthumb);
	  
	  $("#previewmodal").modal('show');
	  var purl = M.cfg.wwwroot+'/local/scwvideos/preview-video.php';
	  var content = tinyMCE.get("id_video_content_editor").getContent();
	  $.ajax({
		 method: "POST",
		 url: purl,
		 data: "videostr="+content,
		 async:false
	  }).done(function( sdata ) {
		 var data = JSON.parse(sdata);
		 var msg = data.videocontent;
         $("#video_content_info").html(msg);
      });
	  
	 var id = $("#video_content_info video").attr("id");
     var config = $("#"+id).data('setup');
	 var modules = ['media_videojs/video-lazy'];
	 modules.push('media_videojs/Youtube-lazy');
	 require(modules, function(videojs) {
			mpl = videojs(id, config);
      });
   });
   
   $('#previewmodal').on('hidden.bs.modal', function () {
     mpl.dispose();
   });
   
   $("#id_clear").click(function(){
	   tinyMCE.get("id_video_content_editor").setContent('', {format : 'raw'});
       $("#id_video_description").val('');
	   $("#id_video_heading").val('');
	   $("#fitem_id_video_thumb_filemanager .fp-thumbnail").trigger("click");
	   $(".fp-file-delete").trigger("click");
	   $(".fp-dlg-butconfirm").trigger("click");
	   $("#id_video_porder").val("1");
	   $("#id_video_status").prop('checked', true);
	   $("#id_video_share").prop('checked', true);
   });
   
   $('#id_video_porder').change(function(){
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
		$("#id_video_porder").val("");
		$('#prioritymodal').modal('hide');
		
	});
	$('#id_video_status').on('click',function(){
		var priority=$('#id_video_porder').val();
		if($(this).is(':checked'))
		$("#id_video_porder").val(priority).trigger("change");
	});
   
});
</script>


