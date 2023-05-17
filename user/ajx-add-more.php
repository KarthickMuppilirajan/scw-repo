<?php
//define('AJAX_SCRIPT', true);
require("../config.php");
global $PAGE,$USER,$DB;
$userid=$USER->id;
//echo 'test'; exit;

$user = $DB->get_record('user', array('id' => $USER->id), '*', MUST_EXIST);

$userdetails = $DB->get_record('user_details', array('user_id' => $USER->id), '*');

$company_details = $DB->count_records("user_company_info", array("user_id" => $userid));
$education_details = $DB->count_records("user_education_info", array("user_id" => $userid));

$addmore = optional_param('addmore',null,PARAM_TEXT); // Add more button.
$removebtn = optional_param('removebtn', null, PARAM_TEXT); // Remove button.
$removerow = optional_param('removerow', null, PARAM_INT); // Remove row no.

$addmore1 = optional_param('addmore1',null,PARAM_TEXT); // Add more button Education.
$removebtn1 = optional_param('removebtn1', null, PARAM_TEXT); // Remove button Education.
$removerow1 = optional_param('removerow1', null, PARAM_INT); // Remove row no Education.

//first add more
$job_title1 = optional_param('job_title1',null,PARAM_TEXT); // Add more button Education.
$company1 = optional_param('company1', null, PARAM_TEXT); // Remove button Education.
$from_month1 = optional_param('from_month1', null, PARAM_TEXT); // Remove row no Education.
$from_year1 = optional_param('from_year1', null, PARAM_TEXT); // Remove row no Education.
$to_month1 = optional_param('to_month1', null, PARAM_TEXT); // Remove row no Education.
$to_year1 = optional_param('to_year1', null, PARAM_TEXT); // Remove row no Education.
$currenlty_working1 = optional_param('currenlty_working1', null, PARAM_TEXT); // Remove row no Education.

//first add more
$edu_institution1 = optional_param('edu_institution1',null,PARAM_TEXT); // Add more button Education.
$edu_city1 = optional_param('edu_city1', null, PARAM_TEXT); // Remove button Education.
$edu_country1 = optional_param('edu_country1', null, PARAM_TEXT); // Remove row no Education.
$edu_from_year1 = optional_param('edu_from_year1', null, PARAM_TEXT); // Remove row no Education.
$edu_to_year1 = optional_param('edu_to_year1', null, PARAM_TEXT); // Remove row no Education.


$PAGE->set_context(context_system::instance());
$PAGE->set_url('/user/ajx-add-more.php', array());

if(!empty($userdetails)){
// Add more company

	if(!empty($job_title1) && $company_details==0)
	{
		for($ci=1;$ci<=$userdetails->no_company;$ci++){
		$udata = new stdClass();
		$udata->job_title = $job_title1;
		$udata->company = $company1;
		$udata->from_month = $from_month1;
		$udata->from_year = $from_year1;
		$udata->to_month = $to_month1;
		$udata->to_year = $to_year1;
		$udata->company_row = $ci;
		$udata->user_id = $userdetails->user_id;
		 $udata->currently_working = isset($currenlty_working1) ? $currenlty_working1 : 0;
	}
		if(!empty($curcompany)){
		   $udata->id = $curcompany->id;
		   $DB->update_record('user_company_info',$udata);
		}else{
		   $DB->insert_record('user_company_info',$udata);
		}
	}
		
	if(!empty($addmore)){
		$oldnc = $userdetails->no_company;
		$oldnc;
        if($oldnc<10){
           $oldnc++;
           $userdetails->no_company = $oldnc;
           $DB->update_record('user_details', $userdetails);
           $addflag = 1;
        }
	}
	
	if($education_details==0 && !empty($edu_institution1))
	{
        // Education Information
        for($ei=1;$ei<=$userdetails->no_education;$ei++){
            $udata = new stdClass();
            $udata->user_id = $userdetails->user_id;
            $udata->edu_row = $ei;
            $udata->edu_institution = $edu_institution1;
            $udata->edu_city = $edu_city1;
            $udata->edu_country = $edu_country1;
            $udata->from_year = $edu_from_year1;
            $udata->to_year =$edu_to_year1;

            if(!empty($cureducation)){
                $udata->id = $cureducation->id;
                $DB->update_record('user_education_info',$udata);
            }else{
                $DB->insert_record('user_education_info',$udata);
            }
        }
	}
		
	
    // Remove row company
    if(!empty($removebtn)){
        $oldnc = $userdetails->no_company;
		if($oldnc>1){
            $oldnc--;
            $userdetails->no_company = $oldnc;
            $DB->update_record('user_details', $userdetails);
            $removeflag = 1;
			$condition = array("user_id" => $userdetails->user_id, "company_row" => $removerow);
			$DB->delete_records('user_company_info', $condition);
		}
    }
	
    // Add more education
    if(!empty($addmore1)){
        $oldne = $userdetails->no_education;
        if($oldne<10){
           $oldne++;
           $userdetails->no_education = $oldne;
           $DB->update_record('user_details', $userdetails);
           $addflag1 = 1;
        }
    }

    // Remove row education
    if(!empty($removebtn1)){
        $oldne = $userdetails->no_education;
		if($oldne>1){
            $oldne--;
            $userdetails->no_education = $oldne;
            $DB->update_record('user_details', $userdetails);
            $removeflag1 = 1;
			$condition = array("user_id" => $userdetails->user_id, "edu_row" => $removerow1);
			$DB->delete_records('user_education_info', $condition);
		}
    }
}

$ajxresult = array("message" => "success");

$OUTPUT->header();
echo json_encode($ajxresult);
die();

?>



