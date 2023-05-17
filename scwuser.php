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

require_login();


$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);
$PAGE->set_title('SCW Users');
$PAGE->set_heading('SCW Users');
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/login/scwuser.php');

echo $OUTPUT->header();
echo'<h3>Scw Users</h3><p>Ordered by name</p><br>';
?>
<form method="post" action="">
<label>Email </label> <input type="text" name="email" />
<input type="submit" value="Search" />
</form>
<?php
        $page = optional_param('page','0',PARAM_INT);
		$params=array();
		$baseurl =  new moodle_url('/login/scwuser.php', $params);
        $seg = $page;
        $perpage = '10';
		
		$offset  = $seg*$perpage;
		$syscontext = context_system::instance();
		
		$output = '';
		$table = new html_table();
		$table->head = array ();
        $table->colclasses = array();
		$table->head[] = "#";
		$table->head[] = "ID";
        $table->head[] = "Name";
        $table->head[] = "Email";
        $table->attributes['class'] = 'admintable generaltable';
        $table->head[] = "Profession";
		$table->head[] = "Approval Status";
		$table->head[] = "Instant Approvel";
		$table->head[] = "Payment Mail";
		$table->head[] = "Created on";
		$sparams = array();

		if(isset($_POST['email']))
		{
			$email=$_POST['email'];
			$qry = "SELECT * FROM {user} u, {user_details} ud WHERE u.email like '%$email%' and u.deleted=0 and ud.user_id=u.id order by u.firstname";
			$totalcount = $DB->count_records_sql("SELECT COUNT('x') from {user} u, {user_details} ud WHERE u.email like '%$email%' and u.deleted=0 and ud.user_id=u.id");
		}
		else
		{
			$qry = "SELECT * FROM {user} u, {user_details} ud WHERE u.deleted=0 and ud.user_id=u.id order by u.firstname";
			$totalcount = $DB->count_records_sql("SELECT COUNT('x') from {user} u, {user_details} ud WHERE u.deleted=0 and ud.user_id=u.id");
		}
		
		
		$result = $DB->get_records_sql("$qry", $sparams, $offset, $perpage);
/*		echo '<pre>';
		print_r($result);
		echo '</pre>';*/
		
		$key=0;				
        foreach ($result as $crow) {
			$key++;
			$url='';
			$surl='';
            $row = array();
			$row[] = $page*10+$key;
			$row[] = $crow->user_id;
			$row[] = ucfirst($crow->firstname).' '.ucfirst($crow->lastname);
			$row[] = $crow->email;
			$row[] = ($crow->profession=="1") ? "Professional" : "Recent Graduates";
			$row[] = ($crow->confirmed=="1") ? "Approved" : "Not Approved";
			if(($crow->confirmed=="1"))
			$url='<a onclick="return confirm(\'Are you sure?\')" href="'.$CFG->wwwroot.'/login/admin_approve.php?action=3&id='.$crow->user_id.'">Disapprove</a>';
			else			
			$url='<a onclick="return confirm(\'Are you sure?\')" href="'.$CFG->wwwroot.'/login/admin_approve.php?action=1&id='.$crow->user_id.'">Approve</a>';
			$row[] = $url;
			if($crow->profession=="2")
			$surl='<a onclick="return confirm(\'Are you sure?\')" href="'.$CFG->wwwroot.'/login/admin_approve.php?action=2&id='.$crow->user_id.'">Resend</a>';
			else
			$surl=' - ';
			$row[] = $surl;
            $row[] = date("M d, Y", $crow->timecreated);
            $table->data[] = $row;
        }
		
		//$totalcount = $DB->count_records($ctable);

		
		$paging = $OUTPUT->paging_bar($totalcount , $page , $perpage, $baseurl);
		if($totalcount>0){
            $output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
            $output .= html_writer::table($table);
            $output .= html_writer::end_tag('div');
			$output .= html_writer::start_tag('p');
			$output .= '<br><b>No of users</b>:'.$totalcount;
			$output .= html_writer::end_tag('p');
            $output .= html_writer::start_tag('div', array('class'=>'pagination'));
            $output .= $paging;
            $output .= html_writer::end_tag('div');	
		}else{
			$output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
			$output .= '<br/><p><strong>No records Found</strong></p>';	
			$output .= html_writer::end_tag('div');	
		}

		echo $output;

echo $OUTPUT->footer();