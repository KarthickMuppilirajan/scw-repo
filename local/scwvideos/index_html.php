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

<div class="search-blk">
<h4><i class="fa fa-search"></i>VIDEOS LIST</h4>
<div class="interviewsearch-fileld">
<form class="form-inline" action="" name="search" id="search" method="get">
<div class="form-group"> <label for="exampleInputName2">Video name</label> 
<input type="text" value="" name="search" id="search" >
</div> 
<button class="btn btn-brown" type = "submit">SEARCH</button> 
</form>
</div>
</div>

<div class="eventlist-blk">
<h4><i class="fa fa-video-camera"></i>VIDEOS</h4>
<div class="videos-lst">
<div class="row clearfix">
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos1.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos2.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos3.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos4.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos5.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos1.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos2.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos3.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
<div class="col-lg-4">
<div class="videoplyr">
<img class="clearfix img-responsive fullimg" src="<?php echo $turl; ?>/videos4.png" />
<div class="video-desc">Lorem Ipsum is simply dummy text of the 
printing and typesetting...</div>
</div>
</div>
</div>

</div>

<div class="searchreslt-pagination">
<ul class="pagination"> <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> <li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li> <li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> </ul>
</div>

</div>


<?php
echo $OUTPUT->footer();
?>