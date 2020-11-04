<?php
require_once __DIR__ . '/../../required/db_connect.php';
$input = file_get_contents("php://input");
$error=0; 
$out_json = array(); 
$out_json['success'] = 1; //assume success
$SW1_STATUS=0;
$LED1_STATUS=0;
$SW1_STATUS=0;
$LED1_STATUS=0;
$ACK_STATUS=0;
if ($input) {
    $json = json_decode($input, true);	//check if it json input
    if (json_last_error() == JSON_ERROR_NONE) {
        if (isset($json["username"]) && isset($json["password"]) && isset($json["SW1"]) && isset($json["LED1"]) && isset($json["SW2"]) && isset($json["LED2"]) && isset($json["ACK"])) {
            $in_username = $json["username"];  
            $in_password = $json["password"];  //if the expected fields are not null, get them
            $in_SW1 = $json["SW1"];
            $in_LED1 = $json["LED1"];
			$in_SW2 = $json["SW2"];
            $in_LED2 = $json["LED2"];
			$in_ACK = $json["ACK"];
            if ($stmt=$mysqli->prepare("SELECT password FROM webuser WHERE pname = ? LIMIT 1")) {
                $stmt->bind_param('s', $in_username);
                $stmt->execute();  
				$stmt->store_result();	//store_result to get num_rows etc.
                $stmt->bind_result($db_password);	//get the hashed password
                $stmt->fetch();
                if ($stmt->num_rows == 1) {		//if user exists, verify the password
                    if (password_verify($in_password, $db_password)) {
						$stmt->close();
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						 if ($stmt = $mysqli->prepare("UPDATE senact set STATUS=? where devID = 'LED1'")) { //update LED1
						 $stmt->bind_param('i', $in_LED1);
						 $stmt->execute();
						 } else {$error=11;} 
						 $stmt->close();
						  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						 if ($stmt = $mysqli->prepare("UPDATE senact set STATUS=? where devID = 'LED2'")) { //update LED2
						 $stmt->bind_param('i', $in_LED2);
						 $stmt->execute();
						 } else {$error=12;} 
						 $stmt->close();

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						 if ($stmt = $mysqli->prepare("UPDATE active_alarms set ACK=? where ACK = 0 AND sinceTS = (SELECT sinceTS FROM active_alarms ORDER BY sinceTS DESC LIMIT 1)")) { //update ACK
						 $stmt->bind_param('i', $in_ACK);
						 $stmt->execute();
						 } else {$error=12;} 
						 $stmt->close();
						 
						 if ($stmt = $mysqli->prepare("DELETE FROM active_alarms where ACK = 1 AND sinceTS = (SELECT sinceTS FROM active_alarms ORDER BY sinceTS DESC LIMIT 1)")) { //update ACK
						 $stmt->execute();
						 } else {$error=12;} 
						 $stmt->close();
						  					  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						  
						  
						  if (!$error && ($stmt = $mysqli->prepare("SELECT STATUS FROM senact where devID = 'SW1'"))) { //read SW1 
						  $stmt->execute();
						  $stmt->bind_result($SW1_STATUS);
						  $stmt->fetch();
						  } else {$error=21;}
						  $stmt->close();
						  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						  
						  
						  if (!$error && ($stmt = $mysqli->prepare("SELECT STATUS FROM senact where devID = 'SW2'"))) { //read SW2 
						  $stmt->execute();
						  $stmt->bind_result($SW2_STATUS);
						  $stmt->fetch();
						  } else {$error=22;}
						  $stmt->close();
						  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						  
						  
						  if (!$error && ($stmt = $mysqli->prepare("SELECT STATUS FROM senact where devID = 'LED1'"))) { //read LED1
						  $stmt->execute();
						  $stmt->bind_result($LED1_STATUS);
						  $stmt->fetch();
						  } else {$error=31;}
						  $stmt->close();

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						  
						  
						  if (!$error && ($stmt = $mysqli->prepare("SELECT STATUS FROM senact where devID = 'LED2'"))) { //read LED1
						  $stmt->execute();
						  $stmt->bind_result($LED2_STATUS);
						  $stmt->fetch();
						  } else {$error=32;}
						  $stmt->close();

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////						  
						  
						  if (!$error && ($stmt = $mysqli->prepare("SELECT ACK FROM active_alarms where sinceTS = (SELECT sinceTS FROM active_alarms ORDER BY sinceTS DESC LIMIT 1)"))) { //read ACK
						  $stmt->execute();
						  $stmt->bind_result($ACK_STATUS);
						  $stmt->fetch();
						  } else {$error=77;}
						  $stmt->close();
						  
			  			  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			  			  
			  
                    } else {$error=4;}
                } else {$error=5;}
            } else {$error=6;}
        } else {$error=7;}
    } else {$error=8;}
} else {$error=9;}
if ($error){
   $out_json['success'] = 0; 	//flag failure
}
$out_json['SW1'] = $SW1_STATUS;
$out_json['LED1'] = $LED1_STATUS;
$out_json['SW2'] = $SW2_STATUS;
$out_json['LED2'] = $LED2_STATUS;  
$out_json['ACK'] = $ACK_STATUS;  
$out_json['error'] = $error;  //provide error (if any) number for debugging
echo json_encode($out_json);  //encode the data in json format
?>
