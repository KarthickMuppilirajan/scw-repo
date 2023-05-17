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

$title = 'Terms of service';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/terms_of_service.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';


echo $OUTPUT->header();
?>

<div class="aboutus-blk">
  <h4><i class="fa fa-users"></i>Terms of service</h4>
  <div class="aboutus-detaials">
The Terms of Service detailed here govern your use of www.supplychainwire.com, and we provide content and services to you subject to the following conditions. If you do not agree with any of these terms, you should exit www.supplychainwire.com.

<h5>General Rules </h5>
<p>If you choose to use www.supplychainwire.com (the "Service"), you agree to abide by all of the terms and conditions of this Terms of Service Agreement between you and www.supplychainwire.com.<p>

<h5>Membership and Registration</h5>
<p>You must be 18 years or older to register as a member of www.supplychainwire.com. You are responsible for all usage or activity on your www.supplychainwire.com member account. Any fraudulent, abusive, or otherwise illegal activity may be grounds for termination of your account, at our sole discretion, and we may refer you to appropriate law enforcement agencies. </p>

<p>If you decide to become a registered member of www.supplychainwire.com, as part of the registration process, you will provide your real name, email address and any relevant details about you or your business. You agree that all registration information you provide will be accurate and up to date. You may not:
</p>

<ul>
    <li><i class="fa fa-caret-right"></i> Select or use another person's name with the intent to impersonate that person.</li>
    <li><i class="fa fa-caret-right"></i> Use another person's member account.</li>
    <li><i class="fa fa-caret-right"></i> Use a username that Supply Chain Wire, in its sole discretion, deems offensive. </li>
  </ul>
  
<p>You will be responsible for maintaining the confidentiality of your password. You will notify us of any known or suspected unauthorized use of your account.</p>
<p>If you don't comply with these terms, we may terminate your member account.</p>  

<h5>Use of Member Services </h5>
<p>Prices: All subscription prices are subject to change at any time without prior notification. Supply Chain Wire reserves the right to cancel an order for any reason, including invalid pricing or computer errors.</p>

<p>Payments: Payment must be made at the time of purchase. All sales are final and no refunds will be provided.</p>

<p>Usage: You acknowledge that your Supply Chain Wire Membership account is for your personal use only, and you agree not to share your membership password with anyone else. Password sharing may be grounds for termination of your membership.</p>

<p>Service and Support: We provide support to paid members during the period of subscription. Support is provided via email.</p>

<h5>Use of Basic Member Services </h5>

<p>Posting Guidelines: You agree not to upload to, or distribute or otherwise publish on the www.supplychainwire.com messagee boards and chat groups any libelous, defamatory, obscene, pornographic, abusive, or otherwise illegal material.</p>

<p>You acknowledge that any submissions you make to the Service may be edited, moved, removed, modified, published, transmitted, and displayed by us and you waive any moral rights you may have in having the material altered or changed in a manner not agreeable to you</p>

<h5>Copyright and Trademarks</h5>

<p>Copyright: All materials published on www.supplychainwire.com (including, but not limited to text, photographs, images, illustrations, audio clips and video clips , collectively known as the "Content") are protected by copyright, and owned or controlled by Supply Chain Wire Ltd, or the party credited as the provider of the Content. You shall abide by all additional copyright notices, information, or restrictions contained in any Content accessed through the Service.</p>
 
<p>You may use the Content online and solely for your personal, non-commercial use, and you may download or print a single copy of any portion of the Content for your personal, non-commercial use, provided you do not remove any trademark, copyright or other notice contained in such Content. No other use is permitted. You may not republish the Content on any Internet, Intranet or Extranet site or incorporate the Content in any database, compilation, archive or cache. You may not distribute any of the Content to others, whether or not for payment or other consideration, and you may not modify, copy, frame, reproduce, sell, publish, transmit, display or otherwise use any portion of the Content without the written consent of Supply Chain Wire Ltd.</p>

