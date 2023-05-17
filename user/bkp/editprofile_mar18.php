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
 * Allows you to edit a users profile
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_user
 */

require_once('../config.php');
require_once($CFG->libdir.'/gdlib.php');
require_once($CFG->dirroot.'/user/editprofile_form.php');
require_once($CFG->dirroot.'/user/editlib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');

global $USER,$DB,$OUTPUT;
require_login();

// HTTPS is required in this page when $CFG->loginhttps enabled.
$PAGE->https_required();
$userid = optional_param('id', $USER->id, PARAM_INT);    // User id.
$course = optional_param('course', SITEID, PARAM_INT);   // Course id (defaults to Site).
$returnto = optional_param('returnto', null, PARAM_ALPHA);  // Code determining where to return to after save.
$addmore = optional_param('addmore',null,PARAM_TEXT); // Add more button.
$removebtn = optional_param('removebtn', null, PARAM_TEXT); // Remove button.
$removerow = optional_param('removerow', null, PARAM_INT); // Remove row no.

$addmore1 = optional_param('addmore1',null,PARAM_TEXT); // Add more button Education.
$removebtn1 = optional_param('removebtn1', null, PARAM_TEXT); // Remove button Education.
$removerow1 = optional_param('removerow1', null, PARAM_INT); // Remove row no Education.

$user = $DB->get_record('user', array('id' => $USER->id), '*', MUST_EXIST);

$userdetails = $DB->get_record('user_details', array('user_id' => $USER->id), '*');

$syscontext = context_system::instance();
$personalcontext = context_user::instance($user->id);

$editurl = new moodle_url('/user/editprofile.php');

$PAGE->set_url('/user/editprofile.php', array());

if (!$course = $DB->get_record('course', array('id' => $course))) {
    print_error('invalidcourseid');
}

$PAGE->set_pagelayout('scwpage');
$PAGE->set_context($syscontext);

// Display page header.
$streditmyprofile = get_string('editmyprofile');
$strparticipants  = get_string('participants');
$userfullname     = fullname($user, true);

$PAGE->set_title("$course->shortname: $streditmyprofile");
$addflag = 0;
$removeflag = 0;
$addflag1 = 0;
$removeflag1 = 0;

