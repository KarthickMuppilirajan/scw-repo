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
 * @package local-mylinks
 * @author Fourbends Dev Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 
function mylinks_search_user($profession,$country,$industry,$farea,$per_page,$offset){
	global $DB,$CFG,$OUTPUT,$USER; 
	$userid = $USER->id;
	//query
	$SELECT ="SELECT U.*,UD.* FROM {user_details} UD JOIN {user} U ON (U.id=UD.user_id)";
	$LIMIT = " ORDER BY U.id DESC LIMIT $offset ,$per_page";
	$WHERE = " AND U.suspended!='1' and  U.deleted != '1' AND UD.is_searchable='1' AND UD.approval_status = '1'";
	if($profession && $country && $industry && $farea){
		$sql= $SELECT."WHERE UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else if($profession && $country && $industry){
		$sql= $SELECT."WHERE UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry)";
		$sql.= $WHERE;
		$sql.=$LIMIT;		
	}else if($profession && $country && $farea){
		$sql= $SELECT."WHERE UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$farea',UD.functional_area)";	
		$sql.= $WHERE;	
		$sql.=$LIMIT;
	}else if($profession && $industry && $farea){
		$sql= $SELECT."WHERE UD.profession=$profession AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;		
		$sql.=$LIMIT;
	}else if($country && $industry && $farea){
		$sql= $SELECT."WHERE U.country='$country' AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";	
		$sql.= $WHERE;	
		$sql.=$LIMIT;
	}else if($profession && $country){
		$sql= $SELECT."WHERE UD.profession=$profession AND U.country='$country'";
		$sql.= $WHERE;		
		$sql.=$LIMIT;
	}else if($profession && $industry ){
		$sql= $SELECT."WHERE UD.profession=$profession AND FIND_IN_SET('$industry', UD.industry)";
		$sql.= $WHERE;		
		$sql.=$LIMIT;
	}else if($profession && $farea){
		$sql= $SELECT."WHERE UD.profession=$profession AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else if($country && $industry){
		$sql= $SELECT."WHERE U.country='$country' AND FIND_IN_SET('$industry', UD.industry)";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else if($country && $farea){
		$sql= $SELECT."WHERE U.country='$country' AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else if($industry && $farea){
		$sql= $SELECT."WHERE FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else if($country){
		$sql= $SELECT."WHERE U.country='$country'";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else if($profession){
		$sql= $SELECT."WHERE UD.profession=$profession";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else if($industry){
		$sql= $SELECT."WHERE FIND_IN_SET('$industry', UD.industry)";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else if($farea){
		$sql= $SELECT."WHERE FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
		$sql.=$LIMIT;
	}else{
		$sql =$SELECT." WHERE U.suspended!='1' and  U.deleted != '1' AND UD.is_searchable='1' AND UD.approval_status = '1'";	
		
		$sql.=$LIMIT;
	}
	//echo $sql;	
	$result = $DB->get_records_sql($sql);
	
	return $result;
	
}

function mylinks_search_user_count($profession,$country,$industry,$farea){
	global $DB,$CFG,$OUTPUT,$USER; 
	$userid = $USER->id;
	//query
	$SELECT ="SELECT U.*,UD.* FROM {user_details} UD JOIN {user} U ON (U.id=UD.user_id)";
	//$LIMIT = " LIMIT $offset ,$per_page";
	$WHERE = " AND U.suspended!='1' and  U.deleted != '1' AND UD.is_searchable='1' AND UD.approval_status = '1'";
	
	if($profession && $country && $industry && $farea){
		$sql= $SELECT."WHERE UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
	}else if($profession && $country && $industry){
		$sql= $SELECT."WHERE UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry)";
		$sql.= $WHERE;
	}else if($profession && $country && $farea){
		$sql= $SELECT."WHERE UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$farea',UD.functional_area)";	
		$sql.= $WHERE;	
	}else if($profession && $industry && $farea){
		$sql= $SELECT."WHERE UD.profession=$profession AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";	
		$sql.= $WHERE;	
	}else if($country && $industry && $farea){
		$sql= $SELECT."WHERE U.country='$country' AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;		
	}else if($profession && $country){
		$sql= $SELECT."WHERE UD.profession=$profession AND U.country='$country'";
		$sql.= $WHERE;		
	}else if($profession && $industry ){
		$sql= $SELECT."WHERE UD.profession=$profession AND FIND_IN_SET('$industry', UD.industry)";
		$sql.= $WHERE;		
	}else if($profession && $farea){
		$sql= $SELECT."WHERE UD.profession=$profession AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
	}else if($country && $industry){
		$sql= $SELECT."WHERE U.country='$country' AND FIND_IN_SET('$industry', UD.industry)";
		$sql.= $WHERE;
	}else if($country && $farea){
		$sql= $SELECT."WHERE U.country='$country' AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
	}else if($industry && $farea){
		$sql= $SELECT."WHERE FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
	}else if($country){
		$sql= $SELECT."WHERE U.country='$country'";
		$sql.= $WHERE;
	}else if($profession){
		$sql= $SELECT."WHERE UD.profession=$profession";
		$sql.= $WHERE;
	}else if($industry){
		$sql= $SELECT."WHERE FIND_IN_SET('$industry', UD.industry)";
		$sql.= $WHERE;
	}else if($farea){
		$sql= $SELECT."WHERE FIND_IN_SET('$farea',UD.functional_area)";
		$sql.= $WHERE;
	}else{
		$sql =$SELECT."WHERE U.suspended!='1' and  U.deleted != '1' AND UD.is_searchable='1' AND UD.approval_status = '1'";	
		
	}
		$result = $DB->get_records_sql($sql);
		
		return count($result);	
}

 function get_connection_status($user_id){
		global $DB,$CFG,$OUTPUT,$USER;
		$userid = $USER->id;
		$ctable = 'local_mylinks';
		$result = $DB->get_record_sql("SELECT * from {local_mylinks} WHERE connected_id = $user_id AND user_id=$userid");
		if($result)
		return $result;
	}
	
	function connected_users($profession,$name,$country,$industry,$farea,$per_page,$offset) {
		global $DB,$CFG,$OUTPUT,$USER;

		if($profession==3){
			$profession="";
		}
		$userid = $USER->id;
				
		$ctable = 'local_mylinks';
		$WHERE = " AND U.suspended!='1' and  U.deleted != '1' ";
		$LIKE="";
		
		if($profession && $country && $industry && $farea){
			$LIKE="AND UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($profession && $country && $industry){
			$LIKE="AND UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry)";
			
		}else if($profession && $country && $farea){
			$LIKE="AND UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$farea',UD.functional_area)";	
				
		}else if($profession && $industry && $farea){
			$LIKE="AND UD.profession=$profession AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";	
				
		}else if($country && $industry && $farea){
			$LIKE="AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
					
		}else if($profession && $country){
			$LIKE="AND UD.profession=$profession AND U.country='$country'";
					
		}else if($profession && $industry ){
			$LIKE="AND UD.profession=$profession AND FIND_IN_SET('$industry', UD.industry)";
					
		}else if($profession && $farea){
			$LIKE="AND UD.profession=$profession AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($country && $industry){
			$LIKE="AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry)";
			
		}else if($country && $farea){
			$LIKE="AND U.country='$country' AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($industry && $farea){
			$LIKE="AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($country){
			$LIKE="AND U.country='$country'";
			
		}else if($profession){
			$LIKE="AND UD.profession=$profession";
			
		}else if($industry){
			$LIKE="AND FIND_IN_SET('$industry', UD.industry)";
			
		}else if($farea){
			$LIKE="AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($name){
			$LIKE="AND CONCAT( U.firstname,  ' ', U.lastname ) LIKE  '%$name%'";
		}

		$sql="SELECT  U.*,ML.*,UD.profession,UD.summary as summary FROM {local_mylinks} ML JOIN {user} U JOIN {user_details} UD ON (U.id=ML.connected_id) AND (UD.user_id=ML.connected_id) WHERE ML.user_id=$userid ".$WHERE." ".$LIKE." group by U.id order by connection_status ASC LIMIT $per_page OFFSET $offset";
		
		$result = $DB->get_records_sql($sql);
		
		return $result;
	}	
	
		
		function connected_users_count($profession,$name,$country,$industry,$farea) {
		global $DB,$CFG,$OUTPUT,$USER;

		if($profession==3){
			$profession="";
		}
		
		$userid = $USER->id;
				
		$ctable = 'local_mylinks';
		$WHERE = " AND U.suspended!='1' and  U.deleted != '1' ";
		$LIKE="";
		
		if($profession && $country && $industry && $farea){
			$LIKE="AND UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($profession && $country && $industry){
			$LIKE="AND UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry)";
			
		}else if($profession && $country && $farea){
			$LIKE="AND UD.profession=$profession AND U.country='$country' AND FIND_IN_SET('$farea',UD.functional_area)";	
				
		}else if($profession && $industry && $farea){
			$LIKE="AND UD.profession=$profession AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";	
				
		}else if($country && $industry && $farea){
			$LIKE="AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
					
		}else if($profession && $country){
			$LIKE="AND UD.profession=$profession AND U.country='$country'";
					
		}else if($profession && $industry ){
			$LIKE="AND UD.profession=$profession AND FIND_IN_SET('$industry', UD.industry)";
					
		}else if($profession && $farea){
			$LIKE="AND UD.profession=$profession AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($country && $industry){
			$LIKE="AND U.country='$country' AND FIND_IN_SET('$industry', UD.industry)";
			
		}else if($country && $farea){
			$LIKE="AND U.country='$country' AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($industry && $farea){
			$LIKE="AND FIND_IN_SET('$industry', UD.industry) AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($country){
			$LIKE="AND U.country='$country'";
			
		}else if($profession){
			$LIKE="AND UD.profession=$profession";
			
		}else if($industry){
			$LIKE="AND FIND_IN_SET('$industry', UD.industry)";
			
		}else if($farea){
			$LIKE="AND FIND_IN_SET('$farea',UD.functional_area)";
			
		}else if($name){
			$LIKE="AND CONCAT( U.firstname,  ' ', U.lastname ) LIKE  '%$name%'";
		}
		
		 $sql="SELECT  U.*,ML.*,UD.summary as summary FROM {local_mylinks} ML JOIN {user} U JOIN {user_details} UD ON (U.id=ML.connected_id) AND (UD.user_id=ML.connected_id) WHERE ML.user_id=$userid ".$WHERE." ".$LIKE." order by connection_status ASC ";
		
		$result = $DB->get_records_sql($sql);
		
		return count($result);
	}		
function mylinks_get_user_profile($userid){
	global $DB,$CFG,$OUTPUT,$USER;
	$sql="SELECT  U.*,UD.* FROM {user} U JOIN {user_details} UD ON (U.id=UD.user_id)  WHERE UD.user_id=$userid ";
	$result = $DB->get_record_sql($sql);
	
	return $result;
}
function mylinks_get_user($user_id){
	global $DB,$CFG,$OUTPUT,$USER;
	$user = $DB->get_record('user', array('id'=>$user_id));
	return $user;
}
function mylink_get_county($key){
	$countries = get_string_manager()->get_list_of_countries(true);
	echo $countries[$key];

}

function mylinks_getresume_url($uid){
	global $CFG;
    $systemcontext = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($systemcontext->id, 'local_scwbanner', 'resume', $uid,'filename', false);
	$filestr = '';
    foreach ($files as $file) {
        $filename = $file->get_filename();
	
        $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(),
                    $file->get_component(), $file->get_filearea(),
                    $file->get_itemid(), $file->get_filepath(), $file->get_filename());
		$filestr = $fileurl->__toString();
		
    }
	return $filestr;
}
?>