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

$title = 'Privacy Policy';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/privacy_policy.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';


echo $OUTPUT->header();
?>

<div class="aboutus-blk">
  <h4><i class="fa fa-users"></i>Privacy Policy</h4>
  <div class="aboutus-detaials">
  This document explains our policies for the collection, use and disclosure of personal information.

<h5>The Information we collect </h5>
<p>Supply Chain Wire collects information by various methods including information actively provided by its lead providers, its customers, and information arising from customer surveys and general feedback. The types of personal information we collect include name, contact information, identification information, and credit information. Credit card information is used for billing purposes only. We may record calls to or from our customer service representatives for purposes of accuracy, performance reviews, training and General quality assurance.<p>

<h5>How we use this information</h5>
<p>This information is used to provide our various products including customer service, accounting, billing, collections, and the marketing of other Supply Chain Wire’s services. 

Supply Chain Wire may use aggregate or anonymous information, which will not be linked to identified individuals, for various other uses for itself and third parties. The identity of our corporate clients is not considered personal or confidential information, and we may disclose that information for promotion and marketing purposes.

Supply Chain Wire users may have the option to participate in online discussion communities. Such communities are exclusive communities for certain Supply Chain Wire subscribers and are accessible only by subscribers through their Supply Chain Wire login name and password. Participation in the community is completely voluntary. By opting into the community, subscribers agree to share basic contact information (Name, Company, Address) with their peers in the community </p>

<h5>Who we share this information with </h5>
<p>Supply Chain Wire does not share personal information with any third parties except as disclosed in this policy. Supply Chain Wire may provide personal information to Supply Chain Wire’s consultants, subcontractors and professional advisers (which shall be bound by privacy obligations). </p>

<h5>Security </h5>
<p>Personal information is stored in a combination of paper and electronic files. They are protected by security measures appropriate to the nature of the information. </p>

<h5>Accessing information </h5>
<p>Individuals may review their personal information contained in Supply Chain Wire files by contacting us at info@supplychainwire.com. If an individual believes that any of their personal information is inaccurate, we will make appropriate corrections.</p>

<h5>Cookies</h5>
<p>Cookies are used by Supply Chain Wire for the convenience of our users. They are used to streamline access to the online subscriber service. Cookies automatically authenticate the user. A user can access Supply Chain Wire products with the cookie feature turned off; however, in doing so they may find themselves challenged for username and password information on multiple occasions. Supply Chain Wire also uses cookies to track user’s visits and uses that information to improve the user’s experience and track use of our products. </p>

<h5>Links </h5>
<p>Supply Chain Wire seeks out the best Web sources and resources for our advisory services. Many of our pages contain links to information at other Web sites. When you click on one of these links, you are moving to another web site. We encourage you to read the privacy statements of these linked sites as their privacy policy may differ from ours. </p>
 
<h5>General </h5>
<p>Supply Chain Wire may amend this policy from time to time. If such amendments affect how Supply Chain Wire uses or discloses personal information already held by Supply Chain Wire in a material way, Supply Chain Wire will obtain consent.</p>

<p>Notwithstanding the general terms of this policy, the collection, use, and disclosure of personal information may be made outside of the terms herein to the extent provided for in any applicable privacy or other legislation in effect from time to time. </p>

  </div>
</div>
<?php
echo $OUTPUT->footer();
