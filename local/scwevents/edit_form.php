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

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

/**
 * The form for handling add/editing a events.
 */
class events_edit_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;		
        $editoroptions = $this->_customdata['editoroptions'];
        $now = new DateTime("now", core_date::get_server_timezone_object());
        $time = $now->getTimestamp();

        $mform->addElement('text', 'event_name', get_string('name', 'local_scwevents'), 'maxlength="100" class="textfield"');
        $mform->setType('event_name', PARAM_TEXT);
        $mform->addRule('event_name', get_string('name_required', 'local_scwevents'), 'required', null, 'client');
		$mform->addRule('event_name', get_string('name_valid', 'local_scwevents'), 'regex', '/^[a-zA-Z0-9 ]+$/', 'client');
		
        // Description

		 $mform->addElement('editor','event_description_editor', get_string('description', 'local_scwevents'), null, $editoroptions);
		 $mform->setType('event_description_editor', PARAM_RAW);
		 $mform->addRule('event_description_editor', get_string('description_required', 'local_scwevents'), 'required',null, 'client');	 

		
		// country
		$countries = local_scwgeneral_get_countries();
		$mform->addElement('select', 'event_country', get_string('country', 'local_scwevents'), $countries);
		$mform->setDefault('event_country', 'GB');
        $mform->addRule('event_country', get_string('state_required', 'local_scwevents'), 'required', null, 'client');
		
		// state
        $mform->addElement('text', 'event_state', get_string('state', 'local_scwevents'), 'maxlength="100" class="textfield"');
        $mform->setType('event_state', PARAM_TEXT);
        $mform->addRule('event_state', get_string('state_required', 'local_scwevents'), 'required', null, 'client');

		
		// city
        $mform->addElement('text', 'event_city', get_string('city', 'local_scwevents'), 'maxlength="100" class="textfield"');
        $mform->setType('event_city', PARAM_TEXT);
        $mform->addRule('event_city', get_string('city_required', 'local_scwevents'), 'required', null, 'client');
		
		// address		
		$mform->addElement('textarea', 'event_address', get_string("address", 'local_scwevents'), 'wrap="virtual" rows="5" cols="5"');
	    $mform->setType('event_address', PARAM_RAW);
		$mform->addRule('event_address', get_string('address_required', 'local_scwevents'), 'required',null, 'client');	 
		
		// start date
        $mform->addElement('date_time_selector', 'event_startdate', get_string("startdate", 'local_scwevents'));
        $mform->addHelpButton('event_startdate', 'datepicker','local_scwevents');
				
		// end date
        $mform->addElement('date_time_selector', 'event_enddate', get_string("enddate", 'local_scwevents'));
        $mform->addHelpButton('event_enddate', 'datepicker','local_scwevents');
		
        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);
		
		
		// share
        $checkbox = $mform->addElement('advcheckbox', 'event_share', get_string('share', 'local_scwevents'), null, array('group' => 1), array(0, 1));			
		$checkbox->setChecked(true);
		
		// status
        $checkbox = $mform->addElement('advcheckbox', 'event_status', get_string('status', 'local_scwevents'), null, array('group' => 1), array(0, 1));			
		$checkbox->setChecked(true);
		

        // When two elements we need a group.
        $buttonarray = array();
        $classarray = array('class' => 'form-submit');

        $buttonarray[] = &$mform->createElement('submit', 'publish', get_string('publish'), $classarray);
        $buttonarray[] = &$mform->createElement('button', 'preview', get_string('preview'), $classarray);
        $buttonarray[] = &$mform->createElement('button', 'clear', get_string('clear'), $classarray);
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        

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
		$sql="select * from {local_scwevents} where id!=".$data['id']." and event_name='".$data['event_name']."' ";
		if ($DB->get_record_sql($sql)) 
        $errors['event_name'] = 'Event name alredy exists';
		else if($data['event_startdate']>$data['event_enddate'])
		$errors['event_enddate']=get_string('valid_enddate', 'local_scwevents');		
        return $errors;
    }
	

}