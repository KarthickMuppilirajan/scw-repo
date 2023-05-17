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
global $PAGE;

$title = 'SupplyChainWire - Banner List';
$addurl = new moodle_url("/local/scwbanner/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwbanner/index.php");
$actionurl = new moodle_url("/local/scwbanner/banner_action.php");

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwbanner/index.php');
$PAGE->set_pagelayout('coursecategory');
$PAGE->set_title($title);
$renderer = $PAGE->get_renderer('local_scwbanner');

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();

?>
<h3><?php echo $title; ?></h3>
<hr/>
<div class='form-inline row'>
  <div class='form-group col-sm-3'>
    <form class="form-inline" action="<?php echo $actionurl; ?>" method="post">
    <select class='form-control' name="banner_action">
	   <option value="activate">Select</option>
       <option value="activate">Activate</option>
	   <option value="deactivate">Deactivate</option>
    </select>
	<input type="submit" name="apply" value="Apply" class="form-control">
	</form>
  </div>
  
  <div class='form-group col-sm-2'>
    <form class="form-inline" name="frmaddbanner" action="<?php echo $addurl; ?>" method="post">
	<input type="submit" value="Add Banner" name="add_new" class="form-control">
	</form>
  </div>
	
    <div class='form-group col-sm-7'>
	    <form class="form-inline" name="frmaddbanner" action="<?php echo $searchurl; ?>" method="get">
          <input type='text' placeholder='Type text' name='searchtext' class='form-control' />
		  <button type="submit" class="form-control">Search</button>
	    </form>	
    </div>
  
</div>

<?php
echo $renderer->banner_list();

echo $OUTPUT->footer();