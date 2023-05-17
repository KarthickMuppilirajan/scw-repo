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
 * @package local-myliks
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once($CFG->dirroot.'/local/scwgeneral/lib.php');
require_once('lib.php');
global $PAGE;

$title = 'Search';

$PAGE->requires->js('/local/mylinks/js/custom.js');
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/mylinks/search.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';
$baseurl = $CFG->wwwroot.'/local/mylinks/search.php';

$paging_url = $baseurl."?".$_SERVER['QUERY_STRING'];

$profession = optional_param('profession', 0, PARAM_INT);
$country = optional_param('country', 0, PARAM_TEXT);
$industry = optional_param('industry', 0, PARAM_TEXT);
$farea = optional_param('farea', 0, PARAM_TEXT);


$login_url=new moodle_url('/login/index.php');
$userid = $USER->id;

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();

$pagination_setting=get_config('local_scwgeneral', 'searchpaging');
$page = optional_param('page','0',PARAM_INT);
$seg = $page;
if($pagination_setting){
	$per_page = $pagination_setting;
}else{
	$per_page = 10;
}
$offset  = $seg*$per_page;
$total_count = mylinks_search_user_count($profession,$country,$industry,$farea);
$users = mylinks_search_user($profession,$country,$industry,$farea,$per_page,$offset);
?>

<div class="search-blk">
  <h4><i class="fa fa-search"></i>SEARCH</h4>
  <div class="search-blk-fields">
    <form action="<?php echo $CFG->wwwroot;?>/local/mylinks/search.php" name="search_form" id="search_form">
      <div class="form-group col-lg-2" id="profession-gp">
        <label for="searchprof">Search Profession</label>
        <select class="form-control" name="profession" id="profession" required>
          <option value="">--Select Profession--</option>
          <option value="1" <?php if($profession==1){?> selected="selected" <?php }?>>Professional</option>
          <option value="2" <?php if($profession==2){?> selected="selected" <?php }?>>Recent Graduates</option>
        </select>
      </div>
     
      <div class="form-group col-lg-2" id="country-gp">
        <label for="searchprof">Search By Country</label>
        <?php echo local_scwgeneral_get_countries(2,'country',$country); ?> </div>
        
      <div class="form-group col-lg-2" id="industry-gp" <?php if($profession==2){ ?> style="display:none" <?php } ?>>
        <label for="searchprof">Search By Industry</label>
        <?php echo local_scwgeneral_get_industry(2,'industry',$industry); ?> </div>
      <div class="form-group col-lg-3" id="functionalarea-gp" <?php if($profession==2){ ?> style="display:none" <?php } ?>>
        <label for="searchprof">Search By Functional Area</label>
        <?php echo local_scwgeneral_get_farea(2,'farea',$farea); ?> </div>
      <div class="pull-right searchrst-btns">
        <button class="btn btn-brown" type="submit">SEARCH</button>
        <button class="btn btn-ash" type="button" name="reset" id="reset">RESET</button>
      </div>
    </form>
  </div>
