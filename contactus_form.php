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
 * @package local-scwbanner
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir.'/formslib.php');

class contactus_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;		
        $now = new DateTime("now", core_date::get_server_timezone_object());
        $time = $now->getTimestamp();		
		
        $mform->addElement('text', 'firstname', get_string('first_name'), 'maxlength="20" class="textfield"');
        $mform->setType('firstname', PARAM_RAW);
        $mform->addRule('firstname', get_string('firstname_required'), 'required', null, 'client');
//        $mform->addRule('firstname', get_string('firstname_valid'), 'lettersonly', null, 'client');
				
        $mform->addElement('text', 'lastname', get_string('last_name'), 'maxlength="20" class="textfield"');
        $mform->setType('lastname', PARAM_RAW);
        $mform->addRule('lastname', get_string('lastname_required'), 'required', null, 'client');
  //      $mform->addRule('lastname', get_string('lastname_valid'), 'lettersonly', null, 'client');
		
		// registered status
		$radioarray=array();
		$radioarray[] = $mform->createElement('radio', 'registered', '', get_string('yes'), 1);
		$radioarray[] = $mform->createElement('radio', 'registered', '', get_string('no'), 0);
		$mform->addGroup($radioarray, 'radioar', get_string('registered_status'), array(' '), false);
		$mform->setDefault('registered', 0);
		
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" class="textfield"');
        $mform->setType('email', PARAM_RAW);
        $mform->addRule('email', get_string('email_required'), 'required', null, 'client');
        $mform->addRule('email', get_string('email_valid'), 'email', null, 'client');
		
				// country
		$countries = local_scwgeneral_get_countries();
		$mform->addElement('select', 'country', get_string('country', 'local_scwevents'), $countries);
		$mform->setDefault('country', 'GB');
        $mform->addRule('country', get_string('country_required'), 'required', null, 'client');
		
				// message		
		$mform->addElement('textarea', 'message', get_string("message"), 'wrap="virtual" rows="5" cols="5"');
	    $mform->setType('message', PARAM_RAW);
		$mform->addRule('message', get_string('message_required'), 'required',null, 'client');	 
		
        $buttonarray = array();
	    $buttonarray[] = &$mform->createElement('submit', 'send', get_string('send'),array("class" => "btn btn-brown"));
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');


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

        return $errors;
    }
	

}
