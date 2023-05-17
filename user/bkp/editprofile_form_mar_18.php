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
 * Form to edit a users profile
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_user
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');
require_once($CFG->dirroot.'/local/scwgeneral/lib.php');

/**
 * Class user_edit_form.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class editprofile_form extends moodleform {

    /**
     * Define the form.
     */
    public function definition () {
        global $CFG, $PAGE, $USER, $COURSE;
        $mform = $this->_form;

        $userdetails = $this->_customdata['userdetails'];
        $usermain = $this->_customdata['usermain'];
        $filemanageroptions = $this->_customdata['filemanageroptions'];
        $addflag = $this->_customdata['addflag'];
        $editoroptions = $this->_customdata['editoroptions'];

		// Add some extra hidden fields.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        
		
        $mform->addElement('text', 'firstname',  get_string('firstname', 'local_scwgeneral'),  'maxlength="100" class="textfield" ');
		$strmissingfield = get_string('missingfirstname', 'local_scwgeneral');
        $mform->addRule('firstname', $strmissingfield, 'required', null, 'client');
        $mform->setType('firstname', PARAM_NOTAGS);
		
        $mform->addElement('text', 'middlename',  get_string('middlename', 'local_scwgeneral'),  'maxlength="100" class="textfield" ');
        $strmissingfield = get_string('missingmiddlename', 'local_scwgeneral');
        $mform->setType('middlename', PARAM_NOTAGS);

        $mform->addElement('text', 'lastname',  get_string('lastname', 'local_scwgeneral'),  'maxlength="100" class="textfield" ');
        $strmissingfield = get_string('missinglastname', 'local_scwgeneral');
        $mform->addRule('lastname', $strmissingfield, 'required', null, 'client');
        $mform->setType('lastname', PARAM_NOTAGS);
		
		$mform->addElement('text', 'email',  get_string('email', 'local_scwgeneral'),  'maxlength="100" class="textfield"  readonly');
        $mform->setType('email', PARAM_NOTAGS);
		
        $mform->addElement('text', 'phone1', get_string('telephone'), 'maxlength="20" class="textfield"');
		$mform->addHelpButton('phone1', 'telephone');
        $mform->setType('phone1', PARAM_RAW);
        $mform->addRule('phone1', get_string('phone_required'), 'required', null, 'client');
		$mform->addRule('phone1', get_string('phone_valid'), 'regex', '#^[0-9\.)(+-_ ]+$#', 'client');

        $months = local_scw_get_months();
		$years = local_scw_get_years();


		// Company Information
        if (isset($userdetails->profession) && $userdetails->profession==1) {
            for($i=1;$i<=$userdetails->no_company;$i++){
                if($i==1){
                    $mform->addElement('html', '<div class="companyinfo-box clearfix"><div class="row"><div class="pull-left"><h5>Company Info</h5></div>');
                    $btnhtml = '<div class="pull-right">
                    <input name="addmore" class="btn btn-addmore" value="Addmore+" type="submit" id="id_addmorebutton">
                    </div></div>';
                }else{
                    $mform->addElement('html', '<div class="companyinfo-box clearfix"><div class="row"><div class="pull-left"><h5>Company Info</h5></div>');
                    $btnhtml = '<div class="pull-right">
                    <input name="removebtn" class="btn btn-remove" data-row="'.$i.'" value="Remove-" type="submit">
                    </div></div>';
                }

                $mform->addElement('html', $btnhtml);
                $fld = 'job_title'.$i;
                $mform->addElement('text',$fld,'Job Title','maxlength="100" class="textfield txtjobtitle"');
                $mform->addRule($fld, 'Missing Job Title', 'required', null, 'client');
                $mform->setType($fld, PARAM_TEXT);

                $fld = 'company'.$i;
                $mform->addElement('text',$fld,'Company','maxlength="100" class="textfield txtcompany"');
                $mform->addRule($fld, 'Missing Company', 'required', null, 'client');
                $mform->setType($fld, PARAM_TEXT);

                $mform->addElement('static','TimePeriod',null ,'Time Period');

                $monthgroup=array();
                $mfld = 'from_month'.$i;
                $yfld = 'from_year'.$i;
                $monthgroup[] =& $mform->createElement('select', $mfld, '',$months, array("class" => "cmbfrommonth"));
                $monthgroup[] =& $mform->createElement('select', $yfld, '',$years, array("class" => "cmbfromyear")); 
                $mform->addGroup($monthgroup, 'monthgroup', 'From', ' ', false);

                $yeargroup=array();
                $mfld = 'to_month'.$i;
                $yfld = 'to_year'.$i;
                $yeargroup[] =& $mform->createElement('select', $mfld, '',$months, array("class" => "cmbtomonth"));
                $yeargroup[] =& $mform->createElement('select', $yfld, '', $years, array("class" => "cmbtoyear"));
                $mform->addGroup($yeargroup, 'yeargroup', 'To', ' ', false);

                $checkbox = $mform->addElement('advcheckbox', 'currently_working'.$i, null, 'I am currently working here', array('group' => 1, 'class' => 'cwork'), array(0, 1));			
                $mform->addElement('html', '</div>');
				
                if($addflag=="1"){
                    // $mform->hardFreeze('job_title'.$i);
                    // $mform->hardFreeze('company'.$i);
                }
				
            }

        }

		$mform->addElement('text', 'city',  get_string('city', 'local_scwgeneral'),  'maxlength="100" class="textfield"');
        $strmissingfield = get_string('missingcity', 'local_scwgeneral');
        $mform->addRule('city', $strmissingfield, 'required', null, 'client');
        $mform->setType('city', PARAM_NOTAGS);
		
        $choices = get_string_manager()->get_list_of_countries();
        $choices = array('' => get_string('selectacountry') . '...') + $choices;
        $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
		$strmissingfield = get_string('missingcountry', 'local_scwgeneral');
		$mform->addRule('country', $strmissingfield, 'required', null, 'client');
		
        if(!empty($userdetails)){
            if ($userdetails->profession==1) {
                $industries = local_scwgeneral_get_industry();
                $industries = array('' => get_string('selectaindustry', 'local_scwgeneral') . '...') + $industries;
		        $mform->addElement('select', 'industry', get_string('industry', 'local_scwgeneral'), $industries);
		        $strmissingfield = get_string('missingindustry', 'local_scwgeneral');
		        $mform->addRule('industry', $strmissingfield, 'required', null, 'client');

		        $fareas = local_scwgeneral_get_farea();
                $fareas = array('' => get_string('selectafarea', 'local_scwgeneral') . '...') + $fareas;
		        $mform->addElement('select', 'functional_area', get_string('farea', 'local_scwgeneral'), $fareas);
		        $strmissingfield = get_string('missingfarea', 'local_scwgeneral');
		        $mform->addRule('functional_area', $strmissingfield, 'required', null, 'client');
            }
        }
		
		//Education information
        if (!empty($userdetails)) {
            for($i=1;$i<=$userdetails->no_education;$i++){
                if($i==1){
                    $mform->addElement('html', '<div class="educationinfo-box clearfix"><div class="row"><div class="pull-left"><h5>Education Info</h5></div>');
                    $btnhtml = '<div class="pull-right">
                    <input name="addmore1" class="btn btn-addmore" value="Addmore+" type="submit" id="id_addmorebutton1">
                    </div></div>';
                }else{
                    $mform->addElement('html', '<div class="educationinfo-box clearfix"><div class="row"><div class="pull-left"><h5>Education Info</h5></div>');
                    $btnhtml = '<div class="pull-right">
                    <input name="removebtn1" class="btn btn-remove1" data-row="'.$i.'" value="Remove-" type="submit">
                    </div></div>';
                }

                $mform->addElement('html', $btnhtml);
                $fld = 'edu_institution'.$i;
                $mform->addElement('text',$fld,'College/University','maxlength="100" class="textfield txtinstitution"');
                $mform->addRule($fld, 'Missing College/University', 'required', null, 'client');
                $mform->setType($fld, PARAM_TEXT);

                $fld = 'edu_city'.$i;
                $mform->addElement('text',$fld,'City','maxlength="100" class="textfield txteducity"');
                $mform->addRule($fld, 'Missing City', 'required', null, 'client');
                $mform->setType($fld, PARAM_TEXT);

                $choices = get_string_manager()->get_list_of_countries();
                $choices = array('' => get_string('selectacountry') . '...') + $choices;
				$fld = 'edu_country'.$i;
                $mform->addElement('select', $fld, get_string('selectacountry'), $choices, array("class" => "cmbeducountry"));
                $strmissingfield = get_string('missingcountry', 'local_scwgeneral');
                $mform->addRule($fld, $strmissingfield, 'required', null, 'client');

                $mform->addElement('static','TimePeriod',null ,'Time Period');

                $monthgroup=array();
                $yfld = 'edu_from_year'.$i;
                $monthgroup[] =& $mform->createElement('select', $yfld, '',$years, array("class" => "cmbfromyear1")); 
                $mform->addGroup($monthgroup, 'monthgroup', 'From', ' ', false);

                $yeargroup=array();
                $yfld = 'edu_to_year'.$i;
                $yeargroup[] =& $mform->createElement('select', $yfld, '', $years, array("class" => "cmbtoyear1"));
                $mform->addGroup($yeargroup, 'yeargroup', 'To', ' ', false);
                
                $mform->addElement('html', '</div>');
				
            }

        }
		
        if(!empty($userdetails)){
		   $mform->addElement('filemanager', 'profile_pic', get_string('uploadproimage', 'local_scwgeneral'),null,$filemanageroptions);
           $mform->addHelpButton('profile_pic', 'newpicture');
        }else{
			$mform->addElement('static', 'currentpicture', get_string('currentpicture'));

            $mform->addElement('checkbox', 'deletepicture', get_string('delete'));
            $mform->setDefault('deletepicture', 0);
		
            $mform->addElement('filemanager', 'imagefile', get_string('uploadproimage', 'local_scwgeneral'),null,$filemanageroptions);
		    $mform->addHelpButton('imagefile', 'newpicture');
		}

        if(!empty($userdetails)){
			
			if($userdetails->profession==2){
				$mform->addElement('filemanager', 'resume', 'Resume',null, array('subdirs' => 0, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => 1));
				
				$mform->addElement('text', 'sniff_keyword', 'Searchable Profile', ' maxlength="100" class="textfield"');
				$strmissingfield = 'Missing Searchable Profile';
		        $mform->addRule('sniff_keyword', $strmissingfield, 'required', null, 'client');
				$mform->addElement('static', 'sniff_keyword_static',null, 'Comma separated values');
			}
			
            $mform->addElement('editor', 'awards_reg_editor', 'Awards/Recognitions',null, $editoroptions);
			$mform->setType('awards_reg_editor', PARAM_RAW);
        }

        if(!empty($userdetails)){
			
			$mform->addElement('text', 'web_url', 'Website/Blog',  'class="textfield"');
			$strmissingfield = 'Missing Website/Blog';
			//$mform->addRule('web_url', $strmissingfield, 'required', null, 'client');
            $mform->setType('web_url', PARAM_RAW);
			
			$mform->addElement('text', 'linkedin_url', 'Linkedin URL',  'class="textfield"');
			$strmissingfield = 'Missing Linkedin URL';
			//$mform->addRule('linkedin_url', $strmissingfield, 'required', null, 'client');
            $mform->setType('linkedin_url', PARAM_RAW);
			
			$mform->addElement('textarea', 'summary',  get_string('summary', 'local_scwgeneral'),  ' rows="17" cols="100" class="textfield"');
		    $strmissingfield = get_string('missingsummary', 'local_scwgeneral');
            $mform->addRule('summary', $strmissingfield, 'required', null, 'client');
            $mform->setType('summary', PARAM_NOTAGS);
		
            $checkbox = $mform->addElement('advcheckbox', 'is_searchable', null, get_string('allowpublicsearch', 'local_scwgeneral'), array('group' => 1), array(0, 1));
            $checkbox->setChecked(true);

    		$checkbox = $mform->addElement('advcheckbox', 'receive_newsletter', null, get_string('receivenewsletter', 'local_scwgeneral'), array('group' => 1), array(0, 1));
            $checkbox->setChecked(true);

            $checkbox = $mform->addElement('advcheckbox', 'receive_email', null, get_string('receivenotification', 'local_scwgeneral'), array('group' => 1), array(0, 1));
            $checkbox->setChecked(true);
        }

		
        $mform->addElement('hidden', 'removerow', '');
		$mform->setType('removerow',PARAM_INT);
		
		$mform->addElement('hidden', 'removerow1', '');
		$mform->setType('removerow1',PARAM_INT);

        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('reset', 'cancel', get_string('reset'), array("class" => "btn btn-ash"));
	    $buttonarray[] = &$mform->createElement('submit', 'update', get_string('update'),array("class" => "btn btn-brown"));
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);

    }
	
	public function definition_after_data() {
        global $USER, $CFG, $DB, $OUTPUT;

        $mform = $this->_form;
		$userdetails = $this->_customdata['userdetails'];
		
		if ($userid = $mform->getElementValue('id')) {
            $user = $DB->get_record('user', array('id' => $userid));
        } else {
            $user = false;
        }
		
		if(empty($userdetails)){
			  
			  // Print picture.
			if (empty($USER->newadminuser)) {
				if ($user) {
					$context = context_user::instance($user->id, MUST_EXIST);
					$fs = get_file_storage();
					$hasuploadedpicture = ($fs->file_exists($context->id, 'user', 'icon', 0, '/', 'f2.png') || $fs->file_exists($context->id, 'user', 'icon', 0, '/', 'f2.jpg'));
					if (!empty($user->picture) && $hasuploadedpicture) {
						$imagevalue = $OUTPUT->user_picture($user, array('courseid' => SITEID, 'size' => 64));
					} else {
						$imagevalue = get_string('none');
					}
				} else {
					$imagevalue = get_string('none');
				}
				$imageelement = $mform->getElement('currentpicture');
				$imageelement->setValue($imagevalue);

				if ($user && $mform->elementExists('deletepicture') && !$hasuploadedpicture) {
					$mform->removeElement('deletepicture');
				}
			}
			  
		}
		
	}	

	/**
     * Validation.
     *
     * @param array $data
     * @param array $files
     * @return array the errors that were found
     */
    public function validation($data, $files) {
        global $DB;
       
        $errors = parent::validation($data, $files);
        
		$web_url  = $data['web_url'];
		if(!empty($data['web_url'])){
		   if(!local_scw_valid_url($web_url)){
			 // $errors['web_url'] = 'Please enter valid Website/Blog';
		   }
		}
		
		$linkedin_url  = $data['linkedin_url'];
		if(!empty($data['linkedin_url'])){
		   if(!local_scw_valid_url($linkedin_url)){
			 // $errors['linkedin_url'] = 'Please enter valid Linkedin URL';
		   }
		}
		
        return $errors;
    }

}


