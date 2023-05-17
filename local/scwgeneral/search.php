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
$PAGE->requires->js('/lib/cookies.js');
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
<h4><i class="fa fa-search"></i>SEARCH</h4>
<div class="search-blk-fields">
<form>
<div class="form-group col-lg-2"> <label for="searchprof">Search Profession</label>
<select class="form-control"> <option>--Select--</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select> </div>
<div class="form-group col-lg-2"> <label for="searchprof">Search By Country</label>
<select class="form-control"> <option>--Select--</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select> </div>
<div class="form-group col-lg-2"> <label for="searchprof">Search By Industry</label>
<select class="form-control"> <option>--Select--</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select> </div>
<div class="form-group col-lg-2"> <label for="searchprof">Search By Functionl Area</label>
<select class="form-control"> <option>--Select--</option> <option>2</option> <option>3</option> <option>4</option> <option>5</option> </select> </div>
<div class="pull-right searchrst-btns">
<button class="btn btn-brown">SEARCH</button>
<button class="btn btn-ash">RESET</button>
</div>
</form>
</div>
</div>

<div class="search-result-blk">
<h4><i class="fa fa-star"></i>SEARCH RESULTS</h4>

<div class="searhvalue-contnt">
<div class="row">
<div class="col-lg-6 padrht-non-prof">
<div class="searcharea-lft">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
</div>
</div>
<div class="col-lg-6 padlft-non-prof">
<div class="searcharea-rht">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
<img class="img-responsive contntbtm-border" src="<?php echo $turl; ?>/border.png">
<div class="searhvalue-contnt-details">
<div class="row">
<div class="col-sm-5 col-md-5 col-lg-3">
<div class="img-transparency">
<img class="img-responsive" src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-7 col-md-7 col-lg-9">
<div class="searhvalue-contnt-title">
<div class="row">
<div class="col-md-7 col-lg-8 padlft-non">
<h5>Lorem Ipsum simply</h5>
<h6>Company Name</h6>
</div>
<div class="col-md-5 col-lg-4">
<div class="btn-group">
<button class="btn btn-sm btn-ashblk pull-right">Connect</button>
</div>
<div class="btn-group">
<button class="btn btn-sm btn-eye pull-right"><i class="fa fa-eye"></i></button>
</div>
</div>
</div>
<img class="img-responsive" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor 
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis nostrdud
incididunt ut labore et dolore magna aliqua. Ut enihm ad minim veniam, quis dud 
exercitation ullamco laboris nisi ut aliqu.</p>
</div>
</div>
</div>
</div>
</div>


</div>
<div class="searchreslt-pagination">
<ul class="pagination"> <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> <li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li> <li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> </ul>
</div>

</div>

<?php
echo $OUTPUT->footer(); ?>

<script type="text/javascript">
var a = new cookie("enablescwcookie", 'yes', 365, "/scw-vk/supplychainwire/moodle/","localhost");
var ecv = a.read();
if(ecv === null || ecv === undefined){
	a.set();
}
alert('s'+ecv);

</script>