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

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');

global $USER;
require_login();

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$events = new stdClass;
$events->id=null;
$pagedesc = 'Add Events';
$site = get_site();
$fullname = $site->fullname;
$syscontext = context_system::instance();
$PAGE->set_pagelayout('admin');
$PAGE->set_context($syscontext);
$PAGE->set_url('/local/scwevents/preview.php');

$descriptionoptions = array('maxfiles' => 5, 'maxbytes' => $CFG->maxbytes, 'trusttext' => true, 'context' => $syscontext,
    'subdirs' => file_area_contains_subdirs($syscontext, 'local_scwevents', 'event_description', $events->id));
	
$events = file_prepare_standard_editor($events, 'event_description', $descriptionoptions, $syscontext, 'local_scwevents', 'event_description', $events->id);


echo '<pre>';
 print_r($_POST);
 echo '</pre>';



$OUTPUT->header();
$OUTPUT->heading($pagedesc);


$editform->display();

$OUTPUT->footer();
?>