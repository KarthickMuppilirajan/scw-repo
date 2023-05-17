<?php
require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/authlib.php');
require_once($CFG->dirroot.'/user/filters/lib.php');
require_once($CFG->dirroot.'/user/lib.php');

global $PAGE,$USER,$DB;


$PAGE->set_context(context_system::instance());

$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();
$time = $time - (60*24*60*60);
	
// Banner Flush
$DB->execute("UPDATE {local_scwbanner} SET banner_delete='1' WHERE banner_created <= '$time' ");
// Interviews Flush
$DB->execute("UPDATE {local_scwinterviews} SET interview_delete='1' WHERE interview_created <= '$time' ");
//Videos
$DB->execute("UPDATE {local_scwvideos} SET video_delete='1' WHERE video_created <= '$time'");
// Events Flush
$DB->execute("UPDATE {local_scwevents} SET event_delete='1' WHERE event_created <= '$time' ");

echo date("d M Y h:i:s a",$time);
exit;
		
?>