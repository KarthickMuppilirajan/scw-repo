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
 * @package local-scwnewsletter
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once('newsletter_form.php');
require('lib.php');
global $PAGE;
$title = 'News Letter';

$subscriber_id = optional_param('user_id', 0, PARAM_INT);
$user_type = optional_param('user_type', 0, PARAM_TEXT);

$systemcontext = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwnewletter/index.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);

$url = $CFG->wwwroot.'/local/scwnewsletter/index.php';

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

echo $OUTPUT->header();

if($subscriber_id && $user_type){
	$result=scwnewsletter_unsubscribe($subscriber_id,$user_type);
	
}
?>

<div class="login-blk">
  <div class="loginbox clearfix twocolumns scwloginarea-blk">
    <div class="loginpanel">
      <h4><i class="fa fa-users"></i>NEWSLETTER</h4>
      <div class="subcontent loginsub">
      <?php if($result){?>
          <div class="alert alert-success">
              <strong> Newsletter has been unsubscribed successfully.</strong>
            </div>
        <?php } else{?>
        <div class="alert alert-danger">
          <strong> Oops! please try again later.</strong>
        </div>
        <?php } ?>

      </div>
    </div>
  </div>
</div>
<?php
echo $OUTPUT->footer();
?>
