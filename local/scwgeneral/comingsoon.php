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
global $PAGE,$USER;

$title = 'Subscription';
$addurl = new moodle_url("/local/scwbanner/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwbanner/admin.php");
$actionurl = new moodle_url("/local/scwbanner/banner_action.php");
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwbanner/admin.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
?>

<div class="comingsoon-blk">
<h4><i class="fa fa-book"></i>BOOK STORE</h4>
<div class="cmngsoonmsg-circ">
<div class="cmngsoonmsg-disp">
<img src="<?php echo $turl; ?>/logo.png">
<h2>COMING SOON</h2>
</div>

</div>

</div>

<?php
echo $OUTPUT->footer();