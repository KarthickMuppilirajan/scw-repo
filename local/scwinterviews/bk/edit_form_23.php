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
 * @package local-interviews
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

/**
 * The form for handling editing a candidates.
 */
class scwinterviews_edit_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;
		$summaryoptions = $this->_customdata['summaryoptions'];
		$now = new DateTime("now", core_date::get_server_timezone_object());
        $time = $now->getTimestamp();
		
		$mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text','interview_heading', 'Heading','maxlength="100" size="50"');
        $mform->addRule('interview_heading', get_string('empty_heading', 'local_scwinterviews'), 'required', null, 'client');
		$mform->addRule('interview_heading', get_string('err_maxlength', 'local_scwinterviews', 100), 'maxlength', 100, 'client');
	//	$mform->addRule('interview_heading', get_string('err_lettersonly','local_scwinterviews'), 'lettersonly', null, 'client');
        $mform->setType('interview_heading', PARAM_TEXT);
		
		$mform->addElement('editor', 'summary_editor', get_string('summary_editor', 'local_scwinterviews'), null, $summaryoptions);
 		$mform->setType('summary_editor', PARAM_RAW);
        $mform->addRule('summary_editor', get_string('empty_editor', 'local_scwinterviews'), 'required', null, 'client');
		
		$mform->addElement('text','interview_contact', 'Contact','maxlength="100" size="50"');
        $mform->addRule('interview_contact', get_string('empty_contact', 'local_scwinterviews'), 'required', null, 'client');
		$mform->addRule('interview_contact', get_string('err_maxlength', 'local_scwinterviews', 100), 'maxlength', 100, 'client');
	//	$mform->addRule('interview_contact', get_string('err_lettersonly','local_scwinterviews'), 'lettersonly', null, 'client');
        $mform->setType('interview_contact', PARAM_TEXT);
		
		$mform->addElement('text','interview_company', 'Company','maxlength="100" size="50"');
        $mform->addRule('interview_company', get_string('empty_company', 'local_scwinterviews'), 'required', null, 'client');
		$mform->addRule('interview_company', get_string('err_maxlength', 'local_scwinterviews', 100), 'maxlength', 100, 'client');
	//	$mform->addRule('interview_company', get_string('err_lettersonly','local_scwinterviews'), 'lettersonly', null, 'client');
        $mform->setType('interview_company', PARAM_TEXT);
		
		$priority = array();
		for($i=1; $i<=100; $i++){
			$priority[$i] = $i;
		}
        $mform->addElement('select', 'interview_priority', 'Prioritize', $priority);
		$mform->addRule('interview_priority', get_string('empty_priority', 'local_scwinterviews'), 'required', null, 'client');
		
		$mform->addElement('advcheckbox', 'interview_share', get_string('share', 'local_scwinterviews'), null, array(0, 1));
		$mform->setDefault('interview_share',1);
		//$mform->addRule('share', 'Missing share', 'required', null, 'client');
		
		$mform->addElement('advcheckbox', 'interview_status', get_string('status', 'local_scwinterviews'), null, array(0, 1));	
		$mform->setDefault('interview_status',1);     
		//$mform->addRule('status', 'Missing status', 'required', null, 'client');
		
		$mform->addElement('date_selector', 'interview_expires_by', get_string('to', 'local_scwinterviews'));
		$mform->setType('interview_expires_by', PARAM_INT);
		$mform->setDefault('interview_expires_by', $time + 30 * 3600 * 24);
        $mform->addRule('interview_expires_by', get_string('empty_dateselector', 'local_scwinterviews'), 'required', null, 'client');
		
		$mform->addElement('hidden', 'interview_delete', null);
        $mform->setType('interview_delete', PARAM_INT);

        // When two elements we need a group.
        $buttonarray = array();
        $classarray = array('class' => 'form-submit');
		$classarray2 = array('id'=> 'myBtn', 'data-toggle'=>"modal", 'data-target'=>"#getCodeModal");
		$buttonarray[] = &$mform->createElement('button', 'preview', get_string('preview', 'local_scwinterviews'),$classarray2);
        $buttonarray[] = &$mform->createElement('submit', 'publish', get_string('publish', 'local_scwinterviews'), $classarray);
		$buttonarray[] = &$mform->createElement('reset', 'resetbutton', get_string('revert', 'local_scwinterviews'));
       // $buttonarray[] = &$mform->createElement('cancel');
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
		
		 if ($errorcode = interview_validate_date($data['interview_expires_by'])) {
            $errors['interview_expires_by'] = get_string($errorcode, 'local_scwinterviews');
        }
		
		 // Add field validation check for duplicate shortname.
		$interviewarr = array('interview_delete' => '0' ,'interview_priority' => $data['interview_priority']
        );
		
        if ($interviews = $DB->get_record('local_scwinterviews', $interviewarr , '*', IGNORE_MULTIPLE)) {
            if (empty($data['id']) || $interviews->id != $data['id']) {
                $errors['interview_priority'] = get_string('prioritytaken', 'local_scwinterviews', $interviews->interview_heading);
            }
        }
        return $errors;
    }
	
}