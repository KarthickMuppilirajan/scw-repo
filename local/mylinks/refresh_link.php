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
$PAGE->set_url('/local/mylinks/refresh_link.php');
$mylinks = get_string('mylinks','theme_supplychainwire');

$connect_count=theme_supplychainwire_get_pending_connect($userid,'inbox');

		if($connect_count>0){
			$connection_cir='<span class="circle_count">'.$connect_count.'</span>';			
		}else{
			$connection_cir="";
		}
		
echo $mylinks.' '.$connection_cir;
?>