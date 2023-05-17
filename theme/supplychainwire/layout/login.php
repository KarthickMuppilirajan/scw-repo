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
 * The one column layout.
 *
 * @package   theme_eguru
 * @copyright 2015 LMSACE Dev Team,lmsace.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (isloggedin() && !isguestuser()) {
    redirect ($CFG->wwwroot);
}

$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);

$knownregionpre = $PAGE->blocks->is_known_region('side-pre');
$knownregionpost = $PAGE->blocks->is_known_region('side-post');
$kregscwleft = $PAGE->blocks->is_known_region('scw-left');
$kregscwright = $PAGE->blocks->is_known_region('scw-right');
$turl = $CFG->wwwroot."/theme/supplychainwire";

echo $OUTPUT->doctype(); ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title> SCW - Connect to supply chain professionals globally for business networking, marketing services and product promotion - <?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
<?php include_once(dirname(__FILE__) ."/includes/analyticstracking.php") ?>
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<?php  require_once(dirname(__FILE__) . '/includes/header.php');  ?>

<aside class="col-sm-3 col-md-3 col-lg-2">
<?php 
if($kregscwleft){
    echo $OUTPUT->blocks_for_region('scw-left'); 
}

require_once(dirname(__FILE__) . '/includes/left-banner.php');  

if ($knownregionpre && is_siteadmin()) {
   // echo $OUTPUT->blocks_for_region('side-pre');
}
?>		
		
</aside>

<article class="col-sm-6 col-md-6 col-lg-8">
<?php echo $OUTPUT->main_content();  ?>
</article>

<aside class="col-sm-3 col-md-3 col-lg-2">		 
        <?php  require_once(dirname(__FILE__) . '/includes/right-banners.php');  ?>
		<?php
        if ($knownregionpost && is_siteadmin()) {
           // echo $OUTPUT->blocks_for_region('side-post');
        }?>
</aside>

<?php  require_once(dirname(__FILE__) . '/includes/footer.php');  ?>
</body>
</html>
