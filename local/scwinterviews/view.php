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
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

global $PAGE,$USER;

$title = 'Interview details';

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$systemcontext = context_system::instance();
$id = optional_param('id', 0, PARAM_INT);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';

if (!isset($CFG->additionalhtmlhead)) {
    $CFG->additionalhtmlhead = '';
}

$sql="SELECT * FROM {local_scwinterviews} WHERE id=$id and interview_delete='0'";
$result = $DB->get_record_sql($sql);
if(empty($result)){
    $PAGE->set_pagelayout('scwpage');
    $PAGE->set_context($systemcontext);
    $pageparams = array("id" => $id);
    $PAGE->set_url('/local/scwinterviews/view.php', $pageparams);
    $PAGE->set_title('Interviews not available | Interviews on Supplychainwire');
	$etitle = 'Interview ID not valid';
	$emessage = 'Given Interview ID is not valid.';
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwinterviews/error', array('title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	));
	echo $OUTPUT->footer();
	exit;
}

$id=$result->id;
$interviewname=$result->interview_heading;
$interviewdescription=$result->summary;
$interviewshare = $result->interview_share;

$voptions = array('accepted_types' => '*',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
);
$voptions['context'] = $systemcontext;
$voptions['subdirs'] = file_area_contains_subdirs($systemcontext, 'local_scwinterviews', 'summary', $id);
$video_content = file_rewrite_pluginfile_urls($interviewdescription, 'pluginfile.php', $systemcontext->id, 'local_scwinterviews', 'summary', $id);
$video_content = format_text($video_content, $interviewdescription, $voptions, $id);
$interviewdescription=$video_content;

$pagetitle = $result->interview_heading.' | Interviews on Supplychainwire';
$PAGE->set_context($systemcontext);
$PAGE->set_url('/local/scwinterviews/view.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($pagetitle);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix/noimage.jpg';
$pagedesc = 'Interview detail page';
$video_poster = local_scwinterviews_get_img($id);
$summary = strip_tags($result->summary);
$pageparams = array("id" => $id);
$ogurl = new moodle_url('/local/scwinterviews/view.php', $pageparams);
$ogurl = $ogurl->__toString();

$CFG->additionalhtmlhead .= '<meta name="og:url" content="'.$ogurl.'" />';
$CFG->additionalhtmlhead .= '<meta property="og:type" content="article" />';
$CFG->additionalhtmlhead .= '<meta property="og:title" content="'.$pagetitle.'" />';
$CFG->additionalhtmlhead .= '<meta property="og:description" content="'.substr($summary,0,200).'" />';
$CFG->additionalhtmlhead .= '<meta property="og:image" content="'.$video_poster.'" />';

echo $OUTPUT->header();
?>

<div class="interviewlstdetail-blk">
<div class="interviewlst-title clearfix">
<div class="col-lg-10"> 
<h4 class="mar-top5"><i class="fa fa-users"></i><?php echo $interviewname;?></h4>
</div>
<div class="col-lg-2 ">
<?php if($interviewshare == "1"){ ?>
<button id="share" class="btn btn-sm btn-ashblk pull-right"><i class="fa fa-mail-forward"></i> Share</button>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<div id="sharebutton"  class="addthis_inline_share_toolbox"></div>
<?php } ?>
</div>
</div>

<div class="interviewlst-detaials">
<?php echo $interviewdescription;?>
</div>

<!-- Other interviews display here -->
<?php echo local_scwinterviews_other_interviews($id); ?>

</div>
<?php
echo $OUTPUT->footer();
?>

<script type="text/javascript">
require(['jquery','theme_bootstrap/bootstrap'], function( $ ) {
$( "#share" ).click(function() {
	$("#sharebutton").slideToggle();
	$(".at-svc-twitter").attr('id','ev_tw_<?php echo $id?>');
	$(".at-svc-facebook").attr('id','ev_fb_<?php echo $id?>');
	$(".at-svc-google_plusone_share").attr('id','ev_gp_<?php echo $id?>');
	$(".at-svc-linkedin").attr('id','ev_li_<?php echo $id?>');
});
  $('#media').carousel({
    pause: true,
    interval: false,
  });
});
</script>