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

class local_scwvideos_renderer extends plugin_renderer_base {

    public function video_list() {
		global $OUTPUT,$PAGE,$DB,$USER,$CFG;

        $page = optional_param('page','0',PARAM_INT);
		$searchtext = optional_param('searchtext','',PARAM_TEXT);
		$searchtext = trim($searchtext);
		$alpages = local_scwbanner_page_options();
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
		if (has_capability('local/scwvideos:editvideo', $syscontext)) {
			$table->head[] = '<input type="checkbox" name="chkall" id="chkall" value="1">'; // Checkbox field field
		    $table->head[] = ""; // Edit field
		}
		$columns = array("id" => "id", "video_heading" => "video_heading", "video_description" => "video_description",
		"video_porder" => "video_porder",
		"video_status" => "video_status",
		"video_modified_by" => "video_modified_by",
		"video_modified" => "video_modified"
		);
		
		$hstr = array("id" => "id", "video_heading" => "Heading", "video_description" => "Description",
		"video_porder" => "Priority",
		"video_status" => "Status",
		"video_modified_by" => "Modified by",
		"video_modified" => "Modified date"
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
		$surl = new moodle_url('/local/scwvideos/admin.php',array("sort" => $column, "dir" => $columndir, "searchtext" => $searchtext));
		$surl = $surl->__toString();
			if($hstr[$column]=="ID"){
			$table->head[] = $hstr[$column];
			}else{
			$table->head[] = "<a href=\"$surl\">".$hstr[$column]."</a>$columnicon";
			}

		}

		
		$ctable = 'local_scwvideos';
		$delval = 0;
		$sparams = array();
		$whr = ' video_delete = :vdl ';
		$sparams['vdl'] = '0';
		
		if(!empty($searchtext)){
			$pos1 = stripos("Enabled", $searchtext);
			$pos2 = stripos("Disabled", $searchtext);
			if($pos1 !== FALSE){
                $whr .= ' AND video_status = :status ';
				$sparams['status'] = '1';
			}else if($pos2 !== FALSE){
				$whr .= ' AND video_status = :status ';
				$sparams['status'] = '0';
			}else{
                $whr .= " AND ".$DB->sql_like('video_heading', ':vname', false);
                $sparams['vname']  = '%'.$searchtext.'%';
			}
			
		}
		if ($sort == "fid") {
          $sort = 'id';
        }
		
		$orderstr = ($sort=="video_modified_by")? "ORDER BY b.firstname $dir" : 'ORDER BY a.'.$sort.' '.$dir;

		$qry = "SELECT a.*,b.firstname FROM {local_scwvideos} a JOIN {user} b ON a.video_modified_by = b.id WHERE ";
//		$qry = "SELECT * FROM {local_scwvideos} WHERE ";
		//$sparams['delval'] = $delval;
		//$result = $DB->get_records($ctable, array(), 'id asc', '*', $offset, $perpage);

		$result = $DB->get_records_sql("$qry $whr $orderstr", $sparams, $offset, $perpage);
		
        foreach ($result as $crow) {
            $row = array();
			$edit_url = $CFG->wwwroot.'/local/scwvideos/edit.php?id='.$crow->id;
			if (has_capability('local/scwvideos:editvideo', $syscontext)) {
              $row[] = '<input type="checkbox" name="vid[]" class="vid" value="'.$crow->id.'">'; // Checkbox field field
			  $row[] = '<a href="'.$edit_url.'">Edit</a>';
			}
			$row[] = $crow->id;
			$row[] = ucfirst($crow->video_heading);
			$row[] = ucfirst($crow->video_description);
			$row[] = $crow->video_porder;
            $row[] = ($crow->video_status=="1") ? "Enabled" : "Disabled";
			$muser = core_user::get_user($crow->video_modified_by);
			$row[] = ucfirst($muser->firstname);
			$row[] = date("M d, Y", $crow->video_modified);
            $table->data[] = $row;
        }
		
		//$totalcount = $DB->count_records($ctable);
//		$totalcount = $DB->count_records_sql("SELECT COUNT('x') FROM {local_scwvideos} l WHERE $whr", $sparams);
        $totalcount = $DB->count_records_sql("SELECT COUNT('x') FROM {local_scwvideos} a JOIN {user} b ON a.video_modified_by = b.id WHERE $whr", $sparams);
		$params["sort"] = $sort;
		$params["dir"] = $dir;
		$baseurl =  new moodle_url('/local/scwvideos/admin.php', $params);

		
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
	
	
	public function video_front_list() {
		global $OUTPUT,$PAGE,$DB,$USER,$CFG;
        require_once($CFG->dirroot . '/local/scwvideos/lib.php');

        $page = optional_param('page','0',PARAM_INT);
		$searchtext = optional_param('searchtext','',PARAM_TEXT);
		$searchtext = trim($searchtext);
		$alpages = local_scwbanner_page_options();
		$params = array();
		if(!empty($searchtext)){
            $params["searchtext"] = $searchtext;
		}
		$baseurl =  new moodle_url('/local/scwvideos/index1.php', $params);
        $seg = $page;
        $perpage = '9';
		
		$offset  = $seg*$perpage;
		$syscontext = context_system::instance();
		
		$output = '';
		
		$ctable = 'local_scwvideos';
		
		$sparams = array();
		$whr = ' video_delete = :vdl ';
		$sparams['vdl'] = '0';
		
		if(!empty($searchtext)){
            $whr .= " AND ( ".$DB->sql_like('video_heading', ':vname', false)."  OR  ".$DB->sql_like('video_description', ':vdesc', false). " ) ";
            $sparams['vname']  = '%'.$searchtext.'%';
			$sparams['vdesc']  = '%'.$searchtext.'%';
		}
		
		$whr .= ' AND video_status = :status ';
		$sparams['status'] = '1';
		
		$qry = "SELECT * FROM {local_scwvideos} WHERE ";
		
		$result = $DB->get_records_sql("$qry $whr", $sparams, $offset, $perpage);
		$videos = array();
        foreach ($result as $crow) {
            $row = array();
			$videourl = $CFG->wwwroot.'/local/scwvideos/view.php?id='.$crow->id;
			
			$row['videoid'] = $crow->id;
			$row['videoheading'] = ucfirst($crow->video_heading);
			$vdesc = $crow->video_description;
			$vdesc = (strlen($vdesc) > 64) ? substr($vdesc,0,64).'...' : $vdesc;
			
			$row['videodescription'] = $vdesc;
			$row['videothumb'] = local_scwvideo_get_img($crow->id);
			$row['videourl'] = $videourl;
            $videos[] = $row;
        }
		
		//$totalcount = $DB->count_records($ctable);
		$totalcount = $DB->count_records_sql("SELECT COUNT('x') FROM {local_scwvideos} l WHERE $whr", $sparams);
		$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';
		$paging = $OUTPUT->paging_bar($totalcount , $page , $perpage, $baseurl);
		
		if($totalcount>0){
			$tparams = array("turl" => $turl, "paging" => $paging, "videos" => $videos, "availablevideo" => true);
			$videolist = $OUTPUT->render_from_template('local_scwvideos/videolist',$tparams);
		}else{
			$tparams = array("availablevideo" => false);
			$videolist = $OUTPUT->render_from_template('local_scwvideos/videolist',$tparams);
		}
        $output = $videolist;

		return $output;
	}
	

}