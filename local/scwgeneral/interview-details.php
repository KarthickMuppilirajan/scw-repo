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
<h4 class="mar-top5"><i class="fa fa-users"></i>INTERVIEW DETAILS</h4>
</div>
<div class="col-sm-2 col-md-2 col-lg-2">
<button class="btn btn-sm btn-ashblk pull-right"><i class="fa fa-mail-forward"></i> Share</button>
</div>
</div>

<div class="interviewlst-detaials">
<img src="<?php echo $turl; ?>/interview_details_img.png" />
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu.</p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu.</p>
<h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua</h5>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu.</p>

<h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua</h5>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu.</p>

<h5>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua</h5>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor  incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud  exercitation ullamco laboris nisi ut aliqu.</p>
</div>

<div class="otherintervw-sliderblk">
<h4>OTHER INTERVIEWS</h4>
<div class="otherintervw-sliderblk-contain">
  <div class='row'>
    <div class='col-sm-12 col-md-12 col-md-12 col-lg-12'>
      <div class="carousel slide media-carousel" id="media">
        <div class="carousel-inner">
          <div class="item  active">
            <div class="row">
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>          
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 2.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 3.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 4.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>
            </div>
          </div>
          <div class="item">
            <div class="row">
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>          
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>     
            </div>
          </div>
          <div class="item">
            <div class="row">
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>          
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
              </div>
              <div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit 1.</h6>
              <img src="<?php echo$turl; ?>/professionimg1.png" />
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
              </div>               
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