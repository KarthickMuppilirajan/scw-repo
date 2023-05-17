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
 * @package local-mylinks
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_login(); 
global $PAGE;

$title = 'My Links';

$PAGE->requires->jquery();
$PAGE->requires->js('/local/mylinks/js/custom.js');

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/mylinks/index.php');
$PAGE->set_pagelayout('coursecategory');
$PAGE->set_title($title);
$renderer = $PAGE->get_renderer('local_mylinks');

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();

echo $renderer->connected_users();

echo $OUTPUT->footer();
?>