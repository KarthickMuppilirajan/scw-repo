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
 * @package    local_scwnewsletter
 * @copyright  Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require('lib.php');

class local_scwnewsletter_renderer extends plugin_renderer_base {

    public function subscribers_list() {
		global $OUTPUT,$PAGE,$DB,$USER,$CFG;
        $page = optional_param('page','0',PARAM_INT);
		$searchtext = optional_param('searchtext','',PARAM_TEXT);
		$sort = optional_param('sort', 'fid', PARAM_TEXT);
        $dir = optional_param('dir', 'DESC', PARAM_ALPHA);
		
		$action_url = new moodle_url("/local/scwnewsletter/action.php");
		
		$params = array();
		if(!empty($searchtext)){
            $params["searchtext"] = $searchtext;
		}
		$baseurl =  new moodle_url('/local/scwnewsletter/subscribers.php', $params);
        $seg = $page;
        $perpage = '10';
		
		$offset  = $seg*$perpage;
		$syscontext = context_system::instance();
		
		$output = '';
		$table = new html_table();
		$table->head = array ();
        $table->colclasses = array();
		
		$columns = array("#"=>"#","id" => "id", "subscriber_name" => "subscriber_name", "subscriber_email" => "subscriber_email","status" => "status","action" => "action",'delete'=>"delete");
		
		$hstr = array("#"=>"#","id" => "ID", "subscriber_name" => "Name", "subscriber_email" => "Email","status" => "Status","action" => "Action",'delete'=>'Delete');
		

		foreach($columns as $column){
			
			if ($sort != $column) {
				$columnicon = "";
				$columndir = "ASC";
			}else{
				$columndir = $dir == "ASC" ? "DESC":"ASC";
				$columnicon = ($dir == "ASC") ? "sort_asc" : "sort_desc";
				$columnicon = "<img class='iconsort' src=\"" . $OUTPUT->pix_url('t/' . $columnicon) . "\" alt=\"\" />";
			}
			
			
			//$table->head[] = $hstr[$column];

				$surl = new moodle_url('/local/scwnewsletter/subscribers.php',array("sort" => $column, "dir" => $columndir, "searchtext" => $searchtext));
				$surl = $surl->__toString();
				if($hstr[$column]=="#" || $hstr[$column]=="User type" || $hstr[$column]=="Action" || $hstr[$column]=="Delete" ){
					$table->head[] = $hstr[$column];
				}else{
					$table->head[] = "<a href=\"$surl\">".$hstr[$column]."</a>$columnicon";
				}
		}
		$table->attributes['class'] = 'admintable generaltable';
		
		
		if(!empty($searchtext)){
			$whr = "WHERE `subscriber_name` LIKE '%$searchtext%' "; //is put into the where clause
		}else{
			$whr = ""; //is put into the where clause
		}
		
		if ($sort == "fid") {
          $sort = 'id';
        }
		
		$orderstr = ($sort=="id")? "ORDER BY timecreated $dir" : 'ORDER BY '.$sort.' '.$dir;
		
		
		$qry = "SELECT * FROM {local_scwnewsletter_users} $whr  $orderstr LIMIT $offset,$perpage";
		

		$result = $DB->get_records_sql($qry);
		
		
        foreach ($result as $crow) {
			$offset++;
            $row = array();
			$row[] = $offset;
			$row[] = $crow->id;
			$row[] = ucfirst($crow->subscriber_name);
			$row[] = ucfirst($crow->subscriber_email);

			if($crow->status==1){
				$row[] = '<a class="btn btn-sm btn-success">Active</a>';
			}else{
				$row[] = '<a class="btn btn-sm btn-danger">Unsubscribed</a>';
			}
			
			if($crow->status==1){
				$row[] = '<form name="unsubscribe-form" class="form-inline" method="post" action="'.$action_url.'">
				<input type="hidden"  name="subscriber_id" value="'.$crow->id.'">
				<input type="hidden" name="action" value="unsubscribe">
				<button type="submit" class="btn btn-sm btn-primary "><i class="fa fa-pencil-square" aria-hidden="true"></i> Unsubscribe</button>
				</form>';
			}else{
				$row[] = '<form name="unsubscribe-form" class="form-inline" method="post" action="'.$action_url.'">
				<input type="hidden"  name="subscriber_id" value="'.$crow->id.'">
				<input type="hidden" name="action" value="subscribe">
				<button type="submit" class="btn btn-sm btn-success "><i class="fa fa-pencil-square" aria-hidden="true"></i> Subscribe</button>
				</form>';	
				
			}
			$row[]= '<a class="btn btn-sm btn-danger delete-subc" data-id="'.$crow->id.'" ><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';

            $table->data[] = $row;
        }
		
		$totalcount = $DB->count_records_sql("SELECT COUNT('id') FROM {local_scwnewsletter_users}  $whr");
		
		$params["sort"] = $sort;
		$params["dir"] = $dir;
		$baseurl =  new moodle_url('/local/scwnewsletter/subscribers.php', $params);
		
		$paging = $OUTPUT->paging_bar($totalcount , $page , $perpage, $baseurl);
		if($totalcount>0){
            $output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
            $output .= html_writer::table($table);
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class'=>'pagination'));
            $output .= $paging;
            $output .= html_writer::end_tag('div');	
		}else{
			$output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
			$output .= '<br/><p><strong>No records Found</strong></p>';	
			$output .= html_writer::end_tag('div');	
		}

		return $output;
	}


