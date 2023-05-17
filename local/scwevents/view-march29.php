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
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

global $PAGE,$USER;

$title = 'Event details';
$addurl = new moodle_url("/local/scwbanner/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwbanner/admin.php");
$actionurl = new moodle_url("/local/scwbanner/banner_action.php");
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$syscontext = context_system::instance();
$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwevents/view.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';
$id = optional_param('id', 0, PARAM_INT);
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$sql="SELECT * FROM {local_scwevents} WHERE id=$id";
$result = $DB->get_record_sql($sql);
$id=$result->id;
$event_name=$result->event_name;
$event_description=$result->event_description;
$event_date=date('d',$result->event_startdate);
$event_startdate=date('d',$result->event_startdate);
$event_enddate=date('d',$result->event_enddate);
$event_month=date('M',$result->event_startdate);
$event_year=date('Y',$result->event_startdate);
$event_time=date('h.i a',$result->event_startdate).' UTC';
$event_city=$result->event_city;
$event_state=$result->event_state;
$event_country = $result->event_country;
$event_address=$result->event_address;
$eventshare = $result->event_share;

$voptions = array('accepted_types' => '*',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
);
$voptions['context'] = $syscontext;
$voptions['subdirs'] = file_area_contains_subdirs($syscontext, 'local_scwevents', 'event_description', $id);

$video_content = file_rewrite_pluginfile_urls($event_description, 'pluginfile.php', $syscontext->id, 'local_scwevents', 'event_description', $id);
$video_content = format_text($video_content, $event_description, $voptions, $id);
$event_description=$video_content;


/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
?>
<div class="interviewlstdetail-blk">
<div class="interviewlst-title clearfix">
<div class="col-lg-10"> 
<h4 class="mar-top5"><i class="fa fa-users"></i><?php echo $event_name;?></h4>
<div style="color:#560c25; font-weight:600; font-size:12px; margin-left:35px;">
<?php 
if($event_startdate==$event_enddate)
echo $event_startdate; 
else
echo $event_startdate.' - '.$event_enddate;
echo ' '.$event_month.' '.$event_year.' '.'('.$event_time.') at '.$event_address.' '.$event_city.', '.$event_state.', '.$event_country;?>
</div>
</div>
<div class="col-lg-2 ">
<?php if($eventshare == "1"){ ?>
<button id="share" class="btn btn-sm btn-ashblk pull-right"><i class="fa fa-mail-forward"></i> Share</button>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<div id="sharebutton"  class="addthis_inline_share_toolbox"></div>
<?php } ?>
</div>
</div>

<div class="interviewlst-detaials">
<?php echo $event_description;?>
</div>

<?php 
$sql="SELECT * FROM {local_scwevents} WHERE event_status = '1' AND (event_startdate > $time or event_enddate > $time)  and id !=$id ORDER BY event_startdate ASC";
$totalcount = $DB->count_records_sql("SELECT COUNT('x') FROM {local_scwevents} WHERE event_status = '1' AND (event_startdate > $time or event_enddate > $time) and id !=$id");
$section=round($totalcount/4);



$result = $DB->get_records_sql($sql);
foreach($result as $obj)
{	
}
	?>    
<div class="otherintervw-sliderblk otherevent-sliderblk">
<h4>OTHER EVENTS</h4>
<div class="otherintervw-sliderblk-contain">
  <div class='row'>
    <div class='col-sm-12 col-md-12 col-md-12 col-lg-12'>
      <div class="carousel slide media-carousel" id="media">
        <div class="carousel-inner">
        	<div class="item active">
            <div class="row">
        <?php $key=0;
		foreach($result as $obj)
			  {
				$id=$obj->id;
				$event_name=$obj->event_name;
				$event_description=strip_tags($obj->event_description);
				$event_description=trim(substr($event_description,0,80));
				$event_date=date('d',$obj->event_startdate);
				$event_month=date('M',$obj->event_startdate);
				$event_time=date('H.i a',$obj->event_startdate);
				$url=$CFG->wwwroot.'/local/scwevents/view.php?id='.$id;

				  $key++;
				  if(($key%5)==0)
				  {
					  echo '</div>
					          </div>
							   	<div class="item">
 			                        <div class="row">
							';
					  
				  }
				  echo '<div class="col-lg-3">
              <div class="otherintervw-innerslidr">
              <h6> <a href="'.$url.'">'.$event_name.'</a></h6>              
              <div class="calendar-blk">
            <span class="date-disp"><strong>'.$event_date.'</strong></span><br>
            <span class="month-disp"><strong>'.$event_month.'</strong></span>
            </div>
              <p>'.$event_description.'</p>
              </div>               
              </div>';


			  }
			?>
          
          
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