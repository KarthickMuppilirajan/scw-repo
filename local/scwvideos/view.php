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
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

global $USER;
$site = get_site();
$fullname = $site->fullname;
$syscontext = context_system::instance();
$id = required_param('id',PARAM_INT);

if (!isset($CFG->additionalhtmlhead)) {
    $CFG->additionalhtmlhead = '';
}


$video = $DB->get_record('local_scwvideos', array('id' => $id, "video_delete" => "0", "video_status" => "1"), '*');

if(empty($video)){
    $PAGE->set_pagelayout('scwpage');
    $PAGE->set_context($syscontext);
    $pageparams = array("id" => $id);
    $PAGE->set_url('/local/scwvideos/view.php', $pageparams);
    $PAGE->set_title('Video not available | Video on Supplychainwire');
	$etitle = 'Video ID not valid';
	$emessage = 'You are given video ID is not valid.';
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwvideos/error', array('title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	));
	echo $OUTPUT->footer();
	exit;
}

$voptions = array('accepted_types' => '*',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
);
$voptions['context'] = $syscontext;
$voptions['subdirs'] = file_area_contains_subdirs($syscontext, 'local_scwvideos', 'video_content', $video->id);
$videoposter = local_scwvideo_get_img($video->id);

$video_content = file_rewrite_pluginfile_urls($video->video_content, 'pluginfile.php', $syscontext->id, 'local_scwvideos', 'video_content', $video->id);
$video_content = format_text($video_content, $video->video_contentformat, $voptions, $video->id);
$video_content = str_replace("<video", "<video oncontextmenu=\"return false;\" ", $video_content);
$video_content = str_replace("<video", "<video poster=\"$videoposter\" ", $video_content);

$avideo  = local_scwvideo_get_url($video->id,$video_content);
$video_url  = $avideo["video"];
$video_name  = $avideo["videoname"];

$pagetitle = $video->video_heading.' | Video on Supplychainwire';
$PAGE->set_pagelayout('scwpage');
$PAGE->set_context($syscontext);
$pageparams = array("id" => $id);
$PAGE->set_url('/local/scwvideos/view.php', $pageparams);
$PAGE->set_title($pagetitle);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';
$pagedesc = 'Video detail page';
$ogurl = new moodle_url('/local/scwvideos/view.php', $pageparams);
$ogurl = $ogurl->__toString();

$CFG->additionalhtmlhead .= '<meta name="og:url" content="'.$ogurl.'" />';
$CFG->additionalhtmlhead .= '<meta property="og:type" content="article" />';
$CFG->additionalhtmlhead .= '<meta property="og:title" content="'.$pagetitle.'" />';
$CFG->additionalhtmlhead .= '<meta property="og:description" content="'.$video->video_description.'" />';
$CFG->additionalhtmlhead .= '<meta property="og:image" content="'.$videoposter.'" />';


echo $OUTPUT->header();
?>

<div class="interviewlstdetail-blk">
<div class="interviewlst-title clearfix">
<div class="col-sm-10 col-md-10 col-lg-10"> 
<h4 class="mar-top5"><i class="fa fa-users"></i><?php echo $video->video_heading; ?></h4>
</div>
<div class="col-sm-2 col-md-2 col-lg-2">
<?php if($video->video_share == "1"){ ?>
<button id="share" class="btn btn-sm btn-ashblk pull-right"><i class="fa fa-mail-forward"></i> Share</button>
<div id="sharebutton"  class="addthis_inline_share_toolbox"></div>
<?php } ?>
</div>
</div>

<div class="videoplayr-disp">
<?php echo $video_content; ?>
</div>
<div class="videoplayr-details">
<h5><strong><?php echo "Published on ".date("M d, Y", $video->video_created); ?></strong></h5>
<p><?php echo $video->video_description; ?></p>
</div>

<!-- Other Videos display here -->
<?php echo local_scwvideo_other_videos($id); ?>

</div>

<?php

echo $OUTPUT->footer();
?>

<script type="text/javascript">
require(['jquery','theme_bootstrap/bootstrap'], function( $ ) {
  $( "#share" ).click(function() {
    $("#sharebutton").slideToggle();
  });

  $('#media').carousel({
    pause: true,
    interval: false,
  });
});
</script>
