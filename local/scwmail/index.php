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
 * @package local-scwmail
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once('lib.php');
global $PAGE;
require_login(); 
$title = 'Mailbox';

$PAGE->requires->js('/local/scwmail/js/custom.js');
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwmail/index.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$userid = $USER->id;

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();
$inbox_count= local_scwmail_get_inbox_count($userid,'inbox');
$baseurl = $CFG->wwwroot.'/local/scwmail/index.php';
?>

<?php
/* pagination part */

$page = optional_param('page','0',PARAM_INT);
$seg = $page;
$per_page = '10';
$offset  = $seg*$per_page;
$compose_url = $CFG->wwwroot.'/local/scwmail/compose.php';
 ?>

<div class="mailbox-blk">
<div class="mailbox-title clearfix">
<div class="col-sm-6 col-md-6 col-lg-8"> 
<h4 class="mar-top5"><i class="fa fa-envelope"></i> Mailbox</h4>
</div>

<div class="col-sm-8 col-md-6 col-lg-4">
<div class="btn-group">
	<button class="btn btn-sm btn-ash btn-delete">Delete</button> 
    </div>
    <div class="btn-group">
    <form action="<?= $compose_url; ?>" method="post">
	    <button class="btn btn-sm btn-brown pull-right">Compose mail</button>
    </form>
</div>
</div>
</div>

<div class="mailbox-detaials">
<?php
echo local_scwmail_fetch_index($userid,'inbox',$per_page,$offset);

echo html_writer::start_tag('div', array('class'=>'pull-left alert alert-info'));
echo "We will retain mail(s) less than 60 days";
echo html_writer::end_tag('div');

echo html_writer::start_tag('div', array('class'=>'pull-right'));
echo $OUTPUT->paging_bar($inbox_count, $page, $per_page, $baseurl);
echo html_writer::end_tag('div');
?>
</div>



</div>
<?php
echo $OUTPUT->footer();
?>
<?php if($inbox_count>0){ ?>
<script type="text/javascript">
require(['jquery'], function( $ ) {
$('table.mailbox > tbody > tr').each(function(){
  var msg_id= $(this).find('.message_id').val();
  var tr = $(this).attr('data-url','view.php?msg_id='+msg_id);
  tr.css('cursor','pointer');
  //var td=$(this).find('td').not(':first').addClass('highlight');
  var td=$(this).find('td').not(':first');
  td.on('click',function(){
	  //console.log($(this).parent().data('url'));
	  var url=$(this).parent().data('url')
	  window.location.href = url;
  });
});
});
</script>
<?php } ?>

