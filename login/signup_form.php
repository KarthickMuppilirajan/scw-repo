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
 * User sign-up form.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot . '/user/editlib.php');
require_once($CFG->libdir.'/completionlib.php');
require_once($CFG->libdir. '/coursecatlib.php');


class login_signup_form extends moodleform implements renderable, templatable {
    function definition() {
        global $USER, $CFG;

         $mform = $this->_form;

      //  $mform->addElement('header', 'register', get_string('register'), '');
	  
	  
	  
	  	$terms_link=new moodle_url('/terms_of_service.php');
		$privacy_link=new moodle_url('/privacy_policy.php');
		
        $mform->addElement('text', 'firstname', get_string('first_name'), 'maxlength="20" class="textfield"');
        $mform->setType('firstname', PARAM_RAW);
        $mform->addRule('firstname', get_string('firstname_required'), 'required', null, 'client');
        $mform->addRule('firstname', get_string('firstname_valid'), 'lettersonly', null, 'client');
				
        $mform->addElement('text', 'middlename', get_string('middle_name'), 'maxlength="20" class="textfield"');
        $mform->setType('middlename', PARAM_RAW);
        $mform->addRule('middlename', get_string('middlename_valid'), 'lettersonly', null, 'client');
	
        $mform->addElement('text', 'lastname', get_string('last_name'), 'maxlength="20" class="textfield"');
        $mform->setType('lastname', PARAM_RAW);
        $mform->addRule('lastname', get_string('lastname_required'), 'required', null, 'client');
        $mform->addRule('lastname', get_string('lastname_valid'), 'lettersonly', null, 'client');
		
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" class="textfield"');
        $mform->setType('email', PARAM_RAW);
        $mform->addRule('email', get_string('email_required'), 'required', null, 'client');
        $mform->addRule('email', get_string('email_valid'), 'email', null, 'client');
		
        $mform->addElement('text', 'confirm_email', get_string('confirm_email'), 'maxlength="100" class="textfield"');
        $mform->setType('confirm_email', PARAM_RAW);
        $mform->addRule('confirm_email', get_string('confirm_email_required'), 'required', null, 'client');
        $mform->addRule('confirm_email', get_string('confirm_email_valid'), 'email', null, 'client');

        $mform->addElement('text', 'phone1', get_string('telephone'), 'maxlength="20" class="textfield"');
		$mform->addHelpButton('phone1', 'telephone');
        $mform->setType('phone1', PARAM_RAW);
        $mform->addRule('phone1', get_string('phone_required'), 'required', null, 'client');
//		$mform->addRule('phone1', get_string('phone_valid'), 'regex', '#^[0-9\.)(+-_ ]+$#', 'client');

        $choices = get_string_manager()->get_list_of_countries();
        //$choices = array('' => get_string('selectacountry') . '...') + $choices;
		$choices = array('GB' =>  'United Kingdom') + $choices;
		$strfield = get_string('countryofcitizen', 'local_scwgeneral');
        $mform->addElement('select', 'country', $strfield, $choices);
		$strmissingfield = get_string('missingcountryofcitizen', 'local_scwgeneral');
		$mform->addRule('country', $strmissingfield, 'required', null, 'client');

		
		$profession=array(''=>'--Select Profession--', '1'=>'Professional','2'=>'Recent graduates');
        $select =  $mform->addElement('select', 'profession', get_string('profession'), $profession);
        $select->setMultiple(false);
        $mform->addRule('profession', get_string('profession_required'), 'required', null, 'client');
		
		if (signup_captcha_enabled()) {
		$mform->addElement('recaptcha', 'recaptcha_element', get_string('security_question', 'auth'), array('https' => $CFG->loginhttps));
		$mform->addHelpButton('recaptcha_element', 'recaptcha', 'auth');
		$mform->closeHeaderBefore('recaptcha_element');
		}
		$disclaimer_link = new moodle_url('/disclaimer.php');
		
		$mform->addElement('html', '<div class="term-policlink">');
		$mform->addElement('html', '<p>By clicking on "Register" below, you are agreeing to the <a href="'.$terms_link.'">Terms of Service</a>, <a href="'.$disclaimer_link.'">Disclaimer</a> and <a href="'.$privacy_link.'">Privacy Policy.</a></p>');
		$mform->addElement('html', '</div>');
		
		
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('reset', 'cancel', get_string('reset'), array("class" => "btn btn-ash"));
	    $buttonarray[] = &$mform->createElement('submit', 'register', get_string('register'),array("class" => "btn btn-brown"));
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');

    }

    function definition_after_data(){
        $mform = $this->_form;
        $mform->applyFilter('username', 'trim');

        // Trim required name fields.
        foreach (useredit_get_required_name_fields() as $field) {
            $mform->applyFilter($field, 'trim');
        }
    }

    function validation($data, $files) {
        global $CFG, $DB;
        $errors = parent::validation($data, $files);
		if (!eregi("^([a-zA-Z][0-9_.]){4,26}$",$username))
		{
		}
         if (empty($data['email'])) {
            $errors['email'] = get_string('email_required');
        } else if (!validate_email($data['email'])) {
            $errors['email'] = get_string('email_valid');
        } else if ($DB->get_record('user', array('email' => $data['email']))) {
            $errors['email'] = get_string('emailexists');
        }  else if ($data['email'] != $data['confirm_email']) {
            $errors['confirm_email'] = get_string('match_email');
        }  else if (empty($data['firstname'])) {
            $errors['firstname'] = get_string('required');
        } else if (empty($data['lastname'])) {
            $errors['lastname'] = get_string('required');
        } else if (!preg_match("/^[0-9\.)(+-_ ]+$/", $data['phone1'])) {
			$errors['phone1'] = get_string('phone_valid');
		} 

		
		if (signup_captcha_enabled()) {
            $recaptcha_element = $this->_form->getElement('recaptcha_element');
            if (!empty($this->_form->_submitValues['recaptcha_challenge_field'])) {
                $challenge_field = $this->_form->_submitValues['recaptcha_challenge_field'];
                $response_field = $this->_form->_submitValues['recaptcha_response_field'];
                if (true !== ($result = $recaptcha_element->verify($challenge_field, $response_field))) {
//                    $errors['recaptcha'] = $result;
					  $errors['recaptcha_element'] = 'Incorrect Captcha, please try again';
                }
            } else {
//                $errors['recaptcha'] = get_string('missingrecaptchachallengefield');
				  $errors['recaptcha_element'] = 'Incorrect Captcha, please try again';
            }
        }
        return $errors;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export.
     * @return array
     */
    public function export_for_template(renderer_base $output) {
        ob_start();
        $this->display();
        $formhtml = ob_get_contents();
        ob_end_clean();
        $context = [
            'formhtml' => $formhtml
        ];
        return $context;
    }
}
