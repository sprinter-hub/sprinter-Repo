
<?php
/*
 * @author saitulasiram
 * @author prakash
 */
require 'private/funcs.php';

if(isset($_REQUEST['submit'])){

	$conn = db_connect();
	
	$usersarray = array();
	$username = $_REQUEST['username'];//"one@mail.com";
    $userid = getUserId($conn,$username);
   
    
    $activeusers = getActiveUsers($conn,$userid);
    //echo "data recived encode is ::: ".json_encode($activeusers);
    
    foreach($activeusers as $val){
       //echo "userid : " . $val['userId'] . "<br />";
       $userdetails = getUserDetails($conn,$val['userId']);
       //echo "userdetails are ".json_encode($userdetails); 
       
       array_push($usersarray,$userdetails);
    }
	//$randomusers = getRandomUsers($conn, $username);

   // echo "total ol users are :::: ".json_encode($usersarray); 
    
    
    $friends = getFriends($conn,$userid);
    
    //echo "friends are ::: ".stripslashes(json_encode($friends));
    
    $friendsarray = array();
    
    $arr = json_decode(stripslashes(json_encode($friends)));
    
    foreach($arr as $val){
    $frnddetails = getUserDetails($conn,$val);
    array_push($friendsarray,$frnddetails);
        //echo $val;
    }
    
   // echo "all frnd details are ::: ".json_encode($friendsarray)."\n";
    
  //  echo "\n ****************************** \n";
    
    $diffarray = array();
    $diffarray = array_diff($friendsarray,$usersarray);
    //echo "the result is ".json_encode($diffarray);
    $diff = array();
    // get differences that in ary_1 but not in ary_2
  foreach ( $usersarray as $v1 ) {
    $flag = 0;
    foreach ( $friendsarray as $v2 ) {
      $flag |= ( $v1 == $v2 );
      if ( $flag ) break;
    }
    if ( !$flag ) array_push( $diff, $v1 );
  }
    
    echo json_encode($diff);
    db_disconnect($conn);
	
	//echo $randomusers;
	}
?>
