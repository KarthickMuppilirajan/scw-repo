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
?>

  </div>
 </div>
</section>
<footer>
<?php  echo $OUTPUT->scw_left_right_banner('bottom','footer-banner'); ?>
<div class="footer-blk">
<div class="container-fluid">
<div class="row">
<div class="col-lg-9">
<ul class="footerlinks clearfix">
<li><a href="<?php echo $CFG->wwwroot;?>" id="bottomhome">Home</a></li>
<li><a href="<?php echo new moodle_url('/aboutus.php'); ?>" id="bottomabout-us">About Us</a></li>
<li><a href="<?php echo new moodle_url('/products.php'); ?>" id="bottomproducts">Products</a></li>
<li><a href="<?php echo new moodle_url('/local/scwinterviews/index.php'); ?>" id="bottominterviews">Interviews</a></li>
<li><a href="<?php echo new moodle_url('/local/scwevents/index.php'); ?>" id="bottomevents">Events</a></li>
<li><a href="<?php echo new moodle_url('/local/scwvideos/index.php'); ?>" id="bottomvideos">Videos</a></li>
<li><a href="<?php echo new moodle_url('/courses_qualifications.php'); ?>">Courses & Qualifications</a></li>
<li><a href="<?php echo new moodle_url('/book_store.php'); ?>">BookStore</a></li>
<li><a href="<?php echo new moodle_url('/advertisng.php'); ?>">Advertising</a></li>
<li><a href="<?php echo new moodle_url('/memberships.php'); ?>">Memberships</a></li>
<li><a href="<?php echo new moodle_url('/privacy_policy.php'); ?>">Privacy Policy</a></li>
<li><a href="<?php echo new moodle_url('/disclaimer.php'); ?>">Disclaimer</a></li>
<li><a href="<?php echo new moodle_url('/terms_of_service.php'); ?>">Terms of Service</a></li>
<li><a href="<?php echo new moodle_url('/contactus.php'); ?>">Contact Us</a></li>
<li><a href="<?php echo new moodle_url('/sitemap.php'); ?>">Site Map</a></li>
</ul>
<div class="sub-footer">
<p>&copy; Supply Chain Wire Ltd 2017. All rights reserved.</p>
</div>
</div>
<div class="col-lg-3">
<div class="socialicons">
<!--<ul>
<li class="fb"><a title="Facebook" href="#"><i class="fa fa-facebook"></i></a></li>
<li class="twit"><a title="Twitter" href="#"><i class="fa fa-twitter"></i></a></li>
<li class="linkd"><a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
<li class="gogl"><a title="Google plus" href="#"><i class="fa fa-google-plus"></i></a></li>
<li class="yutub"><a title="Youtube" href="#"><i class="fa fa-youtube"></i></a></li>
</ul>-->
<ul>
<li class="twit"><a title="Twitter" href="https://twitter.com/supplychainwire" target="_blank"><i class="fa fa-twitter"></i></a></li>
<li class="linkd"><a title="Linkedin" href="https://www.linkedin.com/in/supplychainwire" target="_blank"><i class="fa fa-linkedin"></i></a></li>
</ul>
</div>

</div>
</div>
</div>

</div>
</footer>
<div class="footerfixed-blk" style="display:none;margin-bottm:0px;">
<div class="container-fluid">
<div class="row">
<div class="col-lg-9">
<div class="footer-fixed" id="footer-fixed">This site use cookies to ensure that we give you the best experience on our website. If you continue without changing your settings, we'll assume that you are happy to receive all cookies. <br />However, you can change your cookie settings at any time.More on our cookie policy can be found here <a href="<?php echo new moodle_url('/privacy_policy.php'); ?>?#cookies">Privacy Policy</a>
</div>
</div>
<div class="col-lg-3">
<button class="btn btn-danger clsfooterfix" id="btn-cookie">Thank you</button></div>
</div>
</div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
<script type="text/javascript">
require(['jquery'], function( $ ) {
var a = new cookie("privacy_policy_accepted", 'yes', 365, "","");
var ecv = a.read();
/*if(ecv === null || ecv === undefined){
 a.set();
}*/
if(ecv==null){
	$(".footerfixed-blk").show();
	
}else{
	$(".footerfixed-blk").hide();
	$('.footer-blk').css('margin-bottom','0px');
}


$("#btn-cookie").click(function(){
   a.set();
   $(".footerfixed-blk").hide();
   $('.footer-blk').css('margin-bottom','0px');
});

// get hash value
  var hash = window.location.hash;
  // now scroll to element with that id
  if(hash!=""){
 $('html, body').animate({
        scrollTop: $(hash).offset().top
    }, 2000);
  }

});
</script>