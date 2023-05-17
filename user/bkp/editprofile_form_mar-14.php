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

		$mform->addElement('text', 'city',  get_string('city', 'local_scwgeneral'),  'maxlength="100" class="textfield"');
        $strmissingfield = get_string('missingcity', 'local_scwgeneral');
        $mform->addRule('city', $strmissingfield, 'required', null, 'client');
        $mform->setType('city', PARAM_NOTAGS);
		
        $choices = get_string_manager()->get_list_of_countries();
        $choices = array('' => get_string('selectacountry') . '...') + $choices;
        $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
		
		$mform->addElement('filemanager', 'imagefile', get_string('uploadproimage', 'local_scwgeneral'),null,$filemanageroptions);
		$mform->addHelpButton('imagefile', 'newpicture');
		

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

            $checkbox = $mform->addElement('advcheckbox', 'is_searchable', null, get_string('allowpublicsearch', 'local_scwgeneral'), array('group' => 1), array(0, 1));
            $checkbox->setChecked(true);

    		$checkbox = $mform->addElement('advcheckbox', 'receive_newsletter', null, get_string('receivenewsletter', 'local_scwgeneral'), array('group' => 1), array(0, 1));
            $checkbox->setChecked(true);

            $checkbox = $mform->addElement('advcheckbox', 'receive_email', null, get_string('receivenotification', 'local_scwgeneral'), array('group' => 1), array(0, 1));
            $checkbox->setChecked(true);
        }

		
		$mform->addElement('textarea', 'summary',  get_string('summary', 'local_scwgeneral'),  ' rows="17" cols="100" class="textfield"');
		$strmissingfield = get_string('missingsummary', 'local_scwgeneral');
        $mform->addRule('summary', $strmissingfield, 'required', null, 'client');
        $mform->setType('summary', PARAM_NOTAGS);
		
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('reset', 'cancel', get_string('reset'), array("class" => "btn btn-ash"));
	    $buttonarray[] = &$mform->createElement('submit', 'update', get_string('update'),array("class" => "btn btn-brown"));
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);

    }
    
}


