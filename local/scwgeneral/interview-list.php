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
global $PAGE,$USER;

$title = 'Subscription';
$addurl = new moodle_url("/local/scwbanner/edit.php", array("id" => 0) );
$searchurl = new moodle_url("/local/scwbanner/admin.php");
$actionurl = new moodle_url("/local/scwbanner/banner_action.php");
$now = new DateTime("now", core_date::get_server_timezone_object());
$time = $now->getTimestamp();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/scwbanner/admin.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';

/**
 * // $PAGE->set_heading($title);
 */
echo $OUTPUT->header();
?>
<div class="search-blk">
<h4><i class="fa fa-search"></i>INTERVIEW LIST</h4>
<div class="interviewsearch-fileld">
<form class="form-inline"> <div class="form-group"> <label for="exampleInputName2">Interview</label> <input class="form-control" id="exampleInputName2" placeholder="
"> </div> 
<button class="btn btn-brown">SEARCH</button> </form>
</div>
</div>
<div class="interviewlst-blk">
<h4><i class="fa fa-users"></i>INTERVIEWS</h4>
<div class="interviewdetail-list">
<div class="interviewlst-titl-head">
<div class="interviewlst-titl col-lg-10"> 
<h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum Lorem Ipsum is simply </h3>
</div>
<div class="col-lg-2 ">
<button class="btn btn-sm btn-ashblk pull-right">View More</button>
</div>
</div>
<div class="interviewlst-contnt-details">
<div class="row">
<div class="col-sm-2 col-md-2 col-lg-1">
<div class="img-transparency">
<img src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-10 col-md-10 col-lg-11">
<div class="interviewlst-contnt-title">
<div class="row">
<div class="col-md-12 col-lg-12 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
</div>
<img class="titlebtm-bordr" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="contntbtm-border" src="<?php echo $turl; ?>/border.png">
</div>
<div class="interviewdetail-list">
<div class="interviewlst-titl-head">
<div class="interviewlst-titl col-lg-10"> 
<h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum Lorem Ipsum is simply </h3>
</div>
<div class="col-lg-2 ">
<button class="btn btn-sm btn-ashblk pull-right">View More</button>
</div>
</div>
<div class="interviewlst-contnt-details">
<div class="row">
<div class="col-sm-2 col-md-2 col-lg-1">
<div class="img-transparency">
<img src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-10 col-md-10 col-lg-11">
<div class="interviewlst-contnt-title">
<div class="row">
<div class="col-md-12 col-lg-12 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
</div>
<img class="titlebtm-bordr" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="contntbtm-border" src="<?php echo $turl; ?>/border.png">
</div>
<div class="interviewdetail-list">
<div class="interviewlst-titl-head">
<div class="interviewlst-titl col-lg-10"> 
<h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum Lorem Ipsum is simply </h3>
</div>
<div class="col-lg-2 ">
<button class="btn btn-sm btn-ashblk pull-right">View More</button>
</div>
</div>
<div class="interviewlst-contnt-details">
<div class="row">
<div class="col-sm-2 col-md-2 col-lg-1">
<div class="img-transparency">
<img src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-10 col-md-10 col-lg-11">
<div class="interviewlst-contnt-title">
<div class="row">
<div class="col-md-12 col-lg-12 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
</div>
<img class="titlebtm-bordr" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="contntbtm-border" src="<?php echo $turl; ?>/border.png">
</div>
<div class="searchreslt-pagination">
<ul class="pagination"> <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> <li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li> <li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> </ul>
</div>
</div>

<?php
echo $OUTPUT->footer();