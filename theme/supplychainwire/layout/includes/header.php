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
 * The maintenance layout.
 *
 * @package   theme_supplychainwire
 * @copyright 2017 Fourbends Dev Team, fourbends.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
theme_supplychainwire_check_profile();
?>
<header>
  <nav>
    <div class="navbar-block" data-example-id="default-navbar">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a href="<?php echo $CFG->wwwroot;?>" class="navbar-brand"><img src="<?php echo $turl; ?>/pix/logo.png"></a> </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo $CFG->wwwroot;?>" id="tophome">Home</a></li>
			  <?php 
if (isloggedin() and !isguestuser()) {
        echo $OUTPUT->user_menu();
}else {
?>
              <li><a href="<?php echo $CFG->wwwroot.'/local/scwnewsletter/'?>" id="newsletter">Newsletter</a></li>
              <li><a href="<?php echo new moodle_url('/login/signup.php'); ?>" id="register">Register</a></li>
              <li><a href="<?php echo new moodle_url('/login/index.php'); ?>" id="login"><?php echo get_string("login"); ?></a></li>
<?php } ?>			  
              <li class="dropdown"> <a href="javascript:void(0);" id="extmenulink" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span><span class="glyphicon glyphicon-menu-hamburger"></span></a>
                <ul class="dropdown-menu" id="extmenu">
                  <li><a href="<?php echo new moodle_url('/aboutus.php'); ?>">About Us</a></li>
                  <li><a href="<?php echo new moodle_url('/products.php'); ?>">Products</a></li>
                  <li><a href="<?php echo new moodle_url('/local/scwinterviews/index.php'); ?>" id="topinterviews">Interviews</a></li>
                  <li><a href="<?php echo new moodle_url('/local/scwevents/index.php'); ?>" id="topevents">Events</a></li>
                  <li><a href="<?php echo new moodle_url('/local/scwvideos/index.php'); ?>" id="topvideos">Videos</a></li>
                  <li><a href="<?php echo new moodle_url('/courses_qualifications.php'); ?>">Courses</a></li>
                  <li><a href="<?php echo new moodle_url('/book_store.php'); ?>">Bookstore</a></li>
                  <li><a href="<?php echo new moodle_url('/contactus.php'); ?>">Contact Us</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </nav>
</header>

<?php echo $OUTPUT->scw_top_banners(); ?>


<section class="scw-sections">
<div class="container-fluid">
<div class="row">