</div>
<div class="search-result-blk">
  <h4><i class="fa fa-star"></i>SEARCH RESULTS</h4>
  <div class="searhvalue-contnt">
    <div class="row">
      <div class="col-lg-12 padrht-non-prof">
        <div class="searcharea-lst">
        <ul>
        <?php 
		if(count($users)>0){
			foreach($users as $user){
			 $cuid = $user->user_id;	
			if (!isloggedin()) {
				$button='<a href="'.$login_url.'"><button class="btn btn-sm btn-ashblk pull-right">Connect</button></a>';
			} else {
			 
			 $connection_info= get_connection_status($user->user_id);
			 if(!empty($connection_info)){
				 $connection_status = $connection_info->connection_status;
				 $connection_action = $connection_info->action;
				 $connected_id = $connection_info->connected_id;
				 $block_notes = $connection_info->block_notes;
				 $cstr = 'connect-'.$cuid;
							
				 if($connection_status==1){
					 $button= '<button type="button" class="btn btn-ashblk disabled pull-right" data-userid="'.$user->user_id.'" id="'.$cstr.'">Connected</button>';
				 }else if($connection_status==2){
								  $button= '<a data-toggle="tooltip" title="'.$block_notes.'" class="btn btn-sm btn-ashblk">B</button></a>';
				 }else if($connection_status=='0' && $connection_action=="sent"){
					 $button='<button type="button" class="btn btn-sm btn-ashblk disabled pull-right" data-userid="'.$user->user_id.'" id="'.$cstr.'">Request sent</button>';
				 }else if($connection_status=='0' && $connection_action=="received"){
					 $button='<button type="button" class="btn btn-sm btn-success pull-right connect" id="'.$cstr.'" data-connected_id="'.$connected_id.'" data-userid="'.$userid.'" data-action="confirm">Confirm</button>';
				 }
			 }
			 else{
				 $cstr = 'connect-'.$cuid;
				 $cond = (local_scwgeneral_check_scwsales() || local_scwgeneral_check_scwadmin());
				 if($cond) {
					 $disabled='disabled="true"';
				 }else{
					 $disabled="";
				 }
				 $button='<button type="button" id="'.$cstr.'" class="btn btn-sm btn-ashblk pull-right connect" data-userid="'.$user->user_id.'" data-action="connect" '.$disabled.'>Connect</button>';
			 }
			 
			}	
			// creating std class for user to get profile picture
			$prof = new stdClass;
			$prof = mylinks_get_user($user->user_id);
			
			
		?>
        <li>
        <div class="searhvalue-contnt-details">
            <div class="row">
              <div class="col-sm-5 col-md-4 col-lg-3">
                <div class="img-transparency"> <?php echo $OUTPUT->user_picture($prof, array('size'=>134, 'alttext'=>false,'link'=>false)); ?> </div>
              </div>
              <div class="col-sm-7 col-md-8 col-lg-9">
                <div class="searhvalue-contnt-title">
                  <div class="row">
                    <div class="col-md-8 col-lg-6 padlft-non">
                    <?php 
						$name=ucfirst($user->firstname)." ".ucfirst($user->lastname);
						$name=substr($name,0,30);
					?>
                      <a href="<?php echo $CFG->wwwroot.'/local/mylinks/profile.php'?>?user_id=<?php echo $cuid; ?>" id="user-view-<?php echo $cuid; ?>"><h5><?php echo $name;?></h5></a>
					  <?php echo local_scwgeneral_mylinks_name($cuid, $profession) ?>
                    </div>
                    <div class="col-md-6 col-lg-6">
                    <div class="btn-group">
                        <?php  if($user->user_id!=$USER->id) echo $button; ?>
                        </div>
                      <div class="btn-group">
                         <a href="<?php echo $CFG->wwwroot.'/local/mylinks/profile.php'?>?user_id=<?php echo $cuid; ?>" id="user-view-<?php echo $cuid; ?>">
						 <button data-toggle="tooltip" title="View More" class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
						 </a>
                      </div>
                    </div>
                  </div>
                  <img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png"> </div>
              </div>
              <p><?php echo substr($user->summary, 0, 100); ?></p>
            </div>
          </div>
          <img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
        </li>
          <?php } } else {?> 
          <div class="row">
          <div class="col-md-12 text-center">
          <div class="alert alert-danger">
              <strong>No search results found, please try again later</strong> 
            </div>
            </div>
            </div>
          <?php } ?>
   		</ul>
      </div>
    </div>
  </div>
  </div> 
  <?php 
 	echo html_writer::start_tag('div', array('class'=>'searchreslt-pagination'));
	echo $OUTPUT->paging_bar($total_count, $page, $per_page, $paging_url);
	echo html_writer::end_tag('div');
   ?>

</div>
<?php
echo $OUTPUT->footer();
?>
<script type="text/javascript">

require(['jquery','theme_bootstrap/bootstrap'], function( $ ) {
  $('[data-toggle="tooltip"]').tooltip({
    'placement': 'top',
    'container':'body'
  }); 
 });
 </script>