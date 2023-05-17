<?php
// This file is part of The Bootstrap Moodle theme
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

require_once($CFG->dirroot.'/local/scwgeneral/lib.php');

$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);

$knownregionpre = $PAGE->blocks->is_known_region('side-pre');
$knownregionpost = $PAGE->blocks->is_known_region('side-post');
$kregscwleft = $PAGE->blocks->is_known_region('scw-left');
$kregscwright = $PAGE->blocks->is_known_region('scw-right');


$regions = scw_grid($hassidepre, $hassidepost);
$turl = $CFG->wwwroot."/theme/supplychainwire";
$countries = get_string_manager()->get_list_of_countries(true);
$scountries = '';
foreach($countries as $ccode => $cname){
    $scountries .= '<option value="'.$ccode.'">'.$cname.'</option>';
}

echo $OUTPUT->doctype(); ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
<title>SCW - Connect to supply chain professionals globally for business networking, marketing services and product promotion - <?php echo $PAGE->title ?></title>
<link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
<?php echo $OUTPUT->standard_head_html() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
  <div style="display:none;">
    <?php
            echo $OUTPUT->main_content();
            ?>
  </div>
  <div class="search-blk">
    <h4><i class="fa fa-search"></i>SEARCH</h4>
    <div class="search-blk-fields">
      <form action="<?php echo $CFG->wwwroot;?>/local/mylinks/search.php">
        <div class="form-group col-lg-2" id="profession-gp">
          <label for="searchprof">Search Profession</label>
          <select class="form-control" name="profession" id="profession" required>
            <option value="">--Select Profession--</option>
            <option value="1">Professional</option>
            <option value="2">Recent Graduates</option>
          </select>
        </div>
        <div class="form-group col-lg-2" id="country-gp">
          <label for="searchprof">Search By Country</label>
          <?php echo local_scwgeneral_get_countries(2); ?> </div>
        <div class="form-group col-lg-2" id="industry-gp">
          <label for="searchprof">Search By Industry</label>
          <?php echo local_scwgeneral_get_industry(2); ?> </div>
        <div class="form-group col-lg-3" id="functionalarea-gp">
          <label for="searchprof">Search By Functional Area</label>
          <?php echo local_scwgeneral_get_farea(2); ?> </div>
        <div class="pull-right searchrst-btns">
          <button class="btn btn-brown" type="submit">SEARCH</button>
          <button class="btn btn-ash" type="reset">RESET</button>
        </div>
      </form>
    </div>
  </div>
  
  <?php echo local_scwgeneral_front_farea(); ?>

  </article>
<aside class="col-sm-3 col-md-3 col-lg-2">
  <?php  require_once(dirname(__FILE__) . '/includes/right-banners.php');  ?>
  <?php
        if ($knownregionpost && is_siteadmin()) {
          //  echo $OUTPUT->blocks_for_region('side-post');
        }?>
</aside>
<?php  require_once(dirname(__FILE__) . '/includes/footer.php');  ?>
</body>
</html>