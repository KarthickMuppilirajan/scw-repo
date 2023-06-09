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
 * @package local-scwmail
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once('lib.php');
global $PAGE;
require_login(); 
$title = 'Mailbox';

$PAGE->requires->js('/local/scwmail/js/custom.js');
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwmail/view.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$userid = $USER->id;
$msg_id = required_param('msg_id', PARAM_RAW);

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();
?>

<?php
local_scwmail_update_unread_mail($userid,'inbox',$msg_id); 
echo local_scwmail_fetch_mail($userid,'inbox',$msg_id);
echo $OUTPUT->footer();
?>

