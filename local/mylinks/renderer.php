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
 * Renderers for outputting blog data
 *
 * @package    local_mylinks
 * @copyright  Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class local_mylinks_renderer extends plugin_renderer_base {

    public function list_users() {
		global $DB,$CFG,$OUTPUT,$USER; 
        $page = optional_param('page','0',PARAM_INT);
        $seg = $page;
        $per_page = '10';
		$userid = $USER->id;
		
		$offset  = $seg*$per_page;
		
		$output = '<div class="inner-container" style="margin-top:20px;">';
		
		$output .= '<div class="row"><div class="col-lg-12">';
		
		$sql="SELECT * FROM {user} WHERE id NOT IN(1,2,$userid) order by timecreated ASC LIMIT $per_page OFFSET $offset";
		$result = $DB->get_records_sql($sql);
        foreach ($result as $crow) {
            $row = array();
			
		     $connection_info= $this->get_connection_status($crow->id);
			 $connection_status = $connection_info->connection_status;
			 $connection_action = $connection_info->action;
			 $connected_id = $connection_info->connected_id;
			 
			 if($connection_status==1){
				 $button= '<button type="button" class="btn btn-danger disabled" data-userid="'.$crow->id.'" >Connected</button>';
			 }else if($connection_status=='0' && $connection_action=="sent"){
				 $button='<button type="button" class="btn btn-danger disabled" data-userid="'.$crow->id.'">Request sent</button>';
			 }else if($connection_status=='0' && $connection_action=="received"){
				 $button='<button type="button" class="btn btn-danger connect" data-connected_id="'.$connected_id.'" data-userid="'.$userid.'" data-action="confirm">Confirm</button>';
			 }else{
				 $button='<button type="button" class="btn btn-danger connect" data-userid="'.$crow->id.'" data-action="connect">Connect</button>';
			 }
			 
			 $output.='<div class="media">
				<a href="#" class="pull-left">        
				  '.$OUTPUT->user_picture($crow, array('size'=>64, 'alttext'=>false)).'
				</a>
					'.$button.'
				<div class="media-body">
				  <h3 class="media-heading"><strong><a href="#">'.ucfirst($crow->firstname).'</a></strong></h3>
				  <p class="small">'.$crow->description.'</p>
				</div>

			  </div> ';   
        }
		
		//$row = array ();
		//$table->data[] = $row;

		 $output .= html_writer::end_tag('div');
		  $output .= html_writer::end_tag('div');
		return $output;
	}
	
	 public function connected_users() {
		global $DB,$CFG,$OUTPUT,$USER;
        $page = optional_param('page','0',PARAM_INT);
        $seg = $page;
        $per_page = '10';
		$userid = $USER->id;
		
		$offset  = $seg*$per_page;
		
		$output = '<div class="inner-container" style="margin-top:20px;">';
		
		$output .= '<div class="row"><div class="col-lg-12">';
		
		$ctable = 'local_mylinks';
		//$sql=" SELECT u.*,ue.connection_status AS status,ue.action AS action,ue.id AS linkid FROM {user} u JOIN {local_mylinks} ue ON (u.id=ue.connected_id) WHERE user_id=$userid  order by ue.connection_status ASC LIMIT $per_page OFFSET $offset";
		$sql="SELECT  U.*,ML.* FROM {local_mylinks} ML JOIN {user} U ON (U.id=ML.connected_id) WHERE user_id=$userid order by connection_status ASC LIMIT $per_page OFFSET $offset";
		$result = $DB->get_records_sql($sql);
		if (count($result) > 0) {
			foreach ($result as $crow) {
				$row = array();
				if($crow->connection_status==1){
				 $button= '<button type="button" class="btn btn-danger disabled" data-userid="'.$crow->id.'" >Connected</button>';
				 }else if($crow->connection_status=='0' && $crow->action=="sent"){
					 $button='<button type="button" class="btn btn-danger disabled" data-userid="'.$crow->id.'">Request sent</button>';
				 }else if($crow->connection_status=='0' && $crow->action=="received"){
					 $button='<button type="button" class="btn btn-danger connect" data-connected_id="'.$crow->connected_id.'" data-userid="'.$crow->user_id.'" data-action="confirm">Confirm</button>';
				 }
				 $output.='<div class="media">
					<a href="#" class="pull-left">        
					  '.$OUTPUT->user_picture($crow, array('size'=>64, 'alttext'=>false)).'
					</a>
						'.$button.'
						
					<div class="media-body">
					  <h3 class="media-heading"><strong><a href="#">'.ucfirst($crow->firstname).''.ucfirst($crow->lastname).'</a></strong></h3>
					  <p class="small">'.$crow->description.'</p>
					</div>
	
				  </div> ';   
			}
		}else{
			$output.='<div class="alert alert-danger">
			  			<strong>You do not have any connection yet</strong>
					  </div>';
		}
		
		//$row = array ();
		//$table->data[] = $row;

		 $output .= html_writer::end_tag('div');
		  $output .= html_writer::end_tag('div');
		return $output;
	}
	
	public function get_connection_status($user_id){
		global $DB,$CFG,$OUTPUT,$USER;
		$userid = $USER->id;
		$ctable = 'local_mylinks';
		$result = $DB->get_record_sql("SELECT * from {local_mylinks} WHERE connected_id = $user_id AND user_id=$userid");
		if($result)
		return $result;
	}

}