if(!empty($userdetails)){
	$args = array('userdetails' => $userdetails, 'usermain' => $user);
	// Add more company
	if(!empty($addmore)){
		$oldnc = $userdetails->no_company;
        if($oldnc<10){
           $oldnc++;
           $userdetails->no_company = $oldnc;
           $DB->update_record('user_details', $userdetails);
           $addflag = 1;
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

}else{
	$args = array('userdetails' => '', 'usermain' => '' );
}

$editusers = new stdClass();
$editusers->id = $user->id;
$editusers->firstname = $user->firstname;
$editusers->lastname = $user->lastname;
$editusers->middlename = $user->middlename;
$editusers->email = $user->email;
$editusers->country = !empty($user->country) ? $user->country : 'GB';
$editusers->phone1 = $user->phone1;
$editusers->city = $user->city;

// Prepare the editor and create form.
$editoroptions = array(
    'maxfiles'   => EDITOR_UNLIMITED_FILES,
    'maxbytes'   => $CFG->maxbytes,
    'trusttext'  => false,
    'forcehttps' => false,
    'context'    => $syscontext
);

/* $sql = "SELECT * FROM {files} WHERE `contextid` = '".$personalcontext->id."' AND `component` LIKE 'user' AND `filearea` LIKE 'draft' AND filesize > 0 order by id desc limit 1";
$presult = $DB->get_record_sql($sql);

if(!empty($presult)){
  $draftitemid = $presult->itemid;
}else{
  $draftitemid = 0;	
} */

if(!empty($userdetails)){
    $draftitemid = !empty($userdetails->profile_pic) ? $userdetails->profile_pic : 0;
}else{
  $draftitemid = 0;	
}

$filemanageroptions = array('maxbytes'       => $CFG->maxbytes,
                             'subdirs'        => 0,
                             'maxfiles'       => 1,
                             'accepted_types' => 'web_image');

file_prepare_draft_area($draftitemid, $personalcontext->id, 'user', 'newicon', 0, $filemanageroptions);

$editusers->profile_pic = $draftitemid;

$args["filemanageroptions"] = $filemanageroptions;
$args["addflag"] = $addflag;
$args["editoroptions"] = $editoroptions;
							 
$userform = new editprofile_form(null, $args);

							 
if(!empty($userdetails)){
    $editusers->is_searchable = $userdetails->is_searchable;
    $editusers->receive_newsletter = $userdetails->receive_newsletter;
    $editusers->receive_email = $userdetails->receive_email;
	$editusers->industry = !empty($userdetails->industry) ? $userdetails->industry : 'education';
    $editusers->functional_area =  !empty($userdetails->functional_area) ? $userdetails->functional_area : 'supply-chain-management-for-marketing';
	$editusers->summary = $userdetails->summary;
    $editusers->awards_reg  = $userdetails->awards_reg;
    $editusers->awards_regformat  = $userdetails->awards_regformat;
    $editusers = file_prepare_standard_editor($editusers, 'awards_reg', $editoroptions, $syscontext, 'local_scwgeneral', 'awards_reg', $userdetails->user_id);
    $editusers->web_url = $userdetails->web_url;
    $editusers->linkedin_url = $userdetails->linkedin_url;
	$editusers->resume = $userdetails->resume;
	
	if($userdetails->profession==2){
		$rsmdraftitemid = file_get_submitted_draft_itemid('resume');
        $userdetails->resume = $rsmdraftitemid;
        file_prepare_draft_area($rsmdraftitemid, $syscontext->id, 'local_scwbanner', 'resume', $userdetails->user_id,
                         array('subdirs' => 0, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => 1));
						 
        $editusers->sniff_keyword = $userdetails->sniff_keyword;
	}
	
    // company information
    if($userdetails->profession==1){
        $companysinfo = $DB->get_records('user_company_info',array('user_id' => $userdetails->user_id),"company_row asc");
		$sidx = 1;
        foreach($companysinfo as $companyinfo){
           $editusers->{"job_title".$sidx} = $companyinfo->job_title;
           $editusers->{"company".$sidx} = $companyinfo->company;
           $editusers->{"company".$sidx} = $companyinfo->company;
           $editusers->{"from_month".$sidx} = $companyinfo->from_month;
           $editusers->{"from_year".$sidx} = $companyinfo->from_year;
           $editusers->{"to_month".$sidx} = $companyinfo->to_month;
           $editusers->{"to_year".$sidx} = $companyinfo->to_year;
           $editusers->{"currently_working".$sidx} = $companyinfo->currently_working;
		   $sidx++;
        }
	}
	
	// Education information
    $educationsinfo = $DB->get_records('user_education_info',array('user_id' => $userdetails->user_id),"edu_row asc");
    $sidx1 = 1;
    foreach($educationsinfo as $educationinfo){
        $editusers->{"edu_institution".$sidx1} = $educationinfo->edu_institution;
        $editusers->{"edu_city".$sidx1} = $educationinfo->edu_city;
        $editusers->{"edu_country".$sidx1} = $educationinfo->edu_country;
        $editusers->{"edu_from_year".$sidx1} = $educationinfo->from_year;
        $editusers->{"edu_to_year".$sidx1} = $educationinfo->to_year;
        $sidx1++;
    }
	
}



$userform->set_data($editusers);

if ($usernew = $userform->get_data()) {
    
    $usermain = new stdClass();
    $usermain->id = $usernew->id;
	$usermain->firstname = $usernew->firstname;
    $usermain->lastname = $usernew->lastname;
    $usermain->middlename = $usernew->middlename;
    $usermain->email = $usernew->email;
    $usermain->country = $usernew->country;
    $usermain->phone1 = $usernew->phone1;
	$usermain->city = $usernew->city;
	$usermain->timemodified = time();

	if(!empty($userdetails)){
	   $usernew->imagefile = $usernew->profile_pic;
	}
	
    $DB->update_record('user', $usermain);
	
	core_user::update_picture($usernew, $filemanageroptions);

    if(!empty($userdetails)){
		$usernew = file_postupdate_standard_editor($usernew, 'awards_reg', $editoroptions, $syscontext, 'local_scwgeneral', 'awards_reg', $userdetails->user_id);
        $userdetails->industry = $usernew->industry;
        $userdetails->functional_area =  $usernew->functional_area;
		$userdetails->is_searchable = $usernew->is_searchable;
        $userdetails->receive_newsletter = $usernew->receive_newsletter;
        $userdetails->receive_email = $usernew->receive_email;
		$userdetails->summary = $usernew->summary;
		$userdetails->awards_reg       = $usernew->awards_reg_editor['text'];
        $userdetails->awards_regformat = $usernew->awards_reg_editor['format'];
		$userdetails->profile_pic = $usernew->profile_pic;
        $userdetails->web_url = $usernew->web_url;
        $userdetails->linkedin_url = $usernew->linkedin_url;
		
		if($userdetails->profession==2){
			$userdetails->sniff_keyword = $usernew->sniff_keyword;
			
			file_save_draft_area_files($usernew->resume, $syscontext->id, 'local_scwbanner', 'resume',
                   $userdetails->user_id, array('subdirs' => 0, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => 1));
		}
		
        $DB->update_record('user_details', $userdetails);
		
		
        // Company Information

        if($userdetails->profession==1){
			for($ci=1;$ci<=$userdetails->no_company;$ci++){
                $curcompany = $DB->get_record('user_company_info',array('user_id' => $userdetails->user_id, "company_row"  => $ci));
				$jobtitle = "job_title".$ci;
				$cjob = $usernew->{$jobtitle};
                $company = "company".$ci;
                $ccompany = $usernew->{$company};
                $fyear = "from_year".$ci;
                $cfyear = $usernew->{$fyear};
                $fmonth = "from_month".$ci;
                $cfmonth = $usernew->{$fmonth};
                $tyear = "to_year".$ci;
                $ctyear = $usernew->{$tyear};
                $tmonth = "to_month".$ci;
                $ctmonth = $usernew->{$tmonth};

                $udata = new stdClass();
                $udata->job_title = $cjob;
				$udata->company = $ccompany;
                $udata->from_month = $cfmonth;
                $udata->from_year = $cfyear;
                $udata->to_month = $ctmonth;
                $udata->to_year = $ctyear;
                $udata->company_row = $ci;
				$udata->user_id = $userdetails->user_id;

				if(!empty($curcompany)){
                   $udata->id = $curcompany->id;
				   $DB->update_record('user_company_info',$udata);
                }else{
                   $DB->insert_record('user_company_info',$udata);
				}
            }
        }

        // Education Information
        for($ei=1;$ei<=$userdetails->no_education;$ei++){
            $cureducation = $DB->get_record('user_education_info',array('user_id' => $userdetails->user_id, "edu_row"  => $ei));
            $udata = new stdClass();
            $udata->user_id = $userdetails->user_id;
            $udata->edu_row = $ei;
            $udata->edu_institution = $usernew->{"edu_institution".$ei};
            $udata->edu_city = $usernew->{"edu_city".$ei};
            $udata->edu_country = $usernew->{"edu_country".$ei};
            $udata->from_year = $usernew->{"edu_from_year".$ei};
            $udata->to_year = $usernew->{"edu_to_year".$ei};

            if(!empty($cureducation)){
                $udata->id = $cureducation->id;
                $DB->update_record('user_education_info',$udata);
            }else{
                $DB->insert_record('user_education_info',$udata);
            }
        }

    }

	$msg = 'Successfull updated';
	redirect($editurl, $msg, 42);
	//redirect($CFG->wwwroot.'/', $msg, 42);

}


echo $OUTPUT->header();
?>
<style type="text/css">
#swc_signup .fdescription{
    display:none;
}
.companyinfo-box, .educationinfo-box{
    background-color:#fff;
	padding: 20px;
	box-shadow:0 2px 3px 0 #828081;
	margin:20px;
}
.companyinfo-box h5, .educationinfo-box h5{
    color: #560c25;
}
.btn-addmore, .btn-remove, .btn-remove1{
	background-color: #000 !important;
	color: #fff !important;
}
</style>

<div class="signup-blk" id="swc_signup" style="width:100%">
<h4><i class="fa fa-users"></i>Edit Profile</h4>
<?php $userform->display(); ?>
</div>

<?php
// And proper footer.
echo $OUTPUT->footer();
?>
<script type="text/javascript">
require(['jquery'], function( $ ) {
    $(".btn-remove").on('click', function(){
		var cbobj = $(this);
        var dr = cbobj.attr("data-row");
        $("input[name=removerow]").val(dr);
		
		var cnt = 1; var idx = 0;
        $(".companyinfo-box").each(function(){
			if(cnt==dr){
				cnt++;
				return;
			}else{
				idx++;
				cnt++;
			}
			
            var cobj = $(this);
            cobj.find(".txtjobtitle").attr("name", "job_title"+idx);
            cobj.find(".txtcompany").attr("name", "company"+idx);
            cobj.find(".cmbfrommonth").attr("name", "from_month"+idx);
            cobj.find(".cmbfromyear").attr("name", "from_year"+idx);
            cobj.find(".cmbtomonth").attr("name", "to_month"+idx);
            cobj.find(".cmbtoyear").attr("name", "to_year"+idx);
            cobj.find(".cwork").attr("name", "currently_working"+idx);
		});
    });

    $(".btn-remove1").on('click', function(){
		var cbobj = $(this);
        var dr = cbobj.attr("data-row");
        $("input[name=removerow1]").val(dr);
		
		var cnt = 1; var idx = 0;
        $(".educationinfo-box").each(function(){
			if(cnt==dr){
				cnt++;
				return;
			}else{
				idx++;
				cnt++;
			}
			
            var cobj = $(this);
            cobj.find(".txtinstitution").attr("name", "edu_institution"+idx);
            cobj.find(".txteducity").attr("name", "edu_city"+idx);
            cobj.find(".cmbeducountry").attr("name", "edu_country"+idx);
            cobj.find(".cmbfromyear1").attr("name", "edu_from_year"+idx);
            cobj.find(".cmbtoyear1").attr("name", "edu_to_year"+idx);
		});
    });

});
</script>

