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
 * @package local-scwnewsletter
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
global $PAGE;

require_login();
$syscontext = context_system::instance();

$title = 'SupplyChainWire - Newsletters';

$search_title = optional_param('search_title','',PARAM_TEXT);

$pageurl = new moodle_url("/local/scwnewsletter/newsletters.php");
$delete_url = new moodle_url("/local/scwnewsletter/action.php");
$compose_url = new moodle_url("/local/scwnewsletter/compose.php");

$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwnewsletter/newsletters.php');
$PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
$PAGE->navbar->add(get_string('managenewsletter','local_scwnewsletter'));
$PAGE->set_pagelayout('coursecategory');
$PAGE->set_title($title);


if(!has_capability('local/scwnewsletter:viewnewsletter', $syscontext) ){
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


$renderer = $PAGE->get_renderer('local_scwnewsletter');


/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();

?>
<h3><?php echo $title; ?></h3>
<hr/>
<div class='form-inline row'>
    
    <div class='form-group col-xs-12 col-sm-10 col-md-7 col-lg-8'>
	    <form class="form-inline" name="frmaddevent" action="<?php echo $pageurl; ?>" method="get">
          <input type='text' placeholder='Type text' name='search_title' id="search_title" class='form-control' value="<?php echo $search_title; ?>" />
		  <button type="submit" class="form-control" id="btn-search-nletter"><?=get_string('search', 'local_scwnewsletter');?></button>
	    </form>	
    </div>
    

	<div class='form-group col-xs-12 col-sm-6 col-md-5 col-lg-4 pull-right'>
		<form class="form-inline" name="frmaddevent" action="<?php echo $compose_url; ?>" method="post">
        <a href="<?php echo new moodle_url('/local/scwnewsletter/subscribers.php')?>"><input type="button" value="<?=get_string('managesubscribers', 'local_scwnewsletter');?>" name="add_new" class="btn btn-ashblk "></a>
		<input type="submit" value="<?=get_string('send_newsletter', 'local_scwnewsletter');?>" name="add_new" class="btn btn-sm btn-brown">
		</form>
    </div>

</div>

<?php
echo $renderer->scwnewsletter_list();

echo $OUTPUT->footer();

?>
<div class="modal fade" id="delete_subscibers_dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog" role="document">
  <form method="post" action="<?=$delete_url?>" name="delete_subscriber">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Are you sure to delete?</h4>
      </div>
      <input type="hidden" value="delete" name="action" id="action" />
      <input type="hidden" value="" name="subscriber_id" id="subscriber_id" />
      <!--<div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>-->
      <div class="modal-footer">
        <button type="button" class="btn btn-ash" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-brown">Delete</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
require(['jquery'], function( $ ) {
$('.delete-subc').on('click', function(){
	var delete_id= $(this).data('id');
	$('#delete_subscibers_dialog #subscriber_id').val(delete_id);
	$('#delete_subscibers_dialog').modal('show'); 
});
	
});
</script>
