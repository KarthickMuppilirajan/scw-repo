<?php
define('AJAX_SCRIPT', true);

require_once('../../config.php');
require_once($CFG->dirroot.'/theme/supplychainwire/lib.php');
if (!isloggedin()) {
    echo "loggedout";
}
global $PAGE;
$userid=$USER->id;
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwmail/refresh_mail.php');
$mymail= get_string('mailbox','theme_supplychainwire');

$inbox=theme_supplychainwire_get_inbox_count($userid,'inbox');

if($inbox>0){ 
		 $mail_cir='<span class="circle_count">'.$inbox.'</span>';
  }else{
	  $mail_cir="";
  }
		
echo $mymail.' '.$mail_cir;
?>