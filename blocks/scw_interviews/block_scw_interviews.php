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
 * Course list block.
 *
 * @package    block_scw_interviews
 * @copyright  2017 onwards Fourbends Dev Team  {@link http://www.fourbends.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_scw_interviews extends block_base {
    function init() {
        $this->title = '<i class="fa fa-users"></i> '.get_string('scw_interviews', 'block_scw_interviews');
    }

    public function get_content() {
		global $CFG,$DB;
		
		$result = $DB->get_records_sql("SELECT id, interview_heading, summary, interview_priority FROM {local_scwinterviews} WHERE interview_status = '1' AND interview_delete ='0' ORDER BY interview_priority ASC LIMIT 2");
		if(empty($result)){
			
			$url = $CFG->wwwroot.'/local/scwinterviews/index.php';
			}
		
		$html='';
		$cnt = 0;
	  	foreach($result as $row){ 
		$cnt++;
		$description = strip_tags($row->summary);
		$img_url = $CFG->wwwroot.'/theme/supplychainwire/pix/border.png';
		$url = $CFG->wwwroot.'/local/scwinterviews/index.php';
		$id = $row->id;		
	    $url2 = $CFG->wwwroot.'/local/scwinterviews/view.php?id='.$id.'';
   	  	$html .= '<div class="interview-blk-contnt">';
		$html .='<h5><a href="'.$url2.'" id="interviewlink'.$cnt.'">'.$row->interview_heading.'</a></h5>';
		$html .='<p>'.substr($description, 0, 150).'...</p>';
		$html .='</div>';
	  	$html .='<img class="img-responsive" src="'.$img_url.'">';
	  	}
	
		if ($this->content !== null) {
		  return $this->content;
		}
	 
		$this->content =  new stdClass;
		$img_url = $CFG->wwwroot.'/theme/supplychainwire/pix/border.png';
		$content = $html.'
 <a class="btn-viewmore pull-right" href="'.$url.'" id="interviewmorelink"><span><div class="dblrht-arrow"><i class="fa fa-angle-double-right"></i></div>View More</span></a>';
		
		$this->content->text   = $content;
		$this->content->footer = '';
		return $this->content;
   }	
}