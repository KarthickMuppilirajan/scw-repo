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
 * Support local plugin.
 *
 * @package    local_support
 * @copyright  2016 Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../config.php');
require_once($CFG->libdir.'/authlib.php');
require_once(__DIR__ . '/lib.php');
global $CFG, $DB, $PAGE;
$myfile = fopen("paypal.txt", "a") or die("Unable to open file!");
$data=$_REQUEST;
$payment_data='info:<br>';
fwrite($myfile, '--------------------------------------------------------------------------------------------------------- ');
foreach ($data as $key=>$val)
{
	$payment_data.= '<br>'.$key.' - '.$val;
	fwrite($myfile, '  '.$key.' - '.$val);
}
fwrite($myfile, ' ---------------------------------------------------------------------------------------------------------  ');
fclose($myfile);
//print_r($data);
if($data['payment_status']=='Completed' or $data['payment_status']=='Pending')
{
	$custom=trim($data['custom']);
	list($random_url,$payment_url_creation)=explode('_',$custom);
	$user_details_record=$DB->get_record('user_details', array('random_url' => $random_url,'payment_url_creation' => $payment_url_creation));
	$user_record=$DB->get_record('user', array('id' => $user_details_record->user_id));

	
	$firstname=$user_record->firstname;
	$lastname=$user_record->lastname;
	$user_record->confirmed=1;
	
	$record= new stdClass();
	$record->id=$user_details_record->id;
	$record->user_id=$user_record->id;
	$record->password_url_creation=time();
	$record->password_url_expiration=time()+(60*60);
	$record->approval_status=1;
	$record->payment_data=$payment_data;		
	$sql = $DB->update_record('user_details', $record);
	$sql = $DB->update_record('user', $user_record);

/*	echo '<pre>';
	print_r($record);
	print_r($user_record);
	print_r($user_details_record);
	exit;*/
//	core_login_process_password_reset_request_new($user_record);/////////////////////////send forgot password mail by email
	$user=$user_record;
	$resetrecord = core_login_generate_password_reset($user);
	$sendresult = send_password_change_confirmation_email_new($user, $resetrecord);		
}

