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
global $PAGE,$USER,$DB;

$title = 'Events';
$addurl = new moodle_url("/local/scwbanner/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwbanner/admin.php");
$actionurl = new moodle_url("/local/scwbanner/banner_action.php");
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwevents/event-list.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();

?>
<div class="search-blk">
<h4><i class="fa fa-search"></i>EVENT LIST</h4>
<div class="interviewsearch-fileld">
<form name="frm" class="form-inline">
<div class="form-group"> 
<label for="exampleInputName2">Events</label>
<input name="keyword" class="form-control" id="exampleInputName2" placeholder=""> 
</div> 
<button class="btn btn-brown">SEARCH</button> 
</form>
</div>
</div>
<div class="eventlist-blk">
<h4><i class="fa fa-calendar"></i>EVENTS</h4>
<?php 
if(isset($_REQUEST['keyword']))
{
	$keyword=$_REQUEST['keyword'];
	$sql="SELECT * FROM {local_scwevents} WHERE event_status = '1' AND (event_startdate > $time or event_enddate > $time) and event_name like '%$keyword%' ORDER BY event_startdate ASC LIMIT 0,10";
}
else
{
	$sql="SELECT * FROM {local_scwevents} WHERE event_status = '1' AND (event_startdate > $time or event_enddate > $time) ORDER BY event_startdate ASC LIMIT 0,10";
}

$result = $DB->get_records_sql($sql);
if(empty($result))
{
	echo '<div class="eventlist-contnt"> <b>No records found</div>';
	
}
else
{
foreach($result as $obj)
{	
	$id=$obj->id;
	$event_name=$obj->event_name;
	$event_description=strip_tags($obj->event_description);
	$event_description=trim(substr($event_description,0,300));
	$event_date=date('d',$obj->event_startdate);
	$event_month=date('M',$obj->event_startdate);
	$event_time=date('H.i a',$obj->event_startdate);
	$url=$CFG->wwwroot.'/local/scwevents/event-details.php?id='.$id;
	?>    
<div class="eventlist-contnt">
  <div class="row">
 <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1">
<div class="calendar-blk">
<span class="date-disp"><strong><?php echo $event_date;?></strong></span><br>
<span class="month-disp"><strong><?php echo $event_month;?></strong></span>
</div>
  </div>
<div class="col-xs-8 col-sm-9 col-md-10 col-lg-11 padlft-non">
  <div class="eventlist-contntdisp">
<h5><a href="<?php echo $url?>"><?php echo $event_name;?></a><span><a href="<?php echo $url?>"><button class="btn btn-sm btn-ashblk pull-right">View More</button></span></a></h5>
<span class="clearfix"><strong><?php echo $event_time;?></strong></span>
<img class="clearfix" src="<?php echo $turl; ?>/border-btm.png" />

</div>
</div>
<p><?php echo $event_description;?>...</p>
  </div>
  <img class="clearfix contntbtm-border" src="<?php echo $turl; ?>/border.png" />
  </div>
<?php }
}?>
</div>

<?php
echo $OUTPUT->footer();