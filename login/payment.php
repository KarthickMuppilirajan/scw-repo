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
require_once('payment_form.php');
$systemcontext = context_system::instance();
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$PAGE->set_context($systemcontext);
$PAGE->set_pagelayout('coursecategory');
$PAGE->set_title('Subscription');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_url('/login/payment.php');
$mform = new payment_form();
$random_url = optional_param('random_url', false, PARAM_RAW);
$user_details_record=$DB->get_record('user_details', array('random_url' => $random_url));
$payment_url_creation=$user_details_record->payment_url_creation;
$user_record=$DB->get_record('user', array('id' => $user_details_record->user_id));
$firstname=$user_record->firstname;
$lastname=$user_record->lastname;
$email=$user_record->email;
$userid=$user_record->id;
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix/';
//$amount =  '1.00'; 
$amount =  '60.00'; 
//$paypalurl='https://www.sandbox.paypal.com/cgi-bin/webscr';
$paypalurl='https://www.paypal.com/cgi-bin/webscr';
if ($mform->is_cancelled()) {
} else if ($payment_form = $mform->get_data()) {
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
echo $OUTPUT->header();
//$mform->display();
$puc=$payment_url_creation;
$payment_url_creation=$payment_url_creation+7*24*60*60;

if($payment_url_creation<$time)
{
		echo '<div class="subscription-blk">
<h4>SUBSCRIPTION</h4>
<div class="subscription-contnt">
<h5>URL Expired, Please contact site admin at info@supplychainwire.com</h5>';	
}
elseif($email)
{
?>
<div class="subscription-blk">
<h4>SUBSCRIPTION</h4>
<div class="subscription-contnt">
<h5>Subscribe to SCW for <span>&pound;60.00</span> per year</h5>
<img class="img-responsive" src="<?php echo $turl; ?>paypal.png">
<form action="<?php echo $paypalurl ?>" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="charset" value="utf-8" />
<input type="hidden" name="business" value="info@supplychainwire.com" />
<input type="hidden" name="item_name" value="SCW Subsription" />
<input type="hidden" name="quantity" value="1" />
<input type="hidden" name="custom" value="<?php echo $random_url.'_'.$puc?>" />
<input type="hidden" name="currency_code" value="GBP" />
<input type="hidden" name="amount" value="<?php echo $amount ?>" />
<input type="hidden" name="for_auction" value="false" />
<input type="hidden" name="no_note" value="1" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="notify_url" value="<?php echo $CFG->wwwroot.'/login/ipn.php';?>" />
<input type="hidden" name="return" value="<?php echo $CFG->wwwroot.'/login/return.php';?>" />
<input type="hidden" name="cancel_return" value="<?php echo $CFG->wwwroot.'/login/cancel.php';?>" />
<input type="hidden" name="rm" value="2" />
<input type="hidden" name="cbt" value="Return to The website" />
<input type="hidden" name="first_name" value="<?php echo $firstname ?>" />
<input type="hidden" name="last_name" value="<?php echo $lastname ?>" />
<input type="hidden" name="address" value="" />
<input type="hidden" name="city" value="" />
<input type="hidden" name="email" value="<?php echo $email ?>" />
<input type="hidden" name="country" value="" />
<button class="btn btn-blk">Pay Now</button>
</form>
</div>
</div>

<?php
}
else
{
	echo '<div class="subscription-blk">
<h4>SUBSCRIPTION</h4>
<div class="subscription-contnt">
<h5>URL Not valid</h5>
';
}
echo $OUTPUT->footer();