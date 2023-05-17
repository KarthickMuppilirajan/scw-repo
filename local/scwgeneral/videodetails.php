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
global $PAGE,$USER;

$title = 'Subscription';
$addurl = new moodle_url("/local/scwbanner/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwbanner/admin.php");
$actionurl = new moodle_url("/local/scwbanner/banner_action.php");
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwbanner/admin.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
?>
<div class="interviewlstdetail-blk">
<div class="interviewlst-title clearfix">
<div class="col-sm-10 col-md-10 col-lg-10"> 
<h4 class="mar-top5"><i class="fa fa-users"></i>VIDEO DETAILS</h4>
</div>
<div class="col-sm-2 col-md-2 col-lg-2">
<button class="btn btn-sm btn-ashblk pull-right"><i class="fa fa-mail-forward"></i> Share</button>
</div>
</div>

<div class="videoplayr-disp">
<video controls="" width="400">
  <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4"></source>
  <source src="mov_bbb.ogg" type="video/ogg"></source>
  Your browser does not support HTML5 video.
</video>
</div>
<div class="videoplayr-details">
<h5><strong>Published on Mar 5, 2012</strong></h5>
<p>Dr. Ananth Iyer, Associate Dean at the Krannert School of Management, Purdue University, discusses the research and outcomes found in his book, "Toyota Supply Chain Management.</p>
</div>

<div class="otherintervw-sliderblk">
<h4>OTHER VIDEOS</h4>
<div class="otherintervw-sliderblk-contain">
  <div class='row'>
    <div class='col-sm-12 col-md-12 col-md-12 col-lg-12'>
      <div class="carousel slide media-carousel" id="media">
        <div class="carousel-inner">
          <div class="item  active">
            <div class="row">
              <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>          
              <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
              <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
              <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
            </div>
          </div>
          <div class="item">
            <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
            <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
            <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
            <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
          </div>
          <div class="item">
            <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
            <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
            <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
            <div class="col-lg-3">
              <div class="video-slider">
              <img class="img-rounded" src="<?php echo$turl; ?>/video_slider.png" />
              </div>                             
              </div>
          </div>
        </div>
        <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
        <a data-slide="next" href="#media" class="right carousel-control">›</a>
      </div>                          
    </div>
  </div>
</div>
</div>

</div>


<?php
echo $OUTPUT->footer();
?>

<script type="text/javascript">
require(['jquery'], function( $ ) {
  $('#media').carousel({
    pause: true,
    interval: false,
  });
});
</script>