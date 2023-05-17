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
 * Local plugin "scwbanner" - Settings
 *
 * @package     local
 * @subpackage  local_scwbanner
 * @copyright   2017 onwards Fourbends Dev Team (http://www.fourbends.com/)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // New settings page.
    $page = new admin_settingpage('scwbanner', get_string('pluginnameheading', 'local_scwbanner'));
    
	// Banner pages Settings.
	
    /*$label = get_string('bannerpages_label', 'local_scwbanner');
    $desc = get_string('bannerpages_description', 'local_scwbanner');
    $default = get_string('bannerpages_default', 'local_scwbanner');
    $page->add(new admin_setting_configtextarea('local_scwbanner/bannerpages', $label, $desc , $default )); */

	$boptions = array();
	for($i=1; $i<=10; $i++){
        $boptions[$i] = $i;
	}
    // Page Top no of banner display.
    $label = get_string('topbanner_no_label', 'local_scwbanner');
    $desc = get_string('topbanner_no_desc', 'local_scwbanner');
    $default = '5';
    $page->add(new admin_setting_configselect('local_scwbanner/top_no_banner', $label, $desc, $default, $boptions));

    // Page Left no of banner display.
    $label = get_string('leftbanner_no_label', 'local_scwbanner');
    $desc = get_string('leftbanner_no_desc', 'local_scwbanner');
    $default = '5';
    $page->add(new admin_setting_configselect('local_scwbanner/left_no_banner', $label, $desc, $default, $boptions));

    // Page Right 1 no of banner display.
    $label = get_string('right1banner_no_label', 'local_scwbanner');
    $desc = get_string('right1banner_no_desc', 'local_scwbanner');
    $default = '5';
    $page->add(new admin_setting_configselect('local_scwbanner/right1_no_banner', $label, $desc, $default, $boptions));

    // Page Right 2 no of banner display.
    $label = get_string('right2banner_no_label', 'local_scwbanner');
    $desc = get_string('right2banner_no_desc', 'local_scwbanner');
    $default = '5';
    $page->add(new admin_setting_configselect('local_scwbanner/right2_no_banner', $label, $desc, $default, $boptions));

    // Page Right 3 no of banner display.
    $label = get_string('right3banner_no_label', 'local_scwbanner');
    $desc = get_string('right3banner_no_desc', 'local_scwbanner');
    $default = '5';
    $page->add(new admin_setting_configselect('local_scwbanner/right3_no_banner', $label, $desc, $default, $boptions));

    // Page Bottom no of banner display.
    $label = get_string('bottombanner_no_label', 'local_scwbanner');
    $desc = get_string('bottombanner_no_desc', 'local_scwbanner');
    $default = '5';
    $page->add(new admin_setting_configselect('local_scwbanner/bottom_no_banner', $label, $desc, $default, $boptions));

    $ADMIN->add('localplugins', $page);
	
}
