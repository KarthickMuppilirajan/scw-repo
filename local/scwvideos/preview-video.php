<?php
//define('AJAX_SCRIPT', true);
require("../../config.php");
global $PAGE,$USER;

$str = optional_param('videostr',null,PARAM_RAW);
$v = format_text($str,1);
$v = str_replace("brokenfile.php#","draftfile.php",$v);
$PAGE->set_context(context_system::instance());

//require_sesskey();

$videocontent = array("videocontent" => $v);

$OUTPUT->header();
echo json_encode($videocontent);
die();

?>



