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
 * The form for handling editing a banners.
 */
class videos_edit_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;
        $editoroptions = $this->_customdata['editoroptions'];
        $thumboptions = $this->_customdata['thumboptions'];

		$now = new DateTime("now", core_date::get_server_timezone_object());
        $time = $now->getTimestamp();

		$fld = get_string('videoheading', 'local_scwvideos');
		$missingfld = get_string('missingvideoheading', 'local_scwvideos');
        $mform->addElement('text','video_heading', $fld,'size="100"');
        $mform->addRule('video_heading', $missingfld, 'required', null, 'client');
		$mform->addRule('video_heading', get_string('nopunctuation', 'local_scwvideos'), 'nopunctuation', null, 'client');
		$mform->addRule('video_heading', get_string('maximumchars', '', 100), 'maxlength', 100, 'client');
		//nopunctuation
        $mform->setType('video_heading', PARAM_TEXT);
		
        $fld = get_string("videodescription", "local_scwvideos");
        $missingfld = get_string("missingvideodescription", "local_scwvideos");
		$mform->addElement('textarea','video_description', $fld,' rows="7" cols="100" ');
        $mform->addRule('video_description', $missingfld, 'required', null, 'client');
        $mform->setType('banner_company', PARAM_TEXT);


        $fld = get_string('videothumb', 'local_scwvideos');
        $missingfld = get_string('missingvideothumb', 'local_scwvideos');
        $mform->addElement('filemanager', 'video_thumb_filemanager', $fld , null, $thumboptions);
		$mform->addRule('video_thumb_filemanager', $missingfld, 'required', null, 'client');
		
		$mform->addElement('static','video_thumb_static',null,'Images are only accepted');
		
        $mform->addElement('editor', 'video_content_editor', 'Video Content', null, $editoroptions);
		$mform->addRule('video_content_editor', 'Please enter Video content', 'required', null, 'client');
        $mform->setType('video_content_editor', PARAM_RAW);
		
        $preference_orders = array(""=>"Select");
		for($i=1; $i<=100; $i++){
			$preference_orders[$i] = $i;
		}
		$fld = get_string("videoporder", "local_scwvideos");
		$missingfld = get_string("missingvideoporder", "local_scwvideos");
        $mform->addElement('select', 'video_porder', $fld, $preference_orders);
		$mform->addRule('video_porder', $missingfld, 'required', null, 'client');
		
        $checkbox = $mform->addElement('advcheckbox', 'video_status', get_string('videostatusactive', 'local_scwvideos'), null, array('group' => 1), array(0, 1));
		$checkbox->setChecked(true);
		
		$checkbox = $mform->addElement('advcheckbox', 'video_share', get_string('videoshareactive', 'local_scwvideos'), null, array('group' => 1), array(0, 1));
		$checkbox->setChecked(true);
		
        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

        // When two elements we need a group.
        $buttonarray = array();
        $classarray = array('class' => 'form-submit');

        $buttonarray[] = &$mform->createElement('button', 'preview', get_string('preview', 'local_scwvideos'), $classarray);
		$buttonarray[] = &$mform->createElement('submit', 'publish', get_string('publish', 'local_scwvideos'), $classarray);
        $buttonarray[] = &$mform->createElement('button', 'clear', get_string('clear', 'local_scwvideos'), $classarray);
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
        
		// Add field validation check for duplicate shortname.
/*		$videoarr = array('video_delete' => '0',
            'video_porder' => $data['video_porder']
        );
		
        if ($video = $DB->get_record('local_scwvideos', $videoarr , '*', IGNORE_MULTIPLE)) {
            if (empty($data['id']) || $video->id != $data['id']) {
                $errors['video_porder'] = get_string('prioritytaken', 'local_scwvideos', $video->video_heading);
            }
        }*/

		
        return $errors;
    }
	

}