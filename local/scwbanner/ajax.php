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
 * Support local plugin.
 *
 * @package    local_mylinks
 * @copyright  2016 Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
define('AJAX_SCRIPT', true);

require_once('../../config.php');
require_login(); 
global $PAGE,$DB;

$PAGE->set_context(context_system::instance());
$priority = optional_param('priority', 0, PARAM_INT);
$banner_id = optional_param('banner_id', 0, PARAM_INT);
$banner_position = required_param('banner_position', PARAM_RAW);
$banner_page = required_param('banner_page', PARAM_RAW);

if ($priority) {
	$bannerarr = array('banner_delete' => '0' ,'banner_porder' => $priority,'banner_position' => $banner_position,'banner_page' => $banner_page,'banner_status' => '1');
	
	$banners = $DB->get_record('local_scwbanner', $bannerarr , '*', IGNORE_MULTIPLE); 
	
	$errors['count'] = count($banners);
	if($banners->id==$banner_id && count($banners)==1){
		$errors['status'] = get_string('success', 'local_scwbanner');
		echo json_encode($errors);
	}else if($banners->id){
		$errors['interview_priority'] = get_string('prioritytaken', 'local_scwbanner', $banners->banner_name);
		$errors['status'] = get_string('failed', 'local_scwbanner');
		echo json_encode($errors);
	}else{
		$errors['status'] = get_string('success', 'local_scwbanner');
		echo json_encode($errors);
	}
}
?>