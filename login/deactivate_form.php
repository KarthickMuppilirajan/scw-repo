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
 * Support local plugin.
 *
 * @package    local_support
 * @copyright  2016 Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
if (!defined('MOODLE_INTERNAL')) {
    die ('Direct access to this script is forbidden.');
}
global $PAGE;
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');
require_once($CFG->libdir. '/coursecatlib.php');
class deactivate_form extends moodleform {
    public function definition() {
		global $USER, $CFG;
		$mform = $this->_form;
		
//		$mform->addElement('textarea', 'deactivate_comments', get_string("deactivate_comments"), 'maxlength="1000" wrap="virtual" rows="5" cols="5"');
		$mform->addElement('textarea', 'deactivate_comments', '', 'maxlength="1000" wrap="virtual" rows="5" cols="5"');
	    $mform->setType('deactivate_comments', PARAM_RAW);
	//	$mform->addRule('deactivate_comments', get_string('deactivate_comments_required'), 'required',null, 'client');	 


		$buttonarray = array();
		$buttonarray[] = &$mform->createElement('cancel', 'cancel', get_string('cancel'), array("class" => "btn btn-ash"));
		$buttonarray[] = &$mform->createElement('submit', 'register', get_string('deactivate'),array("class" => "btn btn-brown"));
		$mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
		$mform->closeHeaderBefore('buttonar');
		
		
    }


    public function validation($data, $files) {}
}