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
class banners_edit_form extends moodleform {

    /**
     * Form definition.
     */
    function definition() {
        global $CFG, $PAGE;

        $mform = $this->_form;
        $editoroptions = $this->_customdata['editoroptions'];
        $alpages = local_scwbanner_page_options();
		$now = new DateTime("now", core_date::get_server_timezone_object());
        $time = $now->getTimestamp();

        $mform->addElement('text','banner_name', 'Name','size="50"');
        $mform->addRule('banner_name', 'Missing Name', 'required', null, 'client');
		$mform->addRule('banner_name', 'You must enter no punctuation characters here', 'nopunctuation', null, 'client');
		$mform->addRule('banner_name', get_string('maximumchars', '', 50), 'maxlength', 50, 'client');
		//nopunctuation
        $mform->setType('banner_name', PARAM_TEXT);
		
		$mform->addElement('text','banner_company', 'Company','size="50"');
        $mform->addRule('banner_company', 'Missing Company', 'required', null, 'client');
		$mform->addRule('banner_company', get_string('maximumchars', '', 50), 'maxlength', 50, 'client');
		$mform->addRule('banner_company', 'You must enter no punctuation characters here', 'nopunctuation', null, 'client');
        $mform->setType('banner_company', PARAM_TEXT);

        $mform->addElement('text','banner_contact', 'Contact','size="50"');
		$mform->addRule('banner_contact', 'Missing Contact', 'required', null, 'client');
		$mform->addRule('banner_contact', get_string('maximumchars', '', 100), 'maxlength', 100, 'client');
        $mform->setType('banner_contact', PARAM_TEXT);

        $mform->addElement('date_selector', 'banner_expires_by', 'Expires By');
		$mform->setType('banner_expires_by', PARAM_INT);
		$mform->setDefault('banner_expires_by', $time + 30 * 3600 * 24);
		$mform->addRule('banner_expires_by', 'Missing Expires By', 'required', null, 'server');
		
        $mform->addElement('select', 'banner_page', 'Page', $alpages);
        $mform->addRule('banner_page', 'Missing Banner page', 'required', null, 'client');
		
        $positions = array("top" => "Top", "bottom" => "Bottom",
                "left" => "Left", "right1" => "Right 1", "right2" => "Right 2",
                "right3" => "Right 3");

        $select =  $mform->addElement('select', 'banner_position', 'Banner Position', $positions);
		$mform->addRule('banner_position', 'Missing Banner position', 'required', null, 'client');
		
		$mform->addElement('static', 'bannerdescription', null,'Please look the below image. It\'s mentioned the image height and width for banner position.');
		
		$mform->addElement('html', '<div class="fitem fitem_ftext" id="banner-size-images">');
		$mform->addElement('html', '<div class="fitemtitle">&nbsp;</div>');
		$mform->addElement('html', '<div class="felement ftext">');
		$mform->addElement('html', '<img src="" id="banner-size-img" class="img-responsive">');
		$mform->addElement('html', '</div>');
		$mform->addElement('html', '</div>');
		
		$mform->addElement('text','banner_caption', 'Caption','maxlength="200" size="50"');
        $mform->setType('banner_caption', PARAM_TEXT);
		$mform->addRule('banner_caption', 'You must enter no punctuation characters here', 'nopunctuation', null, 'client');
		$mform->addRule('banner_caption', get_string('maximumchars', '', 50), 'maxlength', 50, 'client');

        $mform->addElement('filemanager', 'banner_image', 'Attachment' , null, array('maxbytes' => $CFG->maxbytes, 'accepted_types' => '*', 'maxfiles' => 1));
		$mform->addRule('banner_image', 'Missing Attachment', 'required', null, 'client');
		
		$mform->addElement('text','banner_url', 'URL Link','maxlength="200" size="100"');
		$mform->addRule('banner_url', 'Please enter valid URL Link', 'regex', 
			  '/^(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/', 'client');
			
		$mform->addElement('static', 'static_banner_url',null, 'Please enter URL Link like this http://example.com or http://www.example.com');
			
        $mform->setType('banner_url', PARAM_RAW);
		
		
        $preference_orders = array(""=>"Select");
		for($i=1; $i<=100; $i++){
			$preference_orders[$i] = $i;
		}
        $mform->addElement('select', 'banner_porder', 'Preference Orders', $preference_orders);
		$mform->addRule('banner_porder', 'Missing preference orders', 'required', null, 'client');
		
        $checkbox = $mform->addElement('advcheckbox', 'banner_status', get_string('banner_status_active', 'local_scwbanner'), null, array('group' => 1), array(0, 1));			
		$checkbox->setChecked(true);
		
        $mform->addElement('hidden', 'id', null);
        $mform->setType('id', PARAM_INT);

        // When two elements we need a group.
        $buttonarray = array();
        $classarray = array('class' => 'form-submit');

        $buttonarray[] = &$mform->createElement('submit', 'saveanddisplay', get_string('savechangesanddisplay'), $classarray);
        $buttonarray[] = &$mform->createElement('button','clear','Clear');
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
        
        if ($errorcode = banner_validate_date($data['banner_expires_by'])) {
            $errors['banner_expires_by'] = get_string($errorcode, 'local_scwbanner');
        }

		 // Add field validation check for duplicate shortname.
		/*$bannerarr = array('banner_delete' => '0' ,'banner_porder' => $data['banner_porder'],
            'banner_position' => $data['banner_position'],
			'banner_page' => $data['banner_page'],
        );
		
        if ($banner = $DB->get_record('local_scwbanner', $bannerarr , '*', IGNORE_MULTIPLE)) {
            if (empty($data['id']) || $banner->id != $data['id']) {
                $errors['banner_porder'] = get_string('prioritytaken', 'local_scwbanner', $banner->banner_name);
            }
        }*/

		
        return $errors;
    }
	

}