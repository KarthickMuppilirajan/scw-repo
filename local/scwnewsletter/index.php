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
global $PAGE;
$title = 'News Letter';

if (isloggedin()) {
	$url=$CFG->wwwroot;
	redirect($url);
}



$systemcontext = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwnewletter/index.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);

$url = $CFG->wwwroot.'/local/scwnewsletter/index.php';

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

$args = array(
	'class'=>'form-horizontal'
);
$newsletter_form = new newsletter_form(null,$args);

$success=0;
if ($newsletter_data = $newsletter_form->get_data()) {
	//echo "Data Fetch";
	
	//print_r($newsletter_data);
	
	$subscribers = new stdClass;
	$subscribers->subscriber_type = 3; // set 3 for subscribers
	$subscribers->subscriber_name = $newsletter_data->subscriber_name;
	$subscribers->subscriber_email = $newsletter_data->subscriber_email;
	$subscribers->timecreated = $time ;
	$subscribers->status = 1 ; // set 1 for Default Active
	
	
	$exist_record=$DB->get_record('local_scwnewsletter_users',array('subscriber_email'=>$newsletter_data->subscriber_email));
	//print_r($exist_record); exit;
	if(!empty($exist_record)){
		$msg = 'Email address already exists in our Newsletter list.';
		redirect($url, $msg);		

     }else{
		$subscribed = $DB->insert_record('local_scwnewsletter_users', $subscribers);
		$msg = '<b>Newsletter has been sent.</b>';
		$success=1;
		//redirect($url, $msg);
	 }

}

echo $OUTPUT->header();
?>
<?php if($success==0) { ?>
<div class="login-blk">
  <div class="loginbox clearfix twocolumns scwloginarea-blk">
    <div class="loginpanel">
      <h4><i class="fa fa-users"></i>NEWSLETTER</h4>
      <div class="subcontent loginsub newsletter-blk">
      <?php $newsletter_form->display(); ?>
      </div>
    </div>
  </div>
</div>
<?php } else{ 
echo html_writer::start_tag('div', array('class'=>'alert alert-info'));
echo $msg;
echo '<p>Please add info@supplychainwire.com to safelist or mark it as "not spam" for you to receive them in Inbox.</p>';
echo html_writer::end_tag('div');
 }?>

<?php
echo $OUTPUT->footer();
?>
