<?php
// This file is part of the custom Moodle Bootstrap theme
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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_supplychainwire
 * @copyright  2017 Fourbends Dev Team, www.fourbends.com
 * @authors    Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$THEME->doctype = 'html5';
$THEME->yuicssmodules = array();
$THEME->name = 'supplychainwire';
$THEME->parents = array('bootstrap');

$THEME->sheets = array('moodle');
$THEME->sheets[] = 'fontawesome';
$THEME->sheets[] = 'supplychainwire';
$THEME->sheets[] = 'custom';

$THEME->enable_dock = false;
$THEME->supportscssoptimisation = false;

$THEME->rendererfactory = 'theme_overridden_renderer_factory';

$THEME->layouts = array(
    // Main course page.
    'course' => array(
        'file' => 'default.php',
        'regions' => array('side-pre', 'side-post', 'scw-left', 'scw-right', 'scw-top', 'scw-bottom'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true),
    ),
    'coursecategory' => array(
        'file' => 'default.php',
        'regions' => array('side-pre', 'side-post', 'scw-left', 'scw-right', 'scw-top', 'scw-bottom'),
        'defaultregion' => 'side-pre',
    ),
    // The site home page.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array('side-pre', 'side-post', 'scw-left', 'scw-right', 'scw-top', 'scw-bottom'),
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    ),
	// Server administration scripts.
    'admin' => array(
        'file' => 'default.php',
        'regions' => array('side-pre', 'side-post', 'scw-left', 'scw-right', 'scw-top', 'scw-bottom'),
        'defaultregion' => 'side-pre',
        'options' => array('fluid' => true),
    ),
	'login' => array(
        'file' => 'login.php',
        'regions' => array('side-pre', 'side-post', 'scw-left', 'scw-right', 'scw-top', 'scw-bottom'),
		'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    ),
	// Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'default.php',
        'regions' => array('side-pre', 'side-post', 'scw-left', 'scw-right', 'scw-top', 'scw-bottom'),
        'defaultregion' => 'scw-left',
    ),
	// My dashboard page.
    'mydashboard' => array(
        'file' => 'dashboard.php',
        'regions' => array('side-pre', 'side-post', 'scw-left', 'scw-right', 'scw-top', 'scw-bottom'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true),
    ),
	 // The site default page.
    'scwpage' => array(
        'file' => 'scwpage.php',
        'regions' => array('side-pre', 'side-post', 'scw-left', 'scw-right', 'scw-top', 'scw-bottom'),
        'defaultregion' => 'side-pre',
        'options' => array('nonavbar' => true),
    ),
);

//$THEME->javascripts_footer = array('jquery-3.1.1.min', 'custom');