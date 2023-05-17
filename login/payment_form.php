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
class payment_form extends moodleform {
    public function definition() {
        global $CFG, $USER, $COURSE;
		$random_url = optional_param('random_url', false, PARAM_RAW);
        $mform = $this->_form;
//        $mform->addElement('header', 'subscription', get_string('subscription'));
		$data= new stdClass();
		$data->amount =  '50.00';
    	$message = get_string('payment_content_recent_graduates', '', $data);
		$mform->addElement('header', 'subscription', $message);
        $mform->addElement('hidden', 'random_url',$random_url);
        $mform->setType('random_url', PARAM_RAW);
        $mform->addElement('submit', 'pay', get_string('pay'));
    }


    public function validation($data, $files) {}
}