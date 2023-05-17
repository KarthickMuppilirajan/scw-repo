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

$title = 'Disclaimer';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/disclaimer.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';


echo $OUTPUT->header();
?>

<div class="aboutus-blk">
  <h4><i class="fa fa-users"></i>Disclaimer</h4>
  <div class="aboutus-detaials">
    <h5>Content </h5>
    <p>www.supplychainwire.com reserves the right not to be responsible for the topicality, correctness, completeness or quality of the information provided. Liability claims regarding damage caused by the use of any information provided, including any kind of information, which is incomplete or incorrect, will therefore be rejected. All information are not-binding and without obligation. Parts of the pages or the complete publication including all information’s might be extended, changed or partly or completely deleted by Supply Chain Wire Ltd without separate announcement. </p>
    <h5>Referrals and Links </h5>
    <p>www.supplychainwire.com is not responsible for any contents linked or referred to from its pages - unless it has full knowledge of illegal contents and would be able to prevent the visitors of his site from viewing those pages. If any damage occurs by the use of information presented there, only the author of the respective pages might be liable, not the one who has linked to these pages. Furthermore the author is not liable for any postings or messages published by visitors on his page. </p>
    <h5>Copyright </h5>
    <p>www.supplychainwire.com intended not to use any copyrighted material for the publication or, if not possible, to indicate the copyright of the respective object. The copyright for any material created by the author is reserved. Any duplication or use of objects such as diagrams, sounds or texts in other electronic or printed publication is not permitted without the author's agreement. </p>
    <h5>Privacy Policy </h5>
    <p>If the opportunity for the input of personal or business data is given, the input of this data takes place voluntarily. For a better understanding please read the full Privacy Policy. </p>
    <h5>Disclaimer of Liability </h5>
    <p>www.supplychainwire.com does not warrant or assume any legal liability or responsibility for the accuracy, completeness or usefulness of any information available on www.supplychainwire.com. </p>
    <h5>Disclaimer of Endorsement</h5>
    <p>www.supplychainwire.com does not endorse or recommend any commercial products, processes, activities or services. The views, opinions and data presented by the author on www.supplychainwire.com may not be used for endorsement purposes. Pop-Up Advertisements - when visiting our web site, your web browser may produce pop-up advertisements. These advertisements were most likely produced by other web sites you visited or by third party software installed on your computer. Supply Chain Wire Ltd does not endorse or recommend products or services for which you may view a pop-up advertisement on your computer screen while visiting our site. </p>
    <h5>Legal Validity of this Disclaimer</h5>
    <p>This disclaimer is to be regarded as part of the www.supplychainwire.com portal. If sections or individual terms of this statement are not legal or correct, the content or validity of the other parts remain uninfluenced by this fact. </p>
    <p>Contacting www.supplychainwire.com 
      If you have any question about this disclaimer statement, the practices of this site, or your dealings with this web site, you can contact us by e-mail at <a href="mailto:info@www.supplychainwire.com">info@www.supplychainwire.com</a></p>
  </div>
</div>
<?php
echo $OUTPUT->footer();

