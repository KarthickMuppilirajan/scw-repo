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

require("config.php");
global $PAGE,$USER;

$title = 'Memberships';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/memberships.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';


echo $OUTPUT->header();
?>

<div class="aboutus-blk">
  <h4><i class="fa fa-users"></i>Memberships</h4>
  <div class="aboutus-detaials">
  <p> Supply Chain Wire offers Memberships to Recent graduates who have completed a course/degree in Logistics, Supply Chain and Transportation. To learn more on how to become a member on Supply Chain Wire and how it can benefit you, please write to us at memberships@supplychainwire.com and we will contact you. </p>
  </div>
</div>
<?php
echo $OUTPUT->footer();

