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
 * Support local plugin.
 *
 * @package    local_support
 * @copyright  2016 Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../config.php');
require_once($CFG->libdir.'/authlib.php');
require_once(__DIR__ . '/lib.php');
global $CFG, $DB, $PAGE;
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->set_pagelayout('coursecategory');
$PAGE->set_title('Subcription');
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/login/ipn.php');
?>
<div style="display:none;">
<pre>
<?php 
$data=$_REQUEST;
print_r($data); 
?>
</pre>
</div>
<?php
echo $OUTPUT->header();
if($data['payment_status']=='Completed' or $data['payment_status']=='Pending')
{
?>
<div class="scwsuccess-blk">
<div class="scwsuccess-contnt">
<i class="fa fa-check-circle-o"></i><br>
<span>Payment Successful</span>
<p>We will email you a receipt confirming your payment shortly</p>
<div class="scwsuccess-img">
<img class="img-responsive" src="<?php echo $turl; ?>logo-small.png">
</div>
</div>
</div>
<?php
}
else
{
?>
<div class="scwfailure-blk">
<div class="scwfailure-contnt">
<i class="fa fa-close"></i><br>
<span>Payment Failure</span>
<p>The reson for the faliure is</p>
<div class="scwfailure-img">
<img class="img-responsive" src="<?php echo $turl; ?>logo-small.png">
</div>
</div>
</div>
<?php
}
echo $OUTPUT->footer();
?>