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
$PAGE->set_title('Success');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_url('/login/approval_success.php');
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix/';
echo $OUTPUT->header();
?>
<div class="scwsuccess-blk">
<div class="scwsuccess-contnt">
<div class="scwsuccess-msg">
<i class="fa fa-check-circle-o"></i><br>
<span>Registration Successful</span>
<p>Password set up email will be sent shortly, once you are approved by our team.</p>
</div>
<div class="spamnotifications">
<h4>Didn't get the email?</h4>
1.	Password set up email will be sent shortly, once you are approved by our team<br />
2.	Check your junk mail or spam mail folder.<br />
3.	Still having no luck with the email? Send an email to info@supplychainwire.com<br />

<h4>Having problems or questions?</h4>
<p>If you don’t know how to proceed please don’t hesitate to contact our support team via email: info@supplychainwire.com</p>
</div>
<div class="scwsuccess-img">
<img class="img-responsive" src="<?php echo $turl; ?>logo-small.png">
</div>
</div>
</div>
<?php
echo $OUTPUT->footer();
?>