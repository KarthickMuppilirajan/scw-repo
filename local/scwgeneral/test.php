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

<?php
$web_url = "http:///fourbends1com";
$v = local_scw_valid_url($web_url);
var_dump($v);

?>

<pre>
<?php echo $USER->alogin; ?>
<?php print_r($USER); ?>
</pre>

 <div class="search-blk">
    <h4><i class="fa fa-search"></i>SEARCH</h4>
    <div class="search-blk-fields">
      <form action="<?php echo $CFG->wwwroot;?>/local/mylinks/search.php">
        <div class="form-group col-lg-2" id="profession-gp">
          <label for="searchprof">Search Profession</label>
          <select class="form-control" name="profession" id="profession">
            <option value="">--Select Profession--</option>
            <option value="1">Professional</option>
            <option value="2">Recent Graduates</option>
          </select>
        </div>
        <div class="form-group col-lg-2" id="country-gp">
          <label for="searchprof">Search By Country</label>
          <?php echo local_scwgeneral_get_countries(2); ?> </div>
        <div class="form-group col-lg-2" id="industry-gp">
          <label for="searchprof">Search By Industry</label>
          <?php echo local_scwgeneral_get_industry(2); ?> </div>
        <div class="form-group col-lg-2" id="functionalarea-gp">
          <label for="searchprof">Search By Functionl Area</label>
          <?php echo local_scwgeneral_get_farea(2); ?> </div>
        <div class="pull-right searchrst-btns">
          <button class="btn btn-brown" type="submit">SEARCH</button>
          <button class="btn btn-ash" type="reset">RESET</button>
        </div>
      </form>
    </div>
  </div>
  
   
  <?php echo local_scwgeneral_front_farea(); ?>


<?php
echo $OUTPUT->footer();