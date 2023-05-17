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
 * @package local-scwbanner
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_scwbanner_pluginfile($course, $cm, $context, $filearea, $args,
                               $forcedownload, array $options=array()) {
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_scwbanner', $filearea, $args[0], '/', $args[1]);
    send_stored_file($file);
}

function local_scwbanner_page_options(){
    $pages = get_string('bannerpages_default', 'local_scwbanner');
    $apages = explode("\n", $pages);
    $poptions = array();
    foreach($apages as $apage){
        $apage = trim($apage);
        if(empty($apage)){
            continue;
        }

        $arpage = explode("|",$apage);
		list($pshort, $pname) = $arpage;
        $poptions[$pshort] = $pname;
	}
    return $poptions;
}

function local_scwbanner_get_banners(){
    global $USER, $CFG, $DB;
    static $abanner = array();
	if(empty($abanner)){
        $bannerrst = $DB->get_records('local_scwbanner', array('banner_status' => '1', 'banner_delete' => '0'), 'banner_porder asc', '*');

        foreach($bannerrst as $bannerrow){
			$exp = $bannerrow->banner_expires_by;
			$now = new DateTime("now", core_date::get_server_timezone_object());
            $time = $now->getTimestamp();
			if($exp <= $time){
				continue;
			}
            $bpage = $bannerrow->banner_page;
	        $bpos = $bannerrow->banner_position;
	        $img_url = banner_img_url($bannerrow->id);
		    $brurl = $bannerrow->banner_url;
			$brurl = !empty($brurl)? $brurl : 'javascript:void(0);';
		    $bcpn = $bannerrow->banner_caption;
	        if(!empty($img_url)){
                $abanner[$bpage][$bpos][] = array('imgurl' => $img_url, 'brurl' => $brurl, 'bcpn' => $bcpn);
            }
        }
    }
    return $abanner;
}


function banner_img_url($bid){
	global $CFG;
    $systemcontext = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($systemcontext->id, 'local_scwbanner', 'banner_image', $bid,'filename', false);
	$filestr = '';
    foreach ($files as $file) {
        $filename = $file->get_filename();
	
        $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(),
                    $file->get_component(), $file->get_filearea(),
                    $file->get_itemid(), $file->get_filepath(), $file->get_filename());
		$filestr = $fileurl->__toString();
		
    }
	return $filestr;
}

function local_scwbanner_positions(){
    $bpositions = array("top" => "Top", "bottom" => "Bottom",
                "left" => "Left", "right1" => "Right 1", "right2" => "Right 2",
                "right3" => "Right 3");
    return $bpositions;
}

function banner_validate_date($bannerexp) {
    $time = strtotime('today');

    // If both start and end dates are set end date should be later than the start date.
    if (!empty($bannerexp) && ($time > $bannerexp)) {
        return 'bannerexpiredatebefore';
    }
    return false;
}

function scw_banner_position_images(){
	global $CFG,$OUTPUT,$PAGE;
	
    $topimgurl = $OUTPUT->pix_url('default-imgs/top', 'theme')->__toString();
	$leftimgurl = $OUTPUT->pix_url('default-imgs/left', 'theme')->__toString();
	$right1imgurl = $OUTPUT->pix_url('default-imgs/right1', 'theme')->__toString();
	$right2imgurl = $OUTPUT->pix_url('default-imgs/right2', 'theme')->__toString();
	$right3imgurl = $OUTPUT->pix_url('default-imgs/right3', 'theme')->__toString();
	$bottomimgurl = $OUTPUT->pix_url('default-imgs/bottom', 'theme')->__toString();

    $bsizeimgarr = array("top" => $topimgurl,
        "left" => $leftimgurl,
        "right1" => $right1imgurl,
        "right2" => $right2imgurl,
        "right3" => $right3imgurl,
        "bottom" => $bottomimgurl
    );
    return $bsizeimgarr;
}