<?php 

require_once 'funcs.php';

	$conn = db_connect();
	
	$username = "two@mail.com";

	$array_frndids = array();
	
	$randomusers = getRandomUsers($conn, $username);
	
	$randomusers;
	
	//$facebookusers = getRandomUsers($conn, $username);
	
	$userid = getUserId($conn, $username);
	
	$list = getFriends($conn, $userid);
	
	$list1 = json_decode($list);
	
	foreach($list1 as $val){
		array_push($array_frndids, $val);
		//echo $val;
	}	
	
	$details_array = array();
	
	foreach ($array_frndids as $va){
		
		$details = getUserDetails($conn, $va);
		//echo "\n".$details;
		//echo json_decode($details)."\n";
		//echo json_encode($details)."\n";
		array_push($details_array, $details);
	}
	//echo $randomusers;

	/*
	 $json = json_decode($randomusers,true);
    foreach ($details as $val){
    	echo $details;
    	$match = $details;
    	unset($json['data'][array_search($match, $json['data'])]);
    }
    echo json_encode($json);
    */
    
    
    $data = json_decode($details);
    
    foreach ($data as $key => $value){
    	echo $key." ****  ";
    	echo $value."  *** ";
    }
    
    
    $json = json_decode($randomusers,true);
    
    foreach ($details_array as $details1){
    	
    	foreach ($details1 as $k => $v){
    		if($k == 'username'){
    			$match = array('username'=>$v);
    			unset($json['data'][array_search($match, $json['data'])]);
    		}
    	}
    }
    
    
    echo json_encode($json);
    
    
    

?>