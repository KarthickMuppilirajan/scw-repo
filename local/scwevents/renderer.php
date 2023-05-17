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
 * @package    local_scwbanner
 * @copyright  Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class local_scwevents_renderer extends plugin_renderer_base {

    public function event_list() {
		global $OUTPUT,$PAGE,$DB,$USER,$CFG;
        $page = optional_param('page','0',PARAM_INT);
		$searchtext = optional_param('searchtext','',PARAM_TEXT);
		$searchtext = optional_param('searchtext','',PARAM_TEXT);
		$searchtext = trim($searchtext);
        $sort = optional_param('sort', 'fid', PARAM_TEXT);
        $dir = optional_param('dir', 'ASC', PARAM_ALPHA);
		$params = array();
		if(!empty($searchtext)){
            $params["searchtext"] = $searchtext;
		}

        $seg = $page;
        $perpage = '10';
		
		$offset  = $seg*$perpage;
		$syscontext = context_system::instance();
		
		$output = '';
		$table = new html_table();
		$table->head = array ();
        $table->colclasses = array();
		if (has_capability('local/scwevents:editevent', $syscontext)) {
			$table->head[] = '<input type="checkbox" name="chkall" id="chkall" value="1">'; // Checkbox field field
		    $table->head[] = ""; // Edit field
		}
		$columns = array("#" => "#", "id" => "id", "event_name" => "event_name", "event_country" => "event_country",
		"event_state" => "event_state",
		"event_city" => "event_city",
		"event_address" => "event_address",
		"event_start_date" =>"event_startdate",
		"event_end_date" => "event_enddate",
		"event_share" => "event_share",
		"event_status" => "event_status",
		"event_modified_by" => "event_modified_by",
		"event_modified" => "event_modified"
		);
		
		$hstr = array("#" => "#", "id" => "Id", "event_name" => "Event name", "event_country" => "Country",
		"event_state" => "State",
		"event_city" => "City",
		"event_address" => "Address",
		"event_startdate" =>"Start date",
		"event_enddate" => "End date",
		"event_share" => "Share",
		"event_status" => "Status",
		"event_modified_by" => "Modified by",
		"event_modified" => "Modified on"
		);
		
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
		$surl = new moodle_url('/local/scwevents/admin.php',array("sort" => $column, "dir" => $columndir, "searchtext" => $searchtext));
		$surl = $surl->__toString();
			if($hstr[$column]=="#" || $hstr[$column]=="State" || $hstr[$column]=="City" || $hstr[$column]=="Address" || $hstr[$column]=="End date" || $hstr[$column]=="Share"){
			$table->head[] = $hstr[$column];
			}else{
			$table->head[] = "<a href=\"$surl\">".$hstr[$column]."</a>$columnicon";
			}

		}
		
        $table->attributes['class'] = 'admintable generaltable';


		$ctable = 'local_scwevents';
		$delval = 0;
		$sparams = array();
		$whr = ' event_delete = :edl ';
		$sparams['edl'] = '0';
		
		if(!empty($searchtext)){
			$pos1 = stripos("Enabled", $searchtext);
			$pos2 = stripos("Disabled", $searchtext);
			if($pos1 !== FALSE){
                $whr .= ' AND event_status = :status ';
				$sparams['status'] = '1';
			}else if($pos2 !== FALSE){
				$whr .= ' AND event_status = :status ';
				$sparams['status'] = '0';
			}else{
                $whr .= " AND ".$DB->sql_like('event_name', ':ename', false);
                $sparams['ename']  = '%'.$searchtext.'%';
			}
			
		}
		
		if ($sort == "fid") {
          $sort = 'id';
        }
		
		$orderstr = ($sort=="event_modified_by")? "ORDER BY b.firstname $dir" : 'ORDER BY a.'.$sort.' '.$dir;
		
		$qry = "SELECT a.*,b.firstname FROM {local_scwevents} a JOIN {user} b ON a.event_modified_by = b.id WHERE ";
		//$sparams['delval'] = $delval;
		//$result = $DB->get_records($ctable, array(), 'id asc', '*', $offset, $perpage);
		

		
		$result = $DB->get_records_sql("$qry $whr $orderstr", $sparams, $offset, $perpage);

		
		$countries = local_scwgeneral_get_countries();
		$key=0;
        foreach ($result as $crow) {
			$key++;
            $row = array();
			$edit_url = $CFG->wwwroot.'/local/scwevents/edit.php?id='.$crow->id;
			if (has_capability('local/scwevents:editevent', $syscontext)) {
              $row[] = '<input type="checkbox" name="eid[]" class="eid" value="'.$crow->id.'">'; // Checkbox field field
			  $row[] = '<a id="event'.$crow->id.'" href="'.$edit_url.'">Edit</a>';
			}
			$row[] = $page*10+$key;
			$row[] = $crow->id;
			$row[] = ucfirst($crow->event_name);
			$row[] = ucfirst($countries[$crow->event_country]);
			$row[] = ucfirst($crow->event_state);
			$row[] = ucfirst($crow->event_city);
			$row[] = ucfirst($crow->event_address);
			$startdate = date("d-M-Y", $crow->event_startdate);
            $row[] = $startdate;
			$enddate = date("d-M-Y", $crow->event_enddate);
            $row[] = $enddate;
			$row[] = ($crow->event_share=="1") ? "Shared" : "Not shared";
			$row[] = ($crow->event_status=="1") ? "Enabled" : "Disabled";
			$muser = core_user::get_user($crow->event_modified_by); // get details by user id
			$row[] = ucfirst($muser->firstname);
			$row[] = date("M d, Y", $crow->event_modified);
            $table->data[] = $row;
        }
		
		//$totalcount = $DB->count_records($ctable);
        $totalcount = $DB->count_records_sql("SELECT COUNT('x') FROM {local_scwevents} a JOIN {user} b ON a.event_modified_by = b.id WHERE $whr", $sparams);
		$params["sort"] = $sort;
		$params["dir"] = $dir;
		$baseurl =  new moodle_url('/local/scwevents/admin.php', $params);

		
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