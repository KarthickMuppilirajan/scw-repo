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
require_login(); 
global $PAGE,$USER;

$user_id = optional_param('user_id','0',PARAM_INT);
$user = mylinks_get_user_profile($user_id);
if($user_id==""){
	$url = $CFG->wwwroot;
	redirect($url);
}
$title = $user->firstname." ".$user->lastname."'s Profile";

$PAGE->requires->js('/local/mylinks/js/custom.js');
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/mylinks/profile.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);


/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();


//print_r($user);
$prof = new stdClass;
$prof = mylinks_get_user($user->user_id);

?>

<div class="viewprof-blk">
  <h4><i class="fa fa-file-text"></i><?=$user->firstname.' '.$user->lastname ?>'s PROFILE</h4>
  <div class="viewprof-disp">
    <div class="row">
      <div class="col-lg-10">
      <?php if($user->firstname){?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">First Name:</label>
          <div class="col-sm-8 col-lg-10"> <span><?= $user->firstname; ?></span> </div>
        </div>
        <?php } if($user->middlename){ ?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">Middle Name:</label>
          <div class="col-sm-8 col-lg-10"> <span><?= $user->middlename; ?></span> </div>
        </div>
        <?php } if($user->lastname){?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">Last Name:</label>
          <div class="col-sm-8 col-lg-10"> <span><?= $user->lastname; ?></span> </div>
        </div>
        <?php } ?>
        
        <?php if($user->summary) { ?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">Summary:</label>
          <div class="col-sm-8 col-lg-10"> <span><?= $user->summary; ?></span> </div>
        </div>
        <?php } ?>
      </div>
      <div class="col-lg-2 disprofimg"> <div class="img-transparency"><?php echo $OUTPUT->user_picture($prof, array('size'=>134, 'alttext'=>false,'link'=>false)); ?> </div></div>
             
      
       
      <div class="col-lg-10">
       <?php echo local_scw_general_companyinfo($user->user_id); ?>
       
      <?php if($user->industry) { ?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">Industry:</label>
          <div class="col-sm-8 col-lg-10"> <span><?= implode(',', array_map('ucfirst', explode(',', $user->industry))); ?><?php if($user->industry=="other") echo ' - '.ucfirst($user->industry_others);?></span> </div>
        </div>
        <?php } if($user->functional_area) {?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">Functional Area:</label>
          <div class="col-sm-8 col-lg-10"> <span><?= implode(',', array_map('ucfirst', explode(',', $user->functional_area)));  ?><?php if($user->functional_area=="other") echo ' - '.ucfirst($user->functional_area_others);?></span> </div>
        </div>
        <?php } if($user->resume){ 
			$resume= mylinks_getresume_url($user->user_id); 
			if($resume) { ?>
				        <div class="form-group">
			<label for="" class="col-sm-4 col-lg-2 control-label">Resume:</label>				
			<div class="col-sm-8 col-lg-10"> <span><a href="<?= $resume ?>" download>Download Resume</a></span> </div>
			</div>
			<?php }
		}?>      
        
        <?php echo local_scw_general_educationinfo($user->user_id); ?>
        
        
         <?php if($user->awards_reg) { ?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">Awards:</label>
          <div class="col-sm-8 col-lg-10"> <span><?= $user->awards_reg; ?></span> </div>
        </div>
        <?php }?>
        <?php if($user->country) { ?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label"><?php echo get_string('countryofcitizen', 'local_scwgeneral').":"; ?></label>
          <div class="col-sm-8 col-lg-10"> <span><?= mylink_get_county($user->country); ?></span> </div>
        </div>
        <?php } ?>

        <?php if($user->city) { ?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">City:</label>
          <div class="col-sm-8 col-lg-10"> <span><?= $user->city; ?></span> </div>
        </div>
        <?php } ?>
