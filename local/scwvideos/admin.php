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
global $PAGE;

require_login();
$syscontext = context_system::instance();

$title = 'SupplyChainWire - Videos List';
$addurl = new moodle_url("/local/scwvideos/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwvideos/admin.php");
$actionurl = new moodle_url("/local/scwvideos/video_action.php");
$searchtext = optional_param('searchtext','',PARAM_TEXT);

$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwvideos/admin.php');
$PAGE->set_pagelayout('coursecategory');
$PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
$PAGE->navbar->add(get_string('managevideos','local_scwvideos'));
$PAGE->set_title($title);
$renderer = $PAGE->get_renderer('local_scwvideos');

if (!has_capability('local/scwvideos:viewvideo', $syscontext)) {
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("viewaccessdenied","local_scwvideos");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwvideos/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();

?>
<h3><?php echo $title; ?></h3>
<hr/>
<div class='form-inline row'>
  <div class='form-group col-sm-10 col-md-5 col-lg-3 mform'>
    <form class="form-inline" id="frmvideostatus" action="<?php echo $actionurl; ?>" method="post">
	<span class="error hide" id="video_action_error"></span>
    <select class='form-control' name="video_action" id="video_action">
	   <option value="">Select</option>
       <option value="enabled">Enabled</option>
	   <option value="disabled">Disabled</option>
    </select>
	<input type="hidden" name="video_ids" value="">
	<input type="submit" name="apply" value="Apply" class="form-control">
	</form>
  </div>
  
    <div class='form-group col-sm-12 col-md-8 col-lg-7'>
	    <form class="form-inline" name="frmaddvideo" action="<?php echo $searchurl; ?>" method="get">
          <input type='text' placeholder='Type text' name='searchtext' id="searchtext" class='form-control' value="<?php echo $searchtext; ?>" />
		  <button type="submit" class="form-control" id="btn-video-search">Search</button>
	    </form>	
    </div>
	<?php if (has_capability('local/scwvideos:addvideo', $syscontext)) { ?>	
	<div class='form-group col-sm-8 col-md-4 col-lg-2'>
		<form class="form-inline" name="frmaddvideo" action="<?php echo $addurl; ?>" method="post">
		<input type="submit" value="Add Video" name="add_new" class="form-control">
		</form>
    </div>
	<?php } ?>
</div>

<?php
echo $renderer->video_list();

echo $OUTPUT->footer();

?>

<script type="text/javascript">
require(['jquery'], function( $ ) {
  
  function set_vids(){
    var vids = [];
    $('input.vid:checked').each(function(i,e) {
      vids.push(e.value);
    });
    vids = vids.join(',');
	$("input[name=video_ids]").val(vids);
  }
  
  $("select[name=video_action]").change(function(){
	  var vac = $("select[name=video_action]").find(":selected").val();
	  $("#video_action_error").addClass("hide");
	  if(vac==""){
		  $("#video_action_error").html("Please choose any one action").removeClass("hide");
	  }
  });
  
  $("#chkall").change(function(){
	 var chk = this.checked;
	  $("input.vid").each(function(){
		 $(this).prop("checked",chk);
	  });
	  set_vids();
  });
  
  $("input.vid").change(function(){
	  set_vids();
  });
  
  $("#frmvideostatus").submit(function(){
	  var vac = $("select[name=video_action]").find(":selected").val();
	  set_vids();
	  var vids = $.trim($("input[name=video_ids]").val());
	   
	  $("#video_action_error").addClass("hide");
	  var cnt = 0;
	  if(vac==""){
		  $("#video_action_error").html("Please choose any one action").removeClass("hide");
		  cnt++;
	  }else if(vids.length==0 ){
		  $("#video_action_error").html("Please choose any one video").removeClass("hide");
		  cnt++;
	  }
	  
	  if(cnt==0){
		  return true;
	  }
	  return false;
  });
});
</script>