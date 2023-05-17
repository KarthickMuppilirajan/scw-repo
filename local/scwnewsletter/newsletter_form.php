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
 * @package local-scwnewsletter
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

/**
 * The form for handling composing email
 */
class newsletter_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;
		
		$mform->addElement('text', 'subscriber_name', get_string('subscriber_name', 'local_scwnewsletter'));
		$mform->addRule('subscriber_name', get_string('require_name','local_scwnewsletter'), 'required', null, 'client');
		$mform->setType('subscriber_name', PARAM_RAW);
				
		//$attributes = array('class' => 'form-control');
		$mform->addElement('text', 'subscriber_email', get_string('email', 'local_scwnewsletter'));
		$mform->addRule('subscriber_email', get_string('require_email','local_scwnewsletter'), 'required', null, 'client');
		$mform->addRule('subscriber_email', get_string('validate_email','local_scwnewsletter'), 'email', null, 'client');
		$mform->setType('subscriber_email', PARAM_RAW);

		$terms_link=new moodle_url('/terms_of_service.php');
		$privacy_link=new moodle_url('/privacy_policy.php');
		$disclaimer_link = new moodle_url('/disclaimer.php');
		
		// When two elements we need a group.
		$mform->addElement('html', '<div class="form-group">
              <div class="col-sm-12">
                <div class="checkbox">
                  <label for="rememberusername">By clicking on "Subscribe" below you are agreeing to the <a href="'.$terms_link.'">Terms of Service</a>, <a href="'.$disclaimer_link.'">Disclaimer</a> and <a href="'.$privacy_link.'">Privacy Policy</a> </label>
                </div>
              </div>
            </div>');
		
		$mform->addElement('html', '<div class="form-group">');
		$mform->addElement('html', '<div class="col-sm-12">');
        $buttonarray = array();
        $classarray = array('class' => 'btn btn-brown');
		$buttonarray[] = &$mform->createElement('submit', 'send', get_string('subscribe','local_scwnewsletter'), $classarray);	
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		$mform->addElement('html', '</div></div>');
        

    }

}