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

$string['pluginname'] = 'SupplyChainWire Banner';
$string['banner_status'] = 'Status';
$string['pluginnameheading'] = 'SCW Banner configuration';
$string['scwbanner'] = 'SCW Banner';
$string['bannerpages_label'] = 'Banner Pages';
$string['bannerpages_default'] = 'site-index|Home Page
login-index|Login Page
login-signup|Register Page
local-scwinterviews-index|Interview List Page
local-scwinterviews-view|Interview Detail Page
local-scwvideos-index|Video List Page
local-scwvideos-view|Video Detail Page
local-scwevents-index|Event List Page
local-scwevents-view|Event Detail Page
local-mylinks-search|Search Result
local-mylinks-profile|Profile
local-scwnewletter-index|NewsLetter Page
aboutus|About Us page
contactus|Contact Us
memberships|Memberships
privacy_policy|Privacy Policy
disclaimer|Disclaimer
terms_of_service|Terms of service
sitemap|Sitemap
products|Products
courses_qualifications|Course & Qualification
book_store|Book Store
advertisng|Advertising';
$string['bannerpages_description'] = '<p>If you will add new page in this list, follow this below steps.</p>
<p>page-shortname|Page Display Name|page relative or absolute URL</p>
<p>Ex 1: about_us|About Us Page|/about-us.php </p>
<p>Ex 2: privacy_policy|Privacy Policy Page|http://www.example.com/privacy-policy</p>';
$string['topbanner_no_label'] = 'No of banners Top';
$string['topbanner_no_desc'] = 'Please choose no of banners display in site top.';

$string['leftbanner_no_label'] = 'No of banners Left';
$string['leftbanner_no_desc'] = 'Please choose no of banners display in site left side.';

$string['right1banner_no_label'] = 'No of banners Right 1';
$string['right1banner_no_desc'] = 'Please choose no of banners display in site right side 1.';

$string['right2banner_no_label'] = 'No of banners Right 2';
$string['right2banner_no_desc'] = 'Please choose no of banners display in site right side 2.';

$string['right3banner_no_label'] = 'No of banners Right 3';
$string['right3banner_no_desc'] = 'Please choose no of banners display in site right side 3.';

$string['bottombanner_no_label'] = 'No of banners Bottom';
$string['bottombanner_no_desc'] = 'Please choose no of banners display in site bottom.';
$string['managebanners'] = 'Manage Banners';
$string['scwbanner:addbanner'] = 'Add Banner';
$string['scwbanner:editbanner'] = 'Edit Banner';
$string['scwbanner:deletebanner'] = 'Delete Banner';
$string['scwbanner:viewbanners'] = 'View Banners';
$string['viewaccessdenied'] = 'You Don\'t have view access for banner admin section.';
$string['editaccessdenied'] = 'You Don\'t have edit banner access.';
$string['addaccessdenied'] = 'You Don\'t have add banner access.';
$string['bannerupdatemessage'] = 'Banner(s) are updated successfully';
$string['banner_status_active'] = 'Is Active';
$string['bannerexpiredatebefore'] = 'The banner expire date should be greater than or equal today';
$string['prioritytaken'] = 'Banner Preference Order is already used for another banner name ({$a})';
$string['addbanner'] = 'Add Banner';
$string['editbanner'] = 'Edit Banner';
$string['failed'] = 'Failed';
$string['success'] = 'Success';