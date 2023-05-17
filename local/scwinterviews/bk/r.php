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
 * Renderers for outputting blog data
 *
 * @package    local_candidates
 * @copyright  Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class local_scwinterviews_renderer extends plugin_renderer_base {
//for admin view
public function interview_list() {
		global $OUTPUT,$PAGE,$DB,$USER,$CFG;
        $page = optional_param('page','0',PARAM_INT);
		$searchtext = optional_param('searchtext','',PARAM_TEXT);
		$params = array();
		if(!empty($searchtext)){
            $params["searchtext"] = $searchtext;
		}
		$baseurl =  new moodle_url('/local/scwinterviews/admin.php', $params);
        $seg = $page;
        $perpage = '10';
		
		$offset  = $seg*$perpage;
		$systemcontext = context_system::instance();
		
		$output = '';
		$table = new html_table();
		$table->head = array ();
        $table->colclasses = array();
		if (has_capability('local/scwinterviews:editinterview', $systemcontext)) {
			$table->head[] = '<input type="checkbox" name="chkall" id="chkall" value="1">'; // Checkbox field field
		    $table->head[] = ""; // Edit field
		}
		$table->head[] = "ID";
        $table->head[] = "Heading";
        $table->attributes['class'] = 'admintable generaltable';
		$table->head[] = "Content";
		$table->head[] = "Contact Info";
		$table->head[] = "Company";
		$table->head[] = "Expires By";
		$table->head[] = "priority";
		$table->head[] = "Status";
		$table->head[] = "Modified By";
		$table->head[] = "Modified Date";
		
		$ctable = 'local_scwinterviews';
		$delval = 0;
		$sparams = array();
		$whr = ' interview_delete = :idl ';
		$sparams['idl'] = '0';
		
		if(!empty($searchtext)){
			$pos1 = stripos("Enabled", $searchtext);
			$pos2 = stripos("Disabled", $searchtext);
			if($pos1 !== FALSE){
                $whr .= ' AND interview_status = :status ';
				$sparams['status'] = '1';
			}else if($pos2 !== FALSE){
				$whr .= ' AND interview_status = :status ';
				$sparams['status'] = '0';
			}else{
                $whr .= " AND ".$DB->sql_like('interview_heading', ':iheading', false);
                $sparams['iheading']  = '%'.$searchtext.'%';
			}
			
		}
		
		$qry = "SELECT * FROM {local_scwinterviews} WHERE ";
		//$sparams['delval'] = $delval;
		//$result = $DB->get_records($ctable, array(), 'id asc', '*', $offset, $perpage);
		$result = $DB->get_records_sql("$qry $whr", $sparams, $offset, $perpage);
		
		
        foreach ($result as $crow) {
            $row = array();
			$edit_url = $CFG->wwwroot.'/local/scwinterviews/edit.php?id='.$crow->id;
			if (has_capability('local/scwinterviews:editinterview', $systemcontext)) {
              $row[] = '<input type="checkbox" name="vid[]" class="vid" value="'.$crow->id.'">'; // Checkbox field field
			  $row[] = '<a href="'.$edit_url.'">Edit</a>';
			}
			$row[] = $crow->id;
			$row[] = ucfirst($crow->interview_heading);
			$description = strip_tags($crow->summary);
			$summary = substr($description, 0, 150);
			//$summary = $crow->summary;
			$row[] = ucfirst($summary);
			$row[] = ucfirst($crow->interview_contact);
			$row[] = ucfirst($crow->interview_company);
			$expires_by = date("d-M-Y", $crow->interview_expires_by);
            $row[] = $expires_by;
			$row[] = ucfirst($crow->interview_priority);
			$row[] = ($crow->interview_status=="1") ? "Enabled" : "Disabled";
			$muser = core_user::get_user($crow->interview_modified_by); // get details by user id
			$row[] = ucfirst($muser->firstname);
			$row[] = date("M d, Y", $crow->interview_modified);
            $table->data[] = $row;
        }
		
		//$totalcount = $DB->count_records($ctable);
		$totalcount = $DB->count_records_sql("SELECT COUNT('x') FROM {local_scwinterviews} l WHERE $whr", $sparams);
		
		$paging = $OUTPUT->paging_bar($totalcount , $page , $perpage, $baseurl);
		if($totalcount>0){
            $output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
            $output .= html_writer::table($table);
            $output .= html_writer::end_tag('div');
            $output .= html_writer::start_tag('div', array('class'=>'searchreslt-pagination'));
            $output .= $paging;
            $output .= html_writer::end_tag('div');	
		}else{
			$output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
			$output .= '<br/><p><strong>No records Found</strong></p>';	
			$output .= html_writer::end_tag('div');	
		}

		return $output;
	}


	 public function list_interviews() {
		global $DB,$CFG,$OUTPUT,$PAGE,$USER;
        $page = optional_param('page','0',PARAM_INT);
        $seg = $page;
		$perpage = optional_param('perpage', 5, PARAM_INT);
		$output = '';
		$ctable = 'local_scwinterviews';
		$searchname = optional_param('search', '', PARAM_TEXT);
		$search= array();
		$status = optional_param('status', '', PARAM_TEXT);
		$stat = array();
		
		if(empty($searchname)&&empty($status)){
			$baseurl = new moodle_url('/local/scwinterviews/interview.php');
			$offset = $seg * $perpage;
			$count = $DB->count_records_sql("SELECT COUNT(*) FROM {local_scwinterviews} WHERE interview_delete='0'");
			$result = $DB->get_records_sql(" SELECT * FROM {local_scwinterviews} WHERE interview_delete = '0'", array(), $offset, $perpage);
			$paging = $OUTPUT->paging_bar($count , $page , $perpage, $baseurl);
		}
		elseif(!empty($searchname)&&empty($status)){
			$search['search'] = $searchname;
			$baseurl = new moodle_url('/local/scwinterviews/interview.php', $search);
			$offset = $seg * $perpage;
			$count = $DB->count_records_sql("SELECT COUNT(*) FROM {local_scwinterviews} WHERE interview_heading LIKE '%". $search['search'] ."%' AND interview_delete='0'");
			$result = $DB->get_records_sql(" SELECT * FROM {local_scwinterviews} WHERE interview_heading LIKE '%". $search['search']. "%' AND interview_delete='0'", array($search), $offset, $perpage);
			$paging = $OUTPUT->paging_bar($count , $page , $perpage, $baseurl);
		}
		elseif(empty($searchname)&&($status==1 || $status==2))
		{
			if($status == 2){
			$stat['status'] = 0;
			}
			else $stat['status'] = $status;
			$baseurl = new moodle_url('/local/scwinterviews/interview.php', $stat);
			$offset = $seg * $perpage;
			$count = $DB->count_records_sql("SELECT COUNT(*) FROM {local_scwinterviews} WHERE interview_status = '" . $stat['status'] . "' AND interview_delete='0'");
			$result = $DB->get_records_sql(" SELECT * FROM {local_scwinterviews} WHERE interview_status = '" . $stat['status'] . "' AND interview_delete = '0'", array($stat), $offset, $perpage);
			$paging = $OUTPUT->paging_bar($count , $page , $perpage, $baseurl);
		}
		else
		{
			if($status == 2){
			$stat['status'] = 0;
			}
			else $stat['status'] = $status;
			$search['search'] = $searchname;
			$baseurl = new moodle_url('/local/scwinterviews/interview.php', $search, $stat);
			$offset = $seg * $perpage;
			$count = $DB->count_records_sql("SELECT COUNT(*) FROM {local_scwinterviews} WHERE interview_heading LIKE '%". $search['search'] ."%' AND interview_status = '" . $stat['status'] . "' AND interview_delete='0'");
			$result = $DB->get_records_sql(" SELECT * FROM {local_scwinterviews} WHERE interview_heading LIKE '%". $search['search']. "%' AND interview_status = '" . $stat['status'] . "' AND interview_delete='0'", array($search, $stat), $offset, $perpage);
			$paging = $OUTPUT->paging_bar($count , $page , $perpage, $baseurl);
			
			}
	?>
    <div class="search-blk">
		<h4><i class="fa fa-search"></i>INTERVIEW LIST</h4>
		<div class="interviewsearch-fileld">
		<form class="form-inline" action="<?php echo $CFG->wwwroot;?>/local/scwinterviews/interview.php" name="search" id="search">
		<div class="form-group col-lg-4"> <label for="Heading">Heading</label> 
		<input type="text" value="<?php echo $searchname; ?>" name="search" id="search" >
		</div> 
        <div class="form-group col-lg-4"> <label for="Status">Status</label> 
        <select name="status" class="form-control">
        <option value="">---Select---</option>
        <option value="1" <?php echo $status == '1' ? 'selected' : ''?>>Enabled</option>
        <option value="2" <?php echo $status == '2' ? 'selected' : ''?>>Disabled</option>
        </select>
        </div>
		<button class="btn btn-brown" type = "submit">SEARCH</button> 
		</form>
		</div>
		</div>
    
    <form action="edit.php">   
       <input type="submit" value="Add Interview">
 	</form>
		
        <?php
		
		$table = new html_table();
		$table->head = array ();
        $table->colclasses = array();
		$table->head[] = "Action";
		$table->head[] = "ID";
        $table->head[] = "Heading";
        $table->attributes['class'] = 'admintable generaltable';
		$table->head[] = "Content";
		$table->head[] = "Company";
		$table->head[] = "Contact Info";
		$table->head[] = "Expires By";
		$table->head[] = "priority";
		$table->head[] = "Status";
		$table->head[] = "Modified By";
		$table->head[] = "Modified Date";
        foreach ($result as $crow) {
            $row = array();
			$edit_url = $CFG->wwwroot.'/local/scwinterviews/edit.php?id='.$crow->id;
			$row[] = '<a href="'.$edit_url.'">Edit</a>';
			$row[] = $crow->id;
			$row[] = ucfirst($crow->interview_heading);
			$row[] = $crow->summary;
			$row[] = $crow->interview_company;
			$row[] = ucfirst($crow->interview_contact);
			$expires_by = date("d-M-Y", $crow->interview_expires_by);
            $row[] = $expires_by;
			$row[] = $crow->interview_priority;
			$row[] = ($crow->interview_status=="1") ? "Enabled" : "Disabled";
			$muser = core_user::get_user($crow->interview_modified_by);
			$row[] = ucfirst($muser->firstname);
			$row[] = date("M d, Y", $crow->interview_modified);
            $table->data[] = $row;
        }
	
		$output .= html_writer::start_tag('div', array('class'=>'no-overflow'));
        $output .= html_writer::table($table);
        $output .= html_writer::end_tag('div');
		$output .= html_writer::start_tag('div',array('class' => 'custom-pagination'));
		$output .= $paging;
		$output .= html_writer::div('','clearfix'); // clearfix
		$output .= html_writer::end_tag('div'); // custom-pagination end tag

		return $output;
		
	}

 //visible to public
 public function list_interview_page() {
		global $DB,$CFG,$OUTPUT,$PAGE,$USER;
        $page = optional_param('page','0',PARAM_INT);
        $seg = $page;
		$perpage = optional_param('perpage', 5, PARAM_INT);
		$output = '';
		$ctable = 'local_scwinterviews';
		$searchname = optional_param('search', '', PARAM_TEXT);
		$search= array();
		$status = optional_param('status', '0', PARAM_TEXT);
		$stat = array();
		
		$turl = $CFG->wwwroot.'/theme/supplychainwire/pix';

		if(empty($searchname))
		{
			$baseurl = new moodle_url('/local/scwinterviews/interview_list.php');
			$offset = $seg * $perpage;
			$count = $DB->count_records_sql("SELECT COUNT(*) FROM {local_scwinterviews} WHERE interview_delete='0'");
			$result = $DB->get_records_sql(" SELECT * FROM {local_scwinterviews} WHERE interview_delete = '0' ORDER BY interview_priority, interview_created ASC", array(), $offset, $perpage);
			$paging = $OUTPUT->paging_bar($count , $page , $perpage, $baseurl);
		}
		else
		{
			$search['search'] = $searchname;
			$baseurl = new moodle_url('/local/scwinterviews/interview_list.php', $search);
			$offset = $seg * $perpage;
			$count = $DB->count_records_sql("SELECT COUNT(*) FROM {local_scwinterviews} WHERE interview_heading LIKE '%". $search['search'] ."%' AND interview_delete='0'");
			$result = $DB->get_records_sql(" SELECT * FROM {local_scwinterviews} WHERE interview_heading LIKE '%". $search['search']. "%' AND interview_delete='0' ORDER BY interview_priority, interview_created ASC", array($search), $offset, $perpage);
			$paging = $OUTPUT->paging_bar($count , $page , $perpage, $baseurl);
			
			}
		?>
            
<div class="search-blk">
<h4><i class="fa fa-search"></i>INTERVIEW LIST</h4>
<div class="interviewsearch-fileld">
<form class="form-inline" action="<?php echo $CFG->wwwroot;?>/local/scwinterviews/interview_list.php" name="search" id="search">
<div class="form-group"> <label for="exampleInputName2">Interview</label> 
<input type="text" value="<?php echo $searchname; ?>" name="search" id="search" >
</div> 
<button class="btn btn-brown" type = "submit">SEARCH</button> 
</form>
</div>
</div>

<div class="interviewlst-blk">
<h4><i class="fa fa-users"></i>INTERVIEWS</h4>
 <?php foreach ($result as $crow) {?>
<div class="interviewlst-titl-head">
<div class="interviewlst-titl col-lg-10"> 
<h3><?php echo $crow->interview_heading;?></h3>
</div>
<div class="col-lg-2 ">
		<?php 
		$id= $crow->id;
		$url2 = $CFG->wwwroot.'/local/scwinterviews/interview_detailpage.php?id='.$id.'';	
?>
<a href="<?php echo $url2;?>"><button type="button" class="btn btn-sm btn-ashblk pull-right" data-userid="<?php echo $crow->id;?>" >View More</button></a>
</div>
</div>
<div class="interviewlst-contnt-details">
<div class="row">
<div class="col-sm-2 col-md-2 col-lg-1">
<div class="img-transparency">
<img src="<?php echo $turl; ?>/professionimg1.png">
</div>
</div>
<div class="col-sm-10 col-md-10 col-lg-11">
<div class="interviewlst-contnt-title">
<div class="row">
<div class="col-md-12 col-lg-12 padlft-non">
<h5>Company Name :<?php echo $crow->interview_company;?></h5>
</div>
</div>
<img class="titlebtm-bordr" src="<?php echo $turl; ?>/border-btm.png">
</div>
</div>
<?php $description = strip_tags($crow->summary);?>
<p><?php echo substr($description, 0, 350);?>...</p>
</div>
</div>
 <img class="contntbtm-border" src="<?php echo $turl; ?>/border.png">
 <?php }?>
 

<div class="searchreslt-pagination ">
 <?php 
 	echo html_writer::start_tag('div', array('class'=>'custom-pagination'));
	echo $OUTPUT->paging_bar($count, $page, $perpage, $baseurl);
	echo html_writer::end_tag('div');
   ?>
   </div>

</div>
            
	<?php 
		return $output;
	}

}