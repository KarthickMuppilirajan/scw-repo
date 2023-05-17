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
<div class="eventlist-blk">
<h4><i class="fa fa-calendar"></i>EVENTS</h4>
<div class="eventlist-contnt">
  <div class="row">
 <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
<div class="calendar-blk">
<span class="date-disp"><strong>07</strong></span><br>
<span class="month-disp"><strong>FEB</strong></span>
</div>
  </div>
<div class="col-xs-8 col-sm-9 col-md-10 col-lg-11 padlft-non">
  <div class="eventlist-contntdisp">
<h5>Events Title<span><button class="btn btn-sm btn-ashblk pull-right">View More</button></span></h5>
<span class="clearfix"><strong>5.10 PM</strong></span>
<img class="clearfix" src="<?php echo $turl; ?>/border-btm.png" />

</div>
</div>
<p>Lorem Ipsum is simply 
dummy text. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
  </div>
  <img class="clearfix contntbtm-border" src="<?php echo $turl; ?>/border.png" />
  </div>
<div class="eventlist-contnt">
  <div class="row">
 <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
<div class="calendar-blk">
<span class="date-disp"><strong>07</strong></span><br>
<span class="month-disp"><strong>FEB</strong></span>
</div>
  </div>
<div class="col-xs-8 col-sm-9 col-md-10 col-lg-11 padlft-non">
  <div class="eventlist-contntdisp">
<h5>Events Title<span><button class="btn btn-sm btn-ashblk pull-right">View More</button></span></h5>
<span class="clearfix"><strong>5.10 PM</strong></span>
<img class="clearfix" src="<?php echo $turl; ?>/border-btm.png" />

</div>
</div>
<p>Lorem Ipsum is simply 
dummy text. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
  </div>
  <img class="clearfix contntbtm-border" src="<?php echo $turl; ?>/border.png" />
  </div>
<div class="eventlist-contnt">
  <div class="row">
 <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
<div class="calendar-blk">
<span class="date-disp"><strong>07</strong></span><br>
<span class="month-disp"><strong>FEB</strong></span>
</div>
  </div>
<div class="col-xs-8 col-sm-9 col-md-10 col-lg-11 padlft-non">
  <div class="eventlist-contntdisp">
<h5>Events Title<span><button class="btn btn-sm btn-ashblk pull-right">View More</button></span></h5>
<span class="clearfix"><strong>5.10 PM</strong></span>
<img class="clearfix" src="<?php echo $turl; ?>/border-btm.png" />

</div>
</div>
<p>Lorem Ipsum is simply 
dummy text. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
  </div>
  <img class="clearfix contntbtm-border" src="<?php echo $turl; ?>/border.png" />
  </div>
<div class="eventlist-contnt">
  <div class="row">
 <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
<div class="calendar-blk">
<span class="date-disp"><strong>07</strong></span><br>
<span class="month-disp"><strong>FEB</strong></span>
</div>
  </div>
<div class="col-xs-8 col-sm-9 col-md-10 col-lg-11 padlft-non">
  <div class="eventlist-contntdisp">
<h5>Events Title<span><button class="btn btn-sm btn-ashblk pull-right">View More</button></span></h5>
<span class="clearfix"><strong>5.10 PM</strong></span>
<img class="clearfix" src="<?php echo $turl; ?>/border-btm.png" />

</div>
</div>
<p>Lorem Ipsum is simply 
dummy text. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
  </div>
  <img class="clearfix contntbtm-border" src="<?php echo $turl; ?>/border.png" />
  </div>
<div class="eventlist-contnt">
  <div class="row">
 <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
<div class="calendar-blk">
<span class="date-disp"><strong>07</strong></span><br>
<span class="month-disp"><strong>FEB</strong></span>
</div>
  </div>
<div class="col-xs-8 col-sm-9 col-md-10 col-lg-11 padlft-non">
  <div class="eventlist-contntdisp">
<h5>Events Title<span><button class="btn btn-sm btn-ashblk pull-right">View More</button></span></h5>
<span class="clearfix"><strong>5.10 PM</strong></span>
<img class="clearfix" src="<?php echo $turl; ?>/border-btm.png" />

</div>
</div>
<p>Lorem Ipsum is simply 
dummy text. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
  </div>
  <img class="clearfix contntbtm-border" src="<?php echo $turl; ?>/border.png" />
  </div>
<div class="eventlist-contnt">
  <div class="row">
 <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
<div class="calendar-blk">
<span class="date-disp"><strong>07</strong></span><br>
<span class="month-disp"><strong>FEB</strong></span>
</div>
  </div>
<div class="col-xs-8 col-sm-9 col-md-10 col-lg-11 padlft-non">
  <div class="eventlist-contntdisp">
<h5>Events Title<span><button class="btn btn-sm btn-ashblk pull-right">View More</button></span></h5>
<span class="clearfix"><strong>5.10 PM</strong></span>
<img class="clearfix" src="<?php echo $turl; ?>/border-btm.png" />

</div>
</div>
<p>Lorem Ipsum is simply 
dummy text. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
  </div>
  <img class="clearfix contntbtm-border" src="<?php echo $turl; ?>/border.png" />
  </div>
<div class="searchreslt-pagination">
<ul class="pagination"> <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> <li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li> <li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> </ul>
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