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
global $CFG,$PAGE,$USER;
require_login();
$title = 'Flush Site Data';
$cond = (local_scwgeneral_check_scwsales() || local_scwgeneral_check_scwadmin());
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('scwpage');
if(!$cond){
	$etitle = get_string('accessdenied','admin');
	$emessage = 'You can\'t flush site data.';
	$slogo = $CFG->wwwroot.'/theme/supplychainwire/pix/logo-small.png';
	echo $OUTPUT->header();
	echo $OUTPUT->render_from_template('local_scwgeneral/error', ['title' => $etitle, 'message' => $emessage ,
    'slogo' => $slogo
	]);
	echo $OUTPUT->footer();
	exit;
}


$PAGE->set_url('/local/scwgeneral/site-flush.php');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';

/**
 * // $PAGE->set_heading($title);
 */
 
echo $OUTPUT->header();
?>
<div id="page-navbar" class="clearfix">
   <span class="accesshide" id="navbar-label">Page path</span>
  <nav aria-labelledby="navbar-label" aria-label="breadcrumb" class="breadcrumb-nav" role="navigation">
  <ul class="breadcrumb">
			<li><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
			<a itemprop="url" href="<?php echo new moodle_url("/"); ?>"><span itemprop="title">Home</span></a>
			</span></li>
			<li><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
			<a itemprop="url" href="<?php echo new moodle_url("/my"); ?>"><span itemprop="title">Dashboard</span></a></span>
			</li>
			<li><span tabindex="0">Site Data Flush</span></li>
			</ul>
			</nav>            
		<div class="breadcrumb-button"></div>
</div>
		
<div class="interviewlstdetail-blk">
<div class="interviewlst-title clearfix">
<div class="col-sm-10 col-md-10 col-lg-10"> 
<h4 class="mar-top5"><i class="fa fa-users"></i>Site Data Flush</h4>
</div>
</div>

<div class="interviewlst-detaials">

<p><strong>Are You sure, You want to clear all data from your site.<strong></p>
<br/>
<br/>
<form action="<?php echo new moodle_url("/local/scwgeneral/site-flush-confirm.php"); ?>" method="post" accept-charset="utf-8" id="mform1" class="mform">
<div id="fgroup_id_buttonar" class="fitem fitem_fgroup femptylabel"><div class="fitemtitle"><div class="fgrouplabel"><label>
 </label></div></div><fieldset class="felement fgroup" data-fieldtype="group">
 <input class="form-submit" name="yes_flush" value="Yes" type="submit" id="id_yes_flush"> 
 <input class="form-submit" name="no_flush" value="No" type="button" id="id_no_flush">
 <input type="hidden" name="flush_confirm" value="yes">
 <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>">
 </fieldset></div>
</form>

</div>

</div>


<?php
echo $OUTPUT->footer();
?>
<script type="text/javascript">
require(['jquery','theme_bootstrap/bootstrap'], function( $ ) {

  $("#page-local-scwgeneral-site-flush").removeClass("layout-option-nonavbar");
	
  $( "#id_no_flush" ).click(function() {
	 var url = M.cfg.wwwroot+'/my';
	 $(location).attr("href", url);
  });
});
</script>