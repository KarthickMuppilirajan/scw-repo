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
 * @package local-candidates
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');
require_once('lib.php');

/**
 * The form for handling composing email
 */
class mail_compose_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;
		
        $editoroptions = $this->_customdata['editoroptions'];
		$user_id = $this->_customdata['user_id'];
		
		$mform->addElement('hidden','user_id');
		$mform->setType('user_id', PARAM_INT);
		
        // Header

        $label = get_string('compose', 'local_scwmail');
       // $mform->addElement('header', 'general', $label);
        $mform->setType('email', PARAM_TEXT);

// Recipients



		$connected_users = local_scwmail_get_connected_users();                                                         
		$users = array();                                                                                                       
		foreach ($connected_users as $userid=>$user) {                                                                          
			$users[$userid] =  $user->firstname." ".$user->lastname;                                                           
		} 	
		$options = array(                                                                                                           
			'multiple' => true,                                                                                                     
			'noselectionstring' => get_string('to', 'local_scwmail')                                                          
		);         
		$mform->addElement('autocomplete', 'to', get_string('to', 'local_scwmail') , $users, $options);

        $mform->addRule('to', get_string('validate_to','local_scwmail'), 'required', null, 'client');
        $mform->setType('name', PARAM_TEXT);
		if($user_id)
		$mform->setDefault('to',$user_id);

	/*			
		$mform->addElement('text','cc', get_string('cc', 'local_scwmail') );
        $mform->setType('cc', PARAM_TEXT);*/
		$options = array(                                                                                                           
					'multiple' => true,                                                                                                     
					'noselectionstring' => get_string('bcc', 'local_scwmail')                                                          
				);   
		$mform->addElement('autocomplete', 'bcc', get_string('bcc', 'local_scwmail') , $users, $options);
        $mform->setType('bcc', PARAM_TEXT);
		

        // Subject

        $label = get_string('subject', 'local_scwmail');
        $mform->addElement('text', 'subject', $label, 'size="48"');
        $mform->setType('subject', PARAM_TEXT);
        $text = get_string('maximumchars', '', 100);
        $mform->addRule('subject', $text, 'maxlength', 100, 'client');
	   	$mform->addRule('subject', get_string('validate_subject','local_scwmail'), 'required',null, 'client');

        // Content

		 $mform->addElement('editor','message', get_string('message','local_scwmail'), null, $editoroptions);
		 $mform->setType('content', PARAM_RAW);
		 $text = get_string('maximumchars', '', 2500);
		 $mform->addRule('message', $text, 'maxlength', 2500, 'client');
		$mform->addRule('message', get_string('validate_message','local_scwmail'), 'required',null, 'client');	 
		

		
		// When two elements we need a group.
        $buttonarray = array();
        $classarray = array('class' => 'btn btn-brown');
		$buttonarray[] = &$mform->createElement('submit', 'send', get_string('send','local_scwmail'), $classarray);	
        $buttonarray[] = &$mform->createElement('cancel',get_string('cancel','local_scwmail'));
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        

    }

}