<p>User-Created Content: By placing material on or communicating with www.supplychainwire.com, including for example communication during registration, via e-mail, communication on any www.supplychainwire.com message board or message or chat area, posting any review or photograph, entering any contest, etc., you represent and warrant that you own or otherwise control all of the rights to the content that you provide, that the content is accurate, that it does not violate these Terms of Service, and that it will not cause injury to any person or entity. You grant Supply Chain Wire Ltd and its affiliates, including www.supplychainwire.com, a royalty-free, perpetual, irrevocable, non-exclusive right and license to use, copy, modify, display, archive, store, distribute, reproduce and create derivative works from all information you provide to us (except the confidential information provided during member registration), in any form, media, software or technology of any kind now existing or developed in the future. You also grant Supply Chain Wire Ltd and its affiliates and related entities the right to use your name and any other information about you that you provide in connection with its use and with the reproduction or distribution of such material. All rights in this paragraph are granted without the need for additional compensation of any sort to you.</p>

<p>Copyright Complaints: If you believe that your work has been copied in a way that constitutes copyright infringement or are aware of any infringing material placed by any third party on supplychainwire.com, please contact us at <a href="mailto:info@supplychainwire.com">info@supplychainwire.com</a></p>

<p>Links: <a href="www.supplychainwire.com">www.supplychainwire.com</a> contains links to other related World Wide Web Internet sites, resources, and sponsors of www.supplychainwire.com. Since supplychainwire.com is not responsible for the availability or contents of these outside resources, you should direct any concerns regarding any external sites to the site administrator or Webmaster of that site.</p>

<p>Linking to <a href="www.supplychainwire.com">www.supplychainwire.com</a>: If you operate a Web site you may link to supplychainwire.com. However, you may not frame or utilize framing techniques that involve any trademark, logo, copyrighted material or other proprietary information (including images, text, page layout, or form) of any portion of supplychainwire.com without our express written consent. In addition, you agree not to insert any code or product or manipulate the content of supplychainwire.com in any way that affects the user’s experience, and not to use any data mining, robots, cancel bots, Trojan horse, or any data gathering or extraction method in connection with your use of supplychainwire.com.</p>

<h5>Representations and Warranties</h5>
<p>While supplychainwire.com uses reasonable efforts to include accurate and up-to-date information, we make no warranties or representations as to the accuracy of the Content of supplychainwire.com and assume no liability or responsibility for any error or omission in the Content.</p>

<p>You represent, warrant and covenant (a) that no materials of any kind submitted through your account will (i) violate, plagiarize, or infringe upon the rights of any third party, including copyright, trademark, privacy or other personal or proprietary rights; or (ii) contain libelous or otherwise unlawful material; and (b) that you are at least thirteen years old. You hereby indemnify, defend and hold harmless supplychainwire.com and Supply Chain Wire Ltd, and all officers, directors, owners, agents, information providers, affiliates, licensors and licensees (collectively, the "Indemnified Parties") from and against any and all liability and costs, including, without limitation, reasonable attorneys' fees, incurred by the Indemnified Parties in connection with any claim arising out of any breach by you or any user of your account of this Agreement or the foregoing representations, warranties and covenants. You agree to cooperate as fully as reasonably required in the defense of any such claim.</p>

<p>Neither supplychainwire.com (“the service”) nor Supply Chain Wire Ltd represent or endorse the accuracy or reliability of any advice, opinion, statement, or other information displayed, uploaded, or distributed through the Service by any user, information provider or any other person or entity. You acknowledge that any reliance upon any such opinion, advice, statement or information is at your sole risk.</p>

<p>The Service and all downloadable software are distributed on an “AS IS” Basis without warranties of any kind, either express or implied, including, without limitation, warranties of title or implied warranties of merchantability or fitness for a particular purpose. You hereby acknowledge that use of the service is at your sole risk.</p>

<h5>Miscellaneous</h5>

<p>Supply Chain Wire Ltd reserves the right to change these Terms of Service at any time in its discretion and to notify users of any such changes solely by changing this Terms of Service agreement. Your continued use of supplychainwire.com after the posting of any amended Terms of Service will constitute your agreement to be bound by any such changes.</p>

<p>Supply Chain Wire Ltd may modify, suspend, discontinue or restrict the use of any portion of supplychainwire.com, including the availability of any portion of the Content at any time, without notice or liability. Supply Chain Wire Ltd may deny access to any person or user at any time for any reason. In addition, Supply Chain Wire Ltd may at any time transfer its rights and obligations under this Agreement to any entity that acquires Supply Chain Wire Ltd , supplychainwire.com or any of their assets.</p>



  </div>
</div>
<?php
echo $OUTPUT->footer();
