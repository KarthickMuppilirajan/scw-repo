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

$title = 'Courses & Qualifications';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/courses_qualifications.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';


echo $OUTPUT->header();
?>

<div class="aboutus-blk">
  <h4><i class="fa fa-users"></i>Courses & Qualifications</h4>
  <div class="aboutus-detaials">
  <p> List of Undergraduate, Post Graduate and Research degrees offered by Universities in UK & worldwide in the field of Logistics, Supply Chain, Purchasing and Transportation. For users of this section, please note that you are advised to check all relevant details and requirements with the University/college before you decide to seek admission. Information listed below should only be considered as a guide. </p>
  </div>
</div>
<?php
echo $OUTPUT->footer();

