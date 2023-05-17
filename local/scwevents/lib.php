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

function local_scwevents_pluginfile($course, $cm, $context, $filearea, $args,
                               $forcedownload, array $options=array()) {
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_scwevents', $filearea, $args[0], '/', $args[1]);
    send_stored_file($file);
}

function local_scwevents_get_img($vid){
    global $CFG;
    $systemcontext = context_system::instance();
    $fs = get_file_storage();

    $files = $fs->get_area_files($systemcontext->id, 'local_scwevents', 'event_description', $vid,'filename',false);
	
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