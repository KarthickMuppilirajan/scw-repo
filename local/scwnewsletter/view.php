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
 * @package local-newsletter
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once(dirname(__FILE__) . '/lib.php');
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir.'/completionlib.php');

global $USER;
$site = get_site();
$fullname = $site->fullname;
$syscontext = context_system::instance();
$id = required_param('id',PARAM_INT);

if($id==""){
	$url = $CFG->wwwroot;
	redirect($url);
}

$PAGE->set_context($syscontext);
$PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
$PAGE->navbar->add(get_string('managenewsletter','local_scwnewsletter'),new moodle_url('/local/scwnewsletter/newsletters.php'));
$PAGE->set_pagelayout('admin');
$pageparams = array("id" => $id);
$PAGE->set_url('/local/scwnewsletter/view.php', $pageparams);


$newsletter = $DB->get_record('local_scwnewsletter_messages', array('id' => $id), '*', MUST_EXIST);
$voptions = array('accepted_types' => '*',
    'maxbytes' => $CFG->maxbytes,
    'maxfiles' => EDITOR_UNLIMITED_FILES,
	'trusttext'=>false,
    'noclean'=>true,
);
$voptions['context'] = $syscontext;
$voptions['subdirs'] = file_area_contains_subdirs($syscontext, 'local_scwnewsletter', 'message', $newsletter->id);

$video_content = file_rewrite_pluginfile_urls($newsletter->message, 'pluginfile.php', $syscontext->id, 'local_scwnewsletter', 'message', $newsletter->id);
$video_content = format_text($video_content, $newsletter->message, $voptions, $newsletter->id);

$PAGE->set_title('Newsletter -'.$newsletter->title);
$pagedesc = '';
echo $OUTPUT->header();
//echo $OUTPUT->heading($pagedesc);


?>
<br /> <br />
<div class="row" style="margin-top:20px;">

<div class="col-sm-3 col-md-3 col-lg-2">&nbsp;</div>
<div class="col-sm-6 col-md-6 col-lg-8">
<?php 
$message       = get_string('email_template_view', 'local_scwnewsletter', array("message" => $video_content));
echo $message ; ?></div>
<div class="col-sm-3 col-md-3 col-lg-2">&nbsp;</div>
</div>

<?php

echo $OUTPUT->footer();