    public function scwnewsletter_list() {
		global $OUTPUT,$PAGE,$DB,$USER,$CFG;
        $page = optional_param('page','0',PARAM_INT);
		$search_title = optional_param('search_title','',PARAM_TEXT);
		$sort = optional_param('sort', 'fid', PARAM_TEXT);
        $dir = optional_param('dir', 'DESC', PARAM_ALPHA);
		
		$action_url = new moodle_url("/local/scwnewsletter/action.php");
		
		$params = array();
		if(!empty($search_title)){
            $params["search_title"] = $search_title;
		}
		$baseurl =  new moodle_url('/local/scwnewsletter/newsletters.php', $params);
        $seg = $page;
        $perpage = '10';
		
		$offset  = $seg*$perpage;
		$syscontext = context_system::instance();
		
		$output = '';
		$table = new html_table();
		$table->head = array ();
        $table->colclasses = array();
		
		$columns = array("#"=>"#","id" => "id", "title" => "title", "date" => "timecreated","user_id" =>"user_id","action" => "action");
		
		$hstr = array("#"=>"#","id" => "ID", "title" => "Title", "timecreated" => "Date","user_id" =>"Created By","action" => "Action");
		
				foreach($columns as $column){
			
			if ($sort != $column) {
				$columnicon = "";
				$columndir = "ASC";
			}else{
				$columndir = $dir == "ASC" ? "DESC":"ASC";
				$columnicon = ($dir == "ASC") ? "sort_asc" : "sort_desc";
				$columnicon = "<img class='iconsort' src=\"" . $OUTPUT->pix_url('t/' . $columnicon) . "\" alt=\"\" />";
			}
			
			
			//$table->head[] = $hstr[$column];

				$surl = new moodle_url('/local/scwnewsletter/newsletters.php',array("sort" => $column, "dir" => $columndir, "searchtext" => $search_title));
				$surl = $surl->__toString();
				if($hstr[$column]=="#" || $hstr[$column]=="Action" ){
					$table->head[] = $hstr[$column];
				}else{
					$table->head[] = "<a href=\"$surl\">".$hstr[$column]."</a>$columnicon";
				}
		}
		$table->attributes['class'] = 'admintable generaltable';
		

		
		
		if(!empty($search_title)){
			$whr = "WHERE `title` LIKE '%$search_title%' "; //is put into the where clause
		}else{
			$whr = ""; //is put into the where clause
		}
		
		if ($sort == "fid") {
          $sort = 'id';
        }
		
		$orderstr = ($sort=="id")? "ORDER BY timecreated $dir" : 'ORDER BY '.$sort.' '.$dir;
		
		
		$qry = "SELECT * FROM {local_scwnewsletter_messages} $whr $orderstr LIMIT $offset,$perpage";
		

		$result = $DB->get_records_sql($qry);
		
        foreach ($result as $crow) {
			$offset ++;
			$user = scwnewsletter_get_user($crow->user_id);
			//$message=scwnewsletter_get_message($crow->id);
            $row = array();
			$row[] = $offset ;
			$row[] = $crow->id ;
			$row[] = ucfirst($crow->title);
			//$row[] = $message['message'];
			$row[] = date('m/d/Y', $crow->timecreated); 
			$row[] = $user->firstname." ".$user->lastname;
			$row[] = '<a class="btn btn-sm btn-success" href="view.php?id='.$crow->id.'">View</a>';

            $table->data[] = $row;
        }
		
		$totalcount = $DB->count_records_sql("SELECT COUNT('id') FROM {local_scwnewsletter_messages}  $whr");
		
		$params["sort"] = $sort;
		$params["dir"] = $dir;
		$baseurl =  new moodle_url('/local/scwnewsletter/newsletters.php', $params);
		
		$paging = $OUTPUT->paging_bar($totalcount , $page , $perpage, $baseurl);
		if($totalcount>0){
            $output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
            $output .= html_writer::table($table);
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class'=>'pagination'));
            $output .= $paging;
            $output .= html_writer::end_tag('div');	
		}else{
			$output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
			$output .= '<br/><p><strong>No records Found</strong></p>';	
			$output .= html_writer::end_tag('div');	
		}

		return $output;
	}
}