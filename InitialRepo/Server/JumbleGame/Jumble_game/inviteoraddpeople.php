<?php 

require 'private/funcs.php';

	if(isset($_REQUEST['data']){
		
		$conn = db_connect();
		
		$facebookids = $_REQUEST['data'];
		
		$decoded_facebookids = json_decode($facebookids);
		
		$existingfacebookids = array();
		
		foreach ($decoded_facebookids as $val){
			if(isFBUserExists($conn, $val)){
				array_push($existingfacebookids,$val);
			}
		}
		
		echo json_encode($existingfacebookids);
	}
	else{
	    echo "input null";
	}

?>