<?php /*?>        <?php if($user->phone1) { ?>
        <div class="form-group">
          <label for="" class="col-sm-2 control-label">Phone :</label>
          <div class="col-sm-10"> <span><?= $user->phone1; ?></span> </div>
        </div>
        <?php } ?><?php */?>
        
        <?php if($user->web_url) { ?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">Blog:</label>
          <div class="col-sm-8 col-lg-10"> <span><a href="<?= $user->web_url; ?>" target="_blank"><?= $user->web_url; ?></a></span> </div>
        </div>
        <?php } ?>
         <?php if($user->linkedin_url) { ?>
        <div class="form-group">
          <label for="" class="col-sm-4 col-lg-2 control-label">Linkedin:</label>
          <div class="col-sm-8 col-lg-10"> <span><a href="<?= $user->linkedin_url; ?>" target="_blank"><?= $user->linkedin_url; ?></a></span> </div>
        </div>
        <?php } ?>
        
      </div>
      <div class="col-lg-12">
        <div class="viewusers-btns">
		<?php 
		$connection_info= get_connection_status($user->user_id);
		if(!empty($connection_info)){
		$connection_status = $connection_info->connection_status;
		$connection_notes = $connection_info->block_notes;

		if($connection_status==1){ ?> 
        <div class="btn-group">
        <form action="<?php echo $CFG->wwwroot;?>/local/mylinks/delink.php" name="delink_form" id="delink_form">
          <input type="hidden" name="action" value="delink" />
		  <input type="hidden" name="connected_id" value="<?=$user->user_id;?>" />
         	 <button class="btn btn-ash">De-Link</button>
          </form>
          </div>
          <a href="<?php echo $CFG->wwwroot.'/local/scwmail/compose.php?user_id='.$user->user_id ?>"><button class="btn btn-ashblk">Mail</button></a>
          <button class="btn btn-brown" data-toggle="modal" data-target="#block_user">Block User</button>
          <?php }   else if($connection_status=='0' && $connection_info->action=="sent"){
					 echo '<button type="button" class="btn btn-sm btn-ashblk disabled" data-userid="'.$USER->id.'">'.get_string('requestsent','local_mylinks').'</button>';
				 }else if($connection_status=='0' && $connection_info->action=="received"){
					 echo '<button type="button" class="btn btn-sm btn-success connect" data-connected_id="'.$USER->id.'" data-userid="'.$user->user_id.'" data-action="confirm">'.get_string('confirm','local_mylinks').'		</button>';
				 }else if($connection_status==2 && $connection_notes!=""){
					 echo '<form action="'.$CFG->wwwroot.'//local/mylinks/delink.php" name="unblock_form" id="unblock_form">
					 	 <input type="hidden" name="action" value="unblock" />
						 <input type="hidden" name="connected_id" value="'.$user->user_id.'" />
					 	<button type="submit" class="btn btn-sm btn-ashblk ">'.get_string('unblock','local_mylinks').'</button>
					 </form>';
				 }
		}
		//else connect button
				 else{
					 $cond = (local_scwgeneral_check_scwsales() || local_scwgeneral_check_scwadmin());
					 if($cond) {
					 $disabled='disabled="true"';
					 }else{
						 $disabled="";
					 }
					 if($user->user_id!=$USER->id)
					 echo '<button type="button" class="btn btn-sm btn-ashblk pull-right connect" data-userid="'.$user->user_id.'" data-action="connect" '.$disabled.'>Connect</button>';
				 }
				 ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
echo $OUTPUT->footer();
?>
  <!-- Modal -->
  <div class="modal fade" id="block_user" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form action="<?php echo $CFG->wwwroot;?>/local/mylinks/delink.php" id="block_user_form" name="block_user_form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Block User</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
          <label for="usr">Notes:</label>
          <textarea name="block_notes" class="form-control" id="block_notes" maxlength="100"></textarea>
        </div>
        </div>
        <div class="modal-footer">
        <input type="hidden" name="action" value="block" />
        <input type="hidden" name="connected_id" value="<?=$user->user_id;?>" />
         <button type="submit" class="btn btn-brown" >Block</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      </form>
    </div>
  </div>


