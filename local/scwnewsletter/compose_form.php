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
 * @package local-newsletter
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');


/**
 * The form for handling composing email
 */
class newsletter_compose_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;
		
        $editoroptions = $this->_customdata['editoroptions'];
		
	
        // Header

        $label = get_string('send_newsletter', 'local_scwnewsletter');
       // $mform->addElement('header', 'general', $label);
       // $mform->setType('email', PARAM_TEXT);

		$options = array(
			'1' => 'Professional',
			'2' => 'Graduates',
			'3' => 'Subscribers'
		);
		$select = $mform->addElement('select', 'user_type', get_string('user_type','local_scwnewsletter'), $options);
		$select->setSelected('3');
		$select->setMultiple(true);
		
		$mform->addRule('user_type', get_string('select_usertype','local_scwnewsletter'), 'required',null, 'client');
		$mform->setType('user_type', PARAM_TEXT);
		

        // Subject

        $label = get_string('title', 'local_scwnewsletter');
        $mform->addElement('text', 'subject', $label,'maxlength="100"' );
        $mform->setType('subject', PARAM_TEXT);
	   	$mform->addRule('subject', get_string('validate_title','local_scwnewsletter'), 'required',null, 'client');
		$mform->addRule('subject', get_string('maximumchars', '', 100), 'maxlength', 100, 'client');
//		$mform->addRule('subject', get_string('alphanumeric_err', 'local_scwnewsletter'), 'regex', '^[A-Z0-9 _]*[A-Z0-9][A-Z0-9 _]*$','client');
		
        // Content

		 $mform->addElement('editor','message_editor', get_string('message','local_scwnewsletter'), null, $editoroptions);
		 //$mform->addElement('textarea','message', get_string('message','local_scwnewsletter')," rows='4' cols='100' ");
		 $mform->setType('message_editor', PARAM_RAW);
		 //$text = get_string('maximumchars', '', 2500);
		 //$mform->addRule('message', $text, 'maxlength', 2500, 'client');
		 $mform->addRule('message_editor', get_string('validate_message','local_scwnewsletter'), 'required',null, 'client');	 
		

		
		// When two elements we need a group.
        $buttonarray = array();
        $classarray = array('class' => 'form-submit');
		$buttonarray[] = &$mform->createElement('submit', 'send', get_string('publish','local_scwnewsletter'), $classarray);
    	$buttonarray[] = &$mform->createElement('button', 'preview', get_string('preview'), $classarray);
        $buttonarray[] = &$mform->createElement('button','clear',get_string('clear'));
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        

    }

}