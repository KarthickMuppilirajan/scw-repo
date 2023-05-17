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
 * @package    block_scw_events
 * @copyright  2017 onwards Fourbends Dev Team  {@link http://www.fourbends.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_scw_events extends block_base {
    function init() {
        $this->title =  '<i class="fa fa-calendar"></i> '.get_string('scw_events', 'block_scw_events');
    }

    public function get_content() {
		global $CFG, $OUTPUT, $DB;
		if ($this->content !== null) {
		  return $this->content;
		}
		
		$now = new DateTime("now", core_date::get_server_timezone_object());
		$time = $now->getTimestamp();	 
		$this->content =  new stdClass;
		$img_url = $CFG->wwwroot.'/theme/supplychainwire/pix/border.png';
		$view_more_url = $CFG->wwwroot.'/local/scwevents/index.php';
		$sql="SELECT * FROM {local_scwevents} WHERE event_delete =0 and event_status = '1' AND (event_startdate > $time or event_enddate > $time) ORDER BY event_startdate ASC LIMIT 0,2";
		$result = $DB->get_records_sql($sql);
		$cnt=0;
		$list='';
		foreach($result as $row)
		{
			$cnt++;
			$id=$row->id;
			$event_name=trim(substr($row->event_name,0,50));
			$event_description=strip_tags($row->event_description);
			$event_description=trim(substr($event_description,0,50));
			$event_date=date('d',$row->event_startdate);
			$event_month=date('M',$row->event_startdate);
			$event_time=date('h.i a',$row->event_startdate).' UTC';
			$url=$CFG->wwwroot.'/local/scwevents/view.php?id='.$id;
			
			$list.='<div class="date-monthblk">
			<div class="row">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-5">
			<div class="calendar-blk">
			<span class="date-disp"><strong>'.$event_date.'</strong></span><br>
			<span class="month-disp"><strong>'.$event_month.'</strong></span>
			</div>
			</div>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-7 padlft-non">
			<div class="calendar-blk-contnt">
			<h5><a href="'.$url.'" id="eventlink1">'.$event_name.'</a></h5>
			<span><strong>'.$event_time.'</strong></span>
			<p>'.$event_description.'</p>
			</div>
			</div>
			</div>
			</div>';
			if($cnt<2)
			$list.='<img class="img-responsive" src="'.$img_url.'">';					
		}
	
		$content = $OUTPUT->render_from_template('block_scw_events/home_events',array("img_url" => $img_url,"list" => $list,"view_more_url" => $view_more_url));
	
		$this->content->text   = $content;
		$this->content->footer = '';
		return $this->content;
   }
	
}


