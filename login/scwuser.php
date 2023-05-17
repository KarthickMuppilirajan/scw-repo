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
$PAGE->navbar->add(get_string('mymoodle','admin'), new moodle_url('/my'));
$PAGE->navbar->add('Manage Users', new moodle_url('/login/scwuser.php'));

$countries = get_string_manager()->get_list_of_countries(true);

echo $OUTPUT->header();
echo'<h3>Scw Users</h3><p>Ordered by name</p><br>';
$actionurl = new moodle_url("/login/admin_approve.php");



$page = optional_param('page','0',PARAM_INT);
$searchtext = optional_param('searchtext','',PARAM_TEXT);
$searchtext=trim($searchtext);
$sort = optional_param('sort', 'fid', PARAM_TEXT);
$dir = optional_param('dir', 'ASC', PARAM_ALPHA);
?>
<div class='form-inline row'>
  <div class='form-group col-sm-10 col-md-5 col-lg-3 mform'>
    <form class="form-inline" id="frmeventstatus" action="<?php echo $actionurl; ?>" method="post">
	<span class="error hide" id="event_action_error"></span>
    <select class='form-control' name="event_action" id="event_action">
	   <option value="">Select</option>
       <option value="approve">Approve</option>
	   <option value="dissaprove">Diapprove</option>
    </select>
	<input type="hidden" name="event_ids" value="">
    <input type="hidden" name="action" value="4" />
	<input type="submit" name="apply" value="Apply" class="form-control">
	</form>
  </div>
<div class='form-group col-sm-12 col-md-8 col-lg-7'>
<form method="get" action="">
<label>Email </label> <input type="text" name="searchtext" id="searchtext" value="<?php echo $searchtext;?>" />
<input type="submit" value="Search"  id="btn-search-user"/>
</form>
</div>
<br /><br /><br />
</div>
<?php
		$params = array();
		if(!empty($searchtext)){
            $params["searchtext"] = $searchtext;
		}

		$baseurl =  new moodle_url('/login/scwuser.php', $params);
        $seg = $page;
        $perpage = '10';
		
		$offset  = $seg*$perpage;
		$syscontext = context_system::instance();
		
		$output = '';
		$table = new html_table();
		$table->head = array ();
        $table->colclasses = array();
		$table->head[] = '<input type="checkbox" name="chkall" id="chkall" value="1">'; // Checkbox field field
		
		$columns = array("#"=>"#","id" => "id", "firstname" => "firstname","country" => "country", "email" => "email","profession" =>"profession",
		"approval_status" => "approval_status","instant_approval" => "instant_approval","payment_mail" => "payment_mail","timecreated" => "timecreated"
		);
		
		$hstr = array("#"=>"#","id" => "id", "firstname" => "Name","country" => "Country Citizen", "email" => "Email","profession" =>"Profession",
		"approval_status" => "Approval status","instant_approval" => "Instant approval","payment_mail" => "Payment mail","timecreated" => "Created on"
		);
		
		
		foreach($columns as $column){
			
			if ($sort != $column) {
				$columnicon = "";
				$columndir = "ASC";
			}else{
				$columndir = $dir == "ASC" ? "DESC":"ASC";
				$columnicon = ($dir == "ASC") ? "sort_asc" : "sort_desc";
				$columnicon = "<img class='iconsort' src=\"" . $OUTPUT->pix_url('t/' . $columnicon) . "\" alt=\"\" />";
			}
			$surl = new moodle_url('/login/scwuser.php',array("sort" => $column, "dir" => $columndir, "searchtext" => $searchtext));
			$surl = $surl->__toString();
			if($hstr[$column]=="#" || $hstr[$column]=="Instant approval" || $hstr[$column]=="Payment mail"){
			$table->head[] = $hstr[$column];
			}else{
			$table->head[] = "<a href=\"$surl\">".$hstr[$column]."</a>$columnicon";
			}
		}
		$table->attributes['class'] = 'admintable generaltable';
		
		$whr = "WHERE u.deleted=0 and ud.user_id=u.id ";
		if(!empty($searchtext)){
			$whr.= " and u.email like '%$searchtext%' "; 
		}else{
			$whr.= ""; 
		}

		if ($sort == "fid") {
          $sort = 'id';
        }elseif ($sort == "approval_status") {
          $sort = 'confirmed';
        }

		
		$orderstr = ($sort=="id")? "ORDER BY u.firstname $dir" : 'ORDER BY '.$sort.' '.$dir;
		
		$qry = "SELECT * FROM {user} u, {user_details} ud $whr $orderstr LIMIT $offset,$perpage";		

		$result = $DB->get_records_sql($qry);
		
/*		echo '<pre>';
		print_r($result);
		echo '</pre>';*/
		
		$key=0;				
        foreach ($result as $crow) {
			$key++;
			$url='';
			$surl='';
            $row = array();
            $row[] = '<input type="checkbox" name="eid[]" class="eid" value="'.$crow->user_id.'">'; // Checkbox field field
			$row[] = $page*10+$key;
			$row[] = $crow->user_id;
			$row[] = ucfirst($crow->firstname).' '.ucfirst($crow->lastname);
			$row[] = isset($countries[$crow->country]) ? $countries[$crow->country] : '-';
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

		$totalcount = $DB->count_records_sql("SELECT COUNT('x') from {user} u, {user_details} ud $whr");
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
?>
<script type="text/javascript">
require(['jquery'], function( $ ) {
  
  function set_eids(){
    var eids = [];
    $('input.eid:checked').each(function(i,e) {
      eids.push(e.value);

    });
    eids = eids.join(',');
	$("input[name=event_ids]").val(eids);
//	alert($("input[name=event_ids]").val());
  }
  
  $("select[name=event_action]").change(function(){
	  var eac = $("select[name=event_action]").find(":selected").val();
	  $("#event_action_error").addClass("hide");
	  if(eac==""){
		  $("#event_action_error").html("Please choose any one action").removeClass("hide");
	  }
  });
  
  $("#chkall").change(function(){
	 var chk = this.checked;
	  $("input.eid").each(function(){
		 $(this).prop("checked",chk);
	  });
	  set_eids();
  });
  
  $("input.eid").change(function(){
	  set_eids();
  });
  
  $("#frmeventstatus").submit(function(){
	  var eac = $("select[name=event_action]").find(":selected").val();
	  set_eids();
	  var eids = $.trim($("input[name=event_ids]").val());
	  
	  $("#event_action_error").addClass("hide");
	  var cnt = 0;
	  if(eac==""){
		  $("#event_action_error").html("Please choose any one action").removeClass("hide");
		  cnt++;
	  }else if(eids.length==0 ){
		  $("#event_action_error").html("Please choose any one user").removeClass("hide");
		  cnt++;
	  }
	  
	  if(cnt==0){
		  return true;
	  }
	  return false;
  });
});
</script>