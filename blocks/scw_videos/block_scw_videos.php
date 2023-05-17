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
 * @package    block_scw_videos
 * @copyright  2017 onwards Fourbends Dev Team  {@link http://www.fourbends.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_scw_videos extends block_base {
    function init() {
        $this->title =  '<i class="fa fa-video-camera"></i> '.get_string('scw_videos', 'block_scw_videos');
    }

    public function get_content() {
		global $CFG, $OUTPUT, $DB;
		require_once($CFG->dirroot."/local/scwvideos/lib.php");
		if ($this->content !== null) {
		  return $this->content;
		}
	 
	    $videos = $DB->get_records('local_scwvideos', array("video_delete" => "0", "video_status" => "1"),"video_porder asc","*","0","1");
		$viewmore = new moodle_url("/local/scwvideos/index.php");
        $params = array("viewmore" => $viewmore);
		$this->content =  new stdClass;
		if(!empty($videos)){
            list($k,$video) = each($videos);
            $vid = $video->id;
            $imgurl = local_scwvideo_get_img($vid);
            $syscontext = context_system::instance();
			$voptions['context'] = $syscontext;
            $voptions['subdirs'] = file_area_contains_subdirs($syscontext, 'local_scwvideos', 'video_content', $video->id);
			$video_content = file_rewrite_pluginfile_urls($video->video_content, 'pluginfile.php', $syscontext->id, 'local_scwvideos', 'video_content', $video->id);
            $video_content = format_text($video_content, $video->video_contentformat, $voptions, $video->id);
            $video_content = str_replace("<video", "<video id=\"video_home\" oncontextmenu=\"return false;\" loop autoplay muted preload=\"auto\" ", $video_content);
            //$video_content = str_replace("<video", "<video poster=\"$imgurl\" ", $video_content);
            $params['videocontent'] = $video_content;
            $params["videourl"] = new moodle_url("/local/scwvideos/view.php", array("id" => $vid));
            $params['imgurl'] = $imgurl; 
            $params["video"] = true;
			$params["vid"] = $vid;
            $content = $OUTPUT->render_from_template('block_scw_videos/video', $params);
		} else {
			$params["video"] = false;
			$content = $OUTPUT->render_from_template('block_scw_videos/video', $params);
		}
		
		$this->content->text   = $content;
		$this->content->footer = '';
		return $this->content;
   }
	
}


