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

$title = 'About us';

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/aboutus.php');
$PAGE->set_pagelayout('scwpage');
$PAGE->set_title($title);
$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';


echo $OUTPUT->header();
?>

<div class="aboutus-blk">
  <h4><i class="fa fa-users"></i>About us</h4>
  <div class="aboutus-detaials">
   <p><span>www.supplychainwire.com (SCW)</span> - A business and professional networking platform (web-based) connecting Supply Chain professionals, students & recruiters  globally.  SCW is a high-end portal and will provide its users-clients, members and visitors with information of business contacts, products, services, courses, associations, jobs and events information pertaining ONLY to the Supply Chain Industry globally.</p>
  <h5><strong>SCW will contain/provide information about the:</strong></h5>
  <ul>
    <li><i class="fa fa-caret-right"></i> A networking place to connect to professionals working in the Supply Chain Industry.</li>
    <li><i class="fa fa-caret-right"></i> Supply Chain Events/Workshops/ Training.</li>
    <li><i class="fa fa-caret-right"></i> Products for the Supply Chain Industry.</li>
    <li><i class="fa fa-caret-right"></i> Software and Tools useful to the Supply Chain Industry.</li>
    <li><i class="fa fa-caret-right"></i> Supply Chain Courses & Qualifications.</li>
    <li><i class="fa fa-caret-right"></i> Interviews, Videos & Podcasts.</li>
    <li><i class="fa fa-caret-right"></i> Online purchasing of Supply Chain books.</li>
    <li><i class="fa fa-caret-right"></i> Jobs.</li>
    <li><i class="fa fa-caret-right"></i> Warehousing community platform: Short videos of warehousing companies to showcase their capabilities.</li>
  </ul>
  <p>Supply Chain Wire makes thorough checks on information of our members or businesses before they are listed on the portal, so that only genuine and quality information is rendered to its users. Supply Chain Wire’s present format is its first release. We are continuously aiming to invent and enhance features and information on the portal, and hence the services we offer will continue to expand.</p>
  <p>Supply Chain Wire gives you access to the leading publication and reports covering the global logistics, supply chain and transportation industry –all in ONE place. Publications in supply chain offers you great resources for learning about breaking industry news, trends, technologies, best practices and so much more. With our partnerships with various publication houses, firms, content providers, independent journalists and decision makers, this section contains the latest forecasts, facts, figures and reviews, trends, case studies and the latest innovations in equipment and software and more covering this industry. It concentrates on free content but you may also find links to selected paid research deemed of relevance to the topic. Supply Chain Wire does not claim that the contents listed here to be comprehensive and may not include items that are widely circulated elsewhere. </p>
  <p> Supply Chain Wire seeks and offers a number of different partnership opportunities including marketing programs and a number of options for content integration. We would be happy to talk to you about the many ways we can work together. Simply drop us an email at <span>info@www.supplychainwire.com</span> and we will be in touch with you.</p>
  <!--<h5>SCW will have 3 different types of membership options:</h5>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td><strong>Professionals</strong> (working in the SC industry globally)</td>
        <td>Create profile and network</td>
        <td>FREE membership</td>
      </tr>
      <tr>
        <td><strong>Students</strong> (studying for a Supply Chain course)</td>
        <td>Create profile, network and submit CV	</td>
        <td>£50 per year membership fees.</td>
      </tr>
    </tbody>
  </table>
  <h5>SCW will contain/ provide information about the professionals working in the below sectors:</h5>
  <h5>Categories:</h5>
  <p>Freight forwarding-Air, Sea, Rail &  Road, Shipping lines, Logistics companies, Equipment suppliers, Supply Chain Consultants, HAZMAT Specialists, Couriers, Removal companies, Warehousing , Hauliers, Packing companies,  Custom brokers, Cargo Insurance, Freight software companies.</p>
  <h5>Functional  Areas:</h5>
  <p>Procurement,Sourcing, Reverse logistics, SC Analysis & Consulting, Global Fulfilment & Distribution  ,Inventory, Demand & forecast Planning, Purchasing, Wireless in Logistics, Green Logistics, Transportation, Inbound Logistics, Promotions Management, RFID,SC Planning & Optimization, Warehouse Design, Web-based Supply Chain, SC Compliance Networks, Sales & Operations Planning, Supply Chain Risk, Supply Chain Finance Management, Fleet Management, Distribution, Inventory Planning/Optimization,3PL Replenishment, Supply Chain Sales, Humanitarian Logistics, Freight Forwarding ,SC Security & Risk Management, Rail & Intermodal, Value-Added Services, Supply Chain Collaboration, Health/Safety/Quality, Environment, SC Legal, Maritime Technology, Performance management in SC, Ship Management, Warehouse Operations Management, Logistics Project Management, Order Fulfillment ,Supplier Relationship Mgmt, Supply Chain Management for Marketing, Supply Chain Visibility, Supply Chain Education ,SC Analysis & Consulting.</p>-->
  </div>
</div>
<?php
echo $OUTPUT->footer();
