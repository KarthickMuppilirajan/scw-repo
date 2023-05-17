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
 * @package local-scwvideos
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_scwvideos_pluginfile($course, $cm, $context, $filearea, $args,
                               $forcedownload, array $options=array()) {
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_scwvideos', $filearea, $args[0], '/', $args[1]);
    send_stored_file($file);
}

function local_scwvideo_get_url($vid,$video_content){
	global $CFG;
    $systemcontext = context_system::instance();
    $fs = get_file_storage();

    $files = $fs->get_area_files($systemcontext->id, 'local_scwvideos', 'video_content', $vid,'filename',false);
	
	$filestr = array();
    foreach ($files as $file) {
        $filename = $file->get_filename();
		/* $spos = stripos($video_content,$filename);
	    if($spos===false){
			continue;
		} */
			
        $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(),
                    $file->get_component(), $file->get_filearea(),
                    $file->get_itemid(), $file->get_filepath(), $file->get_filename());
		$filestr[] = array( "video" => $fileurl->__toString(), "videoname" => $filename );
		
    }
	$vfile = reset($filestr);
	return $vfile;
}


function local_scwvideo_get_img($vid){
    global $CFG;
    $systemcontext = context_system::instance();
    $fs = get_file_storage();

    $files = $fs->get_area_files($systemcontext->id, 'local_scwvideos', 'video_thumb', $vid,'filename',false);
	
	$filestr = array();
    foreach ($files as $file) {
        $filename = $file->get_filename();
			
        $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(),
                    $file->get_component(), $file->get_filearea(),
                    $file->get_itemid(), $file->get_filepath(), $file->get_filename());
		$filestr[] = $fileurl->__toString();
		
    }
	$vfile = reset($filestr);
	return $vfile;

}

function local_scwvideo_other_videos($cvid){
    global $OUTPUT,$CFG, $DB;
    $videos = $DB->get_records('local_scwvideos', array("video_delete" => "0", "video_status" => "1"),"video_porder asc");
    $pvideos = array();

	foreach($videos as $video){
        $vid = $video->id;
        if($cvid==$vid){
            continue;
        }
        $imgurl = local_scwvideo_get_img($vid);
		$videourl = new moodle_url("/local/scwvideos/view.php", array("id" => $vid));
		$pvideos[] = array("imgurl" => $imgurl, "videourl" => $videourl, "title" => $video->video_heading);
    }
    $svideos = array_chunk($pvideos,4);
	$fvideos = array();
	foreach($svideos as $k => $svideo){
        $clstxt = ($k=="0") ? "item active": "item";
        $fvideos[] = array("clstxt" => $clstxt, "videos" => $svideo);
	}
	$carousel = ( count($pvideos) > 4 )? true : false;
	$avvideos = ( count($pvideos) > 0 )? true : false;
	
    $params = array("fvideos" => $fvideos, "carousel" => $carousel, "avvideos" => $avvideos);
    $othervideos = $OUTPUT->render_from_template('local_scwvideos/othervideos', $params);
	return $othervideos;
}
