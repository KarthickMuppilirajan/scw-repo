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
 * Activity modules block caps.
 *
 * @package    Role set files
 * @copyright  Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('config.php');

require_once($CFG->dirroot . '/user/editlib.php');
require_once($CFG->libdir . '/authlib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/roles/lib.php');
require_once($CFG->dirroot.'/lib/accesslib.php');

// scwadmin - manager , scwsales - coursecreator

// Create SCW Admin role

$role_record = $DB->get_record('role', array ('shortname' => 'scwadmin'));
if(empty($role_record))
{
	$professional_roleid = create_role('SCW Admin', 'scwadmin', 'Role created with arch type manager', 'manager');
	$contextlevels[10] = 10;
	set_role_contextlevels($professional_roleid, $contextlevels);	
}

// Create SCW Sales role

$role_record = $DB->get_record('role', array ('shortname' => 'scwsales'));
if(empty($role_record))
{
	$professional_roleid = create_role('SCW Sales', 'scwsales', 'Role created with arch type coursecreator', 'coursecreator');
	$contextlevels[10] = 10;
	set_role_contextlevels($professional_roleid, $contextlevels);	
}



