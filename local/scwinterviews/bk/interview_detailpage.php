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
global $PAGE,$USER;

$title = 'scw interview details';

$id = optional_param('id', 0, PARAM_INT);
if ($id) {

	$result = $DB->get_record('local_scwinterviews', array('id' => $id), '*', MUST_EXIST);
}

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwinterviews/interview_detailpage.php?id="'.$id.'"');
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
<h4 class="mar-top5"><i class="fa fa-users"></i><?php echo $result->interview_heading;?></h4>
</div>
<div class="col-sm-2 col-md-2 col-lg-2">
<?php if($result->interview_share==1){?>
<button id="share" class="btn btn-sm btn-ashblk pull-right"><i class="fa fa-mail-forward"></i> Share</button>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<div id="sharebutton"  class="addthis_inline_share_toolbox"></div>
<?php }?>
</div>
</div>

<div class="interviewlst-detaials">
<p><?php echo $result->summary;?></p>
</div>

<div class="otherintervw-sliderblk">
<h4>OTHER INTERVIEWS</h4>
<div class="otherintervw-sliderblk-contain">
  <div class='row'>
    <div class='col-sm-12 col-md-12 col-md-12 col-lg-12'>
      <div class="carousel slide media-carousel" id="media">
        <div class="carousel-inner">
        <?php 
	  $i = 1;
	 // $query = $DB->get_records('local_scwinterviews');
	 //$startlimit='0';
	// $endlimit='4';
	  	//	$query = $DB->get_records_sql("SELECT * FROM {local_scwinterviews} WHERE interview_delete ='0' LIMIT $startlimit, $endlimit");

	 // print_r($query);
	// $query = $DB->get_recordset("SELECT * FROM {local_scwinterviews} WHERE interview_delete ='0'");
	// foreach ($query as $record) {
    // Do whatever you want with this record
	//print_r($record);
//}
//$query->close();
	//$arr= array(); 
$query = $DB->get_records_sql("SELECT * FROM {local_scwinterviews} WHERE interview_delete ='0'");
//print_r($query);
//exit;
$arr1 = array_chunk($query,4);
//print_r($arr1);
//exit;

foreach($arr1 as $key=> $val){
 $item_class= ($i==1)?'item active':'item';
	  ?>
     	 <div class="<?php echo $item_class; ?>">
             <div class="row">
				<?php foreach($val as $newarr){?>
					<div class="col-lg-3">
              		<div class="otherintervw-innerslidr">
             		<h6><?php echo substr($newarr->interview_heading,0,40);?></h6>
             		<img src="<?php echo $turl; ?>/professionimg1.png" />
              		<?php $description = strip_tags($newarr->summary);?>
              		<p><?php echo substr($description, 0, 110);?></p>
              		</div>               
              		</div>
		
          		<?php }?>
				</div>
				
				</div> 
<?php
$i++; }?>


            
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
$( "#share" ).click(function() {
	$("#sharebutton").show();
});
  $('#media').carousel({
    pause: true,
    interval: false,
  });
});
</script>