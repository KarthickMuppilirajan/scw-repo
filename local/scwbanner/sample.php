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

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');
global $PAGE;

$title = 'SupplyChainWire - Banner List';
$addurl = new moodle_url("/local/scwbanner/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwbanner/admin.php");
$actionurl = new moodle_url("/local/scwbanner/banner_action.php");

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwbanner/admin.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_title($title);
$renderer = $PAGE->get_renderer('local_scwbanner');

$systemcontext = context_system::instance();
$banner = $DB->get_record('local_scwbanner', array('id' => 5));

$fs = get_file_storage();
$files = $fs->get_area_files($systemcontext->id, 'local_scwbanner', 'banner_image', $banner->id,'filename', false);




/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();
?>
<h3>Sample</h3>
<hr/>

<pre><?php print_r($files); ?>

<?php
foreach ($files as $file) {
    $filename = $file->get_filename();
	
    $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(),
                    $file->get_component(), $file->get_filearea(),
                    $file->get_itemid(), $file->get_filepath(), $file->get_filename());
	
	print_r($fileurl);
	$s = $fileurl->__toString();
	echo $s;
}

$user = core_user::get_user(2);
print_r($user);

?>
</pre>

<?php

echo $OUTPUT->footer();