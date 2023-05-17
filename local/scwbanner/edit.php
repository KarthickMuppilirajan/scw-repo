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

require_once('edit_form.php');
global $USER;
require_login();

$id = optional_param('id', 0, PARAM_INT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

$afmonth = $time + 30 * 3600 * 24;
$day = date("j", $afmonth);
$mon = date("n", $afmonth);
$year = date("Y", $afmonth);

if ($id) {
	$banners = $DB->get_record('local_scwbanner', array('id' => $id), '*', MUST_EXIST);
	$pagedesc = 'Edit Banner';
	$pageparams = array('id' => $id);
	$banners->banner_modified = $time;
	$banners->banner_modified_by = $USER->id;
    $PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
    $PAGE->navbar->add(get_string('managebanners','local_scwbanner'), new moodle_url('/local/scwbanner/admin.php'));
    $PAGE->navbar->add(get_string('editbanner','local_scwbanner'));
}else{
	$banners = new stdClass;
	$pagedesc = 'Add Banner';
	$pageparams = array();
	$banners->id = null;
	$banners->banner_created = $time;
	$banners->banner_modified = $banners->banner_created;
	$banners->banner_created_by = $USER->id;
	$banners->banner_modified_by = $USER->id;
    $PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
    $PAGE->navbar->add(get_string('managebanners','local_scwbanner'), new moodle_url('/local/scwbanner/admin.php'));
    $PAGE->navbar->add(get_string('addbanner','local_scwbanner'));
}

$site = get_site();
$fullname = $site->fullname;
$syscontext = context_system::instance();
$PAGE->set_context($syscontext);
$PAGE->set_pagelayout('admin');
$abimages = scw_banner_position_images();
$sbimages = json_encode($abimages);
$PAGE->set_url('/local/scwbanner/edit.php', $pageparams);

if ( !has_capability('local/scwbanner:editbanner', $syscontext) && ($id > 0) ) {
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

if(!has_capability('local/scwbanner:addbanner', $syscontext) && ($id == "0") ){
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("addaccessdenied","local_scwbanner");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwbanner/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}




$textfieldoptions = array('trusttext'=>true, 'subdirs'=>true, 'maxfiles'=> 2, 'maxbytes'=> $CFG->maxbytes, 'context' => $syscontext);

$args = array(
        'editoroptions' => $textfieldoptions
    );
$editform = new banners_edit_form(null, $args);
 
$draftitemid = file_get_submitted_draft_itemid('banner_image');
 
file_prepare_draft_area($draftitemid, $syscontext->id, 'local_scwbanner', 'banner_image', $banners->id,
                        array('subdirs' => 0, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => 1));
 
$banners->banner_image = $draftitemid;
$editform->set_data($banners);

if ($editform->is_cancelled()) {
	redirect($CFG->wwwroot.'/local/scwbanner/admin.php');
}else if ($cnddata = $editform->get_data()) {
	//echo "Data Fetch";
	$banners->banner_name = $cnddata->banner_name;
	$banners->banner_company = $cnddata->banner_company;
	$banners->banner_contact = $cnddata->banner_contact;
	$banners->banner_expires_by = $cnddata->banner_expires_by;
	$banners->banner_page = $cnddata->banner_page;
	$banners->banner_position = $cnddata->banner_position;
	$banners->banner_caption = $cnddata->banner_caption;
	$banners->banner_url = $cnddata->banner_url;
	$banners->banner_porder = $cnddata->banner_porder;
	$banners->banner_status = $cnddata->banner_status;
	$url = $CFG->wwwroot.'/local/scwbanner/admin.php';
	
	  //priority check
	  $bannerarr = array('banner_delete' => '0' ,'banner_porder' => $cnddata->banner_porder,'banner_position' => $cnddata->banner_position,'banner_page' => $cnddata->banner_page,'banner_status' => '1');
	  $priority_check = $DB->get_record('local_scwbanner', $bannerarr , '*', IGNORE_MULTIPLE);
	  
	  if(!empty($priority_check->id)){
		  $priority = new stdClass;
		  $priority->banner_status = 0;
		  $priority->id = $priority_check->id;
		   $DB->update_record('local_scwbanner', $priority);
	  }
		
	
    if (empty($banners->id)) {
        $banner_id = $DB->insert_record('local_scwbanner', $banners);
		$banners->id = $banner_id;
		$msg = 'Banner added successfully.';
    } else {
        $DB->update_record('local_scwbanner', $banners);
		$msg = 'Banner updated successfully.';
    }

    file_save_draft_area_files($cnddata->banner_image, $syscontext->id, 'local_scwbanner', 'banner_image',
                   $banners->id, array('subdirs' => 0, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => 1));
	
    redirect($url, $msg);
}



echo $OUTPUT->header();
echo $OUTPUT->heading($pagedesc);


$editform->display();

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
require(['jquery','theme_bootstrap/bootstrap'], function( $ ) {
  var bimages = <?php echo $sbimages; ?>;
  var ed = "<?php echo $day; ?>";
  var em = "<?php echo $mon; ?>";
  var ey = "<?php echo $year; ?>";
  
  
  $(document).on("change", "#id_banner_position", function(){
	 var cmbpos = $("#id_banner_position option").filter(":selected").val();
     var img = bimages[cmbpos];
     $("#banner-size-img").attr("src",img);
  });
  
  $("#id_banner_position").trigger("change");
  
  $(document).on("click","#id_clear",function(){
    $("#id_banner_name").val("");
    $("#id_banner_company").val("");
    $("#id_banner_contact").val("");
    $("#id_banner_contact").val("");
	$("#id_banner_expires_by_day").val(ed);
	$("#id_banner_expires_by_month").val(em);
	$("#id_banner_expires_by_year").val(ey);
    $("#id_banner_page").val("site-index");
    $("#id_banner_position").val("top");
	$("#id_banner_position").trigger("change");
    $("#id_banner_caption").val("");
    $("#id_banner_url").val("");
    $("#id_banner_porder").val("");
    $("#id_banner_status").prop('checked', true);
	$("#fitem_id_banner_image .fp-thumbnail").trigger("click");
	$(".fp-file-delete").trigger("click");
	$(".fp-dlg-butconfirm").trigger("click");
	
  });
  
   $('#id_banner_porder').change(function(){
		var banner_id = $("input[name=id]").val();
		var banner_position=$('#id_banner_position').val();
		var banner_page=$('#id_banner_page').val();
		var priority=$(this).val();
		
				var pdata= { 
				'priority': priority,
				'banner_id':banner_id,
				'banner_position':banner_position,
				'banner_page':banner_page
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
		$("#id_banner_porder").val("");
		$('#prioritymodal').modal('hide');
		
	});
	$('#id_banner_status').on('click',function(){
		var priority=$('#id_banner_porder').val();
		if($(this).is(':checked'))
		$("#id_banner_porder").val(priority).trigger("change");
	});
	 $('#id_banner_page,#id_banner_position').change(function(){
		  var priority=$('#id_banner_porder').val();
		 $("#id_banner_porder").val(priority).trigger("change");
	 });
  
});
</script>
