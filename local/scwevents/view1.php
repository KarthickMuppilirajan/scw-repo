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

global $USER;
$site = get_site();
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$fullname = $site->fullname;
$systemcontext = context_system::instance();
$id = required_param('id',PARAM_INT);

if (!isset($CFG->additionalhtmlhead)) {
    $CFG->additionalhtmlhead = '';
}

$event = $DB->get_record('local_scwevents', array('id'=>$id), '*', MUST_EXIST);

if(empty($event)){
    $PAGE->set_pagelayout('scwpage');
    $PAGE->set_context($systemcontext);
    $pageparams = array("id" => $id);
    $PAGE->set_url('/local/scwevents/view1.php', $pageparams);
    $PAGE->set_title('Events not available | Events on Supplychainwire');
	$etitle = 'Event ID not valid';
	$emessage = 'Given Event ID is not valid.';
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwevents/error', array('title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	));
	echo $OUTPUT->footer();
	exit;
}
$eoptions = array('accepted_types' => '*',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
);
$eoptions['context'] = $systemcontext;
$eoptions['subdirs'] = file_area_contains_subdirs($systemcontext, 'local_scwevents', 'event_description', $event->id);

$event_content = file_rewrite_pluginfile_urls($event->event_description, 'pluginfile.php', $systemcontext->id, 'local_scwevents', 'event_description', $eoptions->id);
$event_content = format_text($event_content, $event->event_descriptionformat, $eoptions, $event->id);
$video_poster = local_scwevents_get_img($event->id);

$pagetitle = $videos->event_name.' | Event on Supplychainwire';
$PAGE->set_pagelayout('scwpage');
$PAGE->set_context($systemcontext);
$pageparams = array("id" => $id);
$PAGE->set_url('/local/scwevents/view1.php', $pageparams);
$PAGE->set_title($pagetitle);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';
$pagedesc = 'event detail page';
$ogurl = new moodle_url('/local/scwevents/view1.php', $pageparams);
$ogurl = $ogurl->__toString();

$CFG->additionalhtmlhead .= '<meta name="og:url" content="'.$ogurl.'" />';
$CFG->additionalhtmlhead .= '<meta property="og:type" content="article" />';
$CFG->additionalhtmlhead .= '<meta property="og:title" content="'.$pagetitle.'" />';
$CFG->additionalhtmlhead .= '<meta property="og:description" content="'.strip_tags($event->event_description).'" />';
$CFG->additionalhtmlhead .= '<meta property="og:image" content="'.$video_poster.'" />';

//echo $OUTPUT->header();

$event_name=$event->event_name;
$event_description=$event->event_description;
$event_date=date('d',$event->event_startdate);
$event_startdate=date('d',$event->event_startdate);
$event_enddate=date('d',$event->event_enddate);
$event_month=date('M',$event->event_startdate);
$event_year=date('Y',$event->event_startdate);
$event_time=date('h.i a',$event->event_startdate);
$event_city=$event->event_city;
$event_state=$event->event_state;
$event_country = $event->event_country;
$event_address=$event->event_address;
$eventshare = $event->event_share;

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
<img src="<?php echo $video_poster; ?>" /><br />
<p><?php echo strip_tags($event->event_description);?></p>
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