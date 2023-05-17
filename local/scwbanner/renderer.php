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

class local_scwbanner_renderer extends plugin_renderer_base {

    public function banner_list() {
		global $OUTPUT,$PAGE,$DB,$USER,$CFG;

        $page = optional_param('page','0',PARAM_INT);
		$searchtext = optional_param('searchtext','',PARAM_TEXT);
		$searchtext = trim($searchtext);
        $sort = optional_param('sort', 'fid', PARAM_TEXT);
        $dir = optional_param('dir', 'ASC', PARAM_ALPHA);
		$alpages = local_scwbanner_page_options();
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
		if (has_capability('local/scwbanner:editbanner', $syscontext)) {
			$table->head[] = '<input type="checkbox" name="chkall" id="chkall" value="1">'; // Checkbox field field
		    $table->head[] = ""; // Edit field
		}
		
		$columns = array("id" => "id", "banner_name" => "banner_name", "banner_contact" => "banner_contact",
		"banner_expires_by" =>"banner_expires_by",
		"banner_page" => "banner_page",
		"banner_position" => "banner_position",
		"banner_porder" => "banner_porder",
		"banner_url" => "banner_url",
		"banner_status" => "banner_status",
		"banner_modified_by" => "banner_modified_by",
		"banner_modified" => "banner_modified"
		);
		
		$hstr = array("id" => "ID", "banner_name" => "Banner name", "banner_contact" => "Contact",
		"banner_expires_by" => "Expires By",
		"banner_page" => "WebPage",
		"banner_position" => "Location",
		"banner_porder" => "Preference Order",
		"banner_url" => "URL",
		"banner_status" => "Status",
        "banner_modified_by" => "Modified By",
		"banner_modified" => "Modified Date"
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
			$surl = new moodle_url('/local/scwbanner/admin.php',array("sort" => $column, "dir" => $columndir, "searchtext" => $searchtext));
			$surl = $surl->__toString();
			$table->head[] = "<a href=\"$surl\">".$hstr[$column]."</a>$columnicon";
		}
		
        $table->attributes['class'] = 'admintable generaltable';
		/* $table->head[] = "ID";
        $table->head[] = "Banner name";
		$table->head[] = "Contact";
		$table->head[] = "Expires By";
		$table->head[] = "WebPage";
		$table->head[] = "Location";
		$table->head[] = "Preference Order";
		$table->head[] = "URL";
		$table->head[] = "Status";
		$table->head[] = "Modified By";
		$table->head[] = "Modified Date"; */
		
		$ctable = 'local_scwbanner';
		$delval = 0;
		$sparams = array();
		$whr = ' banner_delete = :bdl ';
		$sparams['bdl'] = '0';
		
		if(!empty($searchtext)){
			$pos1 = stripos("Enabled", $searchtext);
			$pos2 = stripos("Disabled", $searchtext);
			if($pos1 !== FALSE){
                $whr .= ' AND a.banner_status = :status ';
				$sparams['status'] = '1';
			}else if($pos2 !== FALSE){
				$whr .= ' AND a.banner_status = :status ';
				$sparams['status'] = '0';
			}else{
                $whr .= " AND ".$DB->sql_like('a.banner_name', ':bname', false);
                $sparams['bname']  = '%'.$searchtext.'%';
			}
			
		}
		
		if ($sort == "fid") {
          $sort = 'id';
        }
		
		$orderstr = ($sort=="banner_modified_by")? "ORDER BY b.firstname $dir" : 'ORDER BY a.'.$sort.' '.$dir;
		
		
		$qry = "SELECT a.*,b.firstname FROM {local_scwbanner} a JOIN {user} b ON a.banner_modified_by = b.id WHERE ";
		//$sparams['delval'] = $delval;
		//$result = $DB->get_records($ctable, array(), 'id asc', '*', $offset, $perpage);
		
		$result = $DB->get_records_sql("$qry $whr $orderstr", $sparams, $offset, $perpage);
		
        foreach ($result as $crow) {
            $row = array();
			$edit_url = $CFG->wwwroot.'/local/scwbanner/edit.php?id='.$crow->id;
			if (has_capability('local/scwbanner:editbanner', $syscontext)) {
              $row[] = '<input type="checkbox" name="bid[]" class="bid" value="'.$crow->id.'">'; // Checkbox field field
			  $row[] = '<a href="'.$edit_url.'">Edit</a>';
			}
			$row[] = $crow->id;
			$row[] = ucfirst($crow->banner_name);
			$row[] = ucfirst($crow->banner_contact);
			$expires_by = date("d-M-Y", $crow->banner_expires_by);
            $row[] = $expires_by;
			$bpage = $crow->banner_page;
			$row[] = isset($alpages[$bpage]) ? $alpages[$bpage] : '-';
			$bpositions = local_scwbanner_positions();
            $bpos = $crow->banner_position;
			$row[] = isset($bpositions[$bpos]) ? $bpositions[$bpos] : '-';
			$row[] = $crow->banner_porder;
			$blink = $crow->banner_url;
			$blink = empty($blink)? '-' : '<a href="'.$blink.'">'.$blink.'</a>';
			$row[] = $blink;
			$row[] = ($crow->banner_status=="1") ? "Enabled" : "Disabled";
			//$muser = core_user::get_user($crow->banner_modified_by);
			$row[] = ucfirst($crow->firstname);
			$row[] = date("M d, Y", $crow->banner_modified);
            $table->data[] = $row;
        }
		
        $totalcount = $DB->count_records_sql("SELECT COUNT('x') FROM {local_scwbanner} a JOIN {user} b ON a.banner_modified_by = b.id WHERE $whr", $sparams);
		
		$params["sort"] = $sort;
		$params["dir"] = $dir;
		$baseurl =  new moodle_url('/local/scwbanner/admin.php', $params);
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