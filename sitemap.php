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

require("config.php");
global $PAGE,$USER;

$title = 'Sitemap';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/sitemap.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';


echo $OUTPUT->header();
?>

<div class="contactus-blk">
  <h4><i class="fa fa-sitemap"></i>Sitemap</h4>
  <div class="functionalarea-contnt">
    <div class="row">
      <div class="col-lg-6 padrht-non-prof">
        <div class="functionalarea-lft">
          <div class="functionalarea-details">
            <ul class="functionalarea-detailslist">
              <li><a href="<?php echo $CFG->wwwroot;?>" id="sitemap-home"><i class="fa fa-caret-right"></i>Home</a></li>
              <li><a href="<?php echo new moodle_url('/login/signup.php'); ?>" id="sitemap-register"><i class="fa fa-caret-right"></i>Register</a></li>
              <li><a href="<?php echo new moodle_url('/login/index.php'); ?>" id="sitemap-login"><i class="fa fa-caret-right"></i>Login</a></li>
               <li><a href="<?php echo $CFG->wwwroot.'/local/scwnewsletter/'?>" id="sitemap-newsletter"><i class="fa fa-caret-right"></i>Newsletter</a></li>
               <li><a href="<?php echo new moodle_url('/aboutus.php'); ?>" id="bottomabout-us"><i class="fa fa-caret-right"></i>About Us</a></li>
                <li><a href="<?php echo new moodle_url('/products.php'); ?>" id="bottomproducts"><i class="fa fa-caret-right"></i>Products</a></li>
                <li><a href="<?php echo new moodle_url('/local/scwinterviews/index.php'); ?>" id="bottominterviews"><i class="fa fa-caret-right"></i>Interviews</a></li>
                <li><a href="<?php echo new moodle_url('/local/scwevents/index.php'); ?>" id="bottomevents"><i class="fa fa-caret-right"></i>Events</a></li>
                <li><a href="<?php echo new moodle_url('/local/scwvideos/index.php'); ?>" id="bottomvideos"><i class="fa fa-caret-right"></i>Videos</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-6 padlft-non-prof">
        <div class="functionalarea-rht">
          <div class="functionalarea-details">
            <ul class="functionalarea-detailslist">
              <li><a href="<?php echo new moodle_url('/courses_qualifications.php'); ?>"><i class="fa fa-caret-right"></i>Courses & Qualifications</a></li>
            <li><a href="<?php echo new moodle_url('/book_store.php'); ?>"><i class="fa fa-caret-right"></i>BookStore</a></li>
            <li><a href="<?php echo new moodle_url('/advertisng.php'); ?>"><i class="fa fa-caret-right"></i>Advertising</a></li>
            <li><a href="<?php echo new moodle_url('/memberships.php'); ?>"><i class="fa fa-caret-right"></i>Memberships</a></li>
            <li><a href="<?php echo new moodle_url('/privacy_policy.php'); ?>"><i class="fa fa-caret-right"></i>Privacy Policy</a></li>
            <li><a href="<?php echo new moodle_url('/disclaimer.php'); ?>"><i class="fa fa-caret-right"></i>Disclaimer</a></li>
            <li><a href="<?php echo new moodle_url('/terms_of_service.php'); ?>"><i class="fa fa-caret-right"></i>Terms of Service</a></li>
            <li><a href="<?php echo new moodle_url('/contactus.php'); ?>"><i class="fa fa-caret-right"></i>Contact Us</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
echo $OUTPUT->footer();
