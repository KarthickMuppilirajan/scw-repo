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
    $page = new admin_settingpage('scwgeneral', get_string('pluginnameheading', 'local_scwgeneral'));
    
	// General pages Settings.
    $label = get_string('industry_label', 'local_scwgeneral');
    $desc = get_string('industry_description', 'local_scwgeneral');
    $default = get_string('industry_default', 'local_scwgeneral');
    $page->add(new admin_setting_configtextarea('local_scwgeneral/industry', $label, $desc , $default ));
	
	// Functional area Settings.
    $label = get_string('farea_label', 'local_scwgeneral');
    $desc = get_string('farea_description', 'local_scwgeneral');
    $default = get_string('farea_default', 'local_scwgeneral');
    $page->add(new admin_setting_configtextarea('local_scwgeneral/farea', $label, $desc , $default ));
	
	// Search pagination  Settings.
    $label = get_string('paging_search_display', 'local_scwgeneral');
    $desc = get_string('paging_search_desc', 'local_scwgeneral');
    $default = 10;
    $page->add(new admin_setting_configtext('local_scwgeneral/searchpaging', $label, $desc , $default));
	
    $name = 'local_scwgeneral/gakey';
    $title = get_string('gakey', 'local_scwgeneral');
    $description = get_string('gakey_desc', 'local_scwgeneral');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $page->add($setting);

    $ADMIN->add('localplugins', $page);
	
}
