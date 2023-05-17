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
 * @package local-scwvideos
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');
global $PAGE,$USER;

$title = 'Video List page | Supplychainwire.com';
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$searchtext = optional_param('searchtext','',PARAM_TEXT);
$searchtext = trim($searchtext);

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwvideos/index.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';
$renderer = $PAGE->get_renderer('local_scwvideos');

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
?>

<div class="eventlstsearch-blk">
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-3">
<h4><i class="fa fa-search"></i>VIDEO LIST</h4>
  </div>

 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
<div class="interviewsearch-fileld">
<form class="form-inline" action="" name="search" id="search" method="get">
<div class="form-group"> <label for="exampleInputName2">Video name</label> 
<input type="text" value="<?php echo $searchtext; ?>" name='searchtext' id="search" >
</div> 
<button class="btn btn-brown" type = "submit">SEARCH</button> 
</form>
</div>
  </div>

  </div>  

</div>

<?php echo $renderer->video_front_list(); ?>

<?php
echo $OUTPUT->footer();
?>