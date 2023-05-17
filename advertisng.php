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

$title = 'Advertising';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/advertisng.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';


echo $OUTPUT->header();
?>

<div class="aboutus-blk">
  <h4><i class="fa fa-users"></i>Advertising</h4>
  <div class="aboutus-detaials">
  <p> Advertise with Supply Chain Wire and make your goods and services know across the logistics, supply chain and transportation industry in the UK and worldwide. Supply Chain Wire offers Banner Advertising , sponsored content services on a first come-first served basis to our members, and/or any companies or organizations involved in the Logistics, Supply Chain and Transportation Industry globally.
To find out about our Advertising Options, Please write to us at advertising@supplychainwire.com and we will contact you
. </p>
  </div>
</div>
<?php
echo $OUTPUT->footer();

