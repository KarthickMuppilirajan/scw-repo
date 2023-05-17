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
global $PAGE;

require_login();
$syscontext = context_system::instance();

$title = 'SupplyChainWire - Events List';
$addurl = new moodle_url("/local/scwevents/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwevents/admin.php");
$actionurl = new moodle_url("/local/scwevents/event_action.php");
$searchtext = optional_param('searchtext','',PARAM_TEXT);

$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwevents/admin.php');
$PAGE->set_pagelayout('coursecategory');
$PAGE->set_title($title);
$PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
$PAGE->navbar->add(get_string('scwbanner:manageevents','local_scwevents'), new moodle_url('/local/scwevents/admin.php'));


$renderer = $PAGE->get_renderer('local_scwevents');

if (!has_capability('local/scwevents:viewevents', $syscontext)) {
	$etitle = get_string('accessdenied','admin');
	$emessage = get_string("viewaccessdenied","local_scwevents");
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwevents/error', ['title' => $etitle, 'message' => $emessage ,
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
    <form class="form-inline" id="frmeventstatus" action="<?php echo $actionurl; ?>" method="post">
	<span class="error hide" id="event_action_error"></span>
    <select class='form-control' name="event_action" id="event_action">
	   <option value="">Select</option>
       <option value="enabled">Enabled</option>
	   <option value="disabled">Disabled</option>
    </select>
	<input type="hidden" name="event_ids" value="">
	<input type="submit" name="apply" value="Apply" class="form-control">
	</form>
  </div>
  
    <div class='form-group col-sm-12 col-md-8 col-lg-7'>
	    <form class="form-inline" name="frmaddevent" action="<?php echo $searchurl; ?>" method="get">
          <input type='text' placeholder='Type text' name='searchtext' id="searchtext" class='form-control' value="<?php echo $searchtext; ?>" />
		  <button type="submit" class="form-control" id="btn-event-search">Search</button>
	    </form>	
    </div>
	<?php if (has_capability('local/scwevents:addevent', $syscontext)) { ?>	
	<div class='form-group col-sm-8 col-md-4 col-lg-2'>
		<form class="form-inline" name="frmaddevent" action="<?php echo $addurl; ?>" method="post">
		<input type="submit" value="Add Event" name="add_new" class="form-control">
		</form>
    </div>
	<?php } ?>
</div>

<?php
echo $renderer->event_list();

echo $OUTPUT->footer();

?>

<script type="text/javascript">
require(['jquery'], function( $ ) {
  
  function set_eids(){
    var eids = [];
    $('input.eid:checked').each(function(i,e) {
      eids.push(e.value);
    });
    eids = eids.join(',');
	$("input[name=event_ids]").val(eids);
  }
  
  $("select[name=event_action]").change(function(){
	  var eac = $("select[name=event_action]").find(":selected").val();
	  $("#event_action_error").addClass("hide");
	  if(eac==""){
		  $("#event_action_error").html("Please choose any one action").removeClass("hide");
	  }
  });
  
  $("#chkall").change(function(){
	 var chk = this.checked;
	  $("input.eid").each(function(){
		 $(this).prop("checked",chk);
	  });
	  set_eids();
  });
  
  $("input.eid").change(function(){
	  set_eids();
  });
  
  $("#frmeventstatus").submit(function(){
	  var eac = $("select[name=event_action]").find(":selected").val();
	  set_eids();
	  var eids = $.trim($("input[name=event_ids]").val());
	  
	  $("#event_action_error").addClass("hide");
	  var cnt = 0;
	  if(eac==""){
		  $("#event_action_error").html("Please choose any one action").removeClass("hide");
		  cnt++;
	  }else if(eids.length==0 ){
		  $("#event_action_error").html("Please choose any one event").removeClass("hide");
		  cnt++;
	  }
	  
	  if(cnt==0){
		  return true;
	  }
	  return false;
  });
});
</script>