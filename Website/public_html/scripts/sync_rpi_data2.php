<?php
require_once __DIR__ . '/../../required/db_connect.php';
$input = file_get_contents("php://input");
$error=0;
$out_json = array();
$out_json['success'] = 1; //assume success
$SW1_STATUS=0; $SW2_STATUS=0; $LED1_STATUS=0; $LED2_STATUS=0; $TS_STATUS=0;
if ($input) {
    $json = json_decode($input, true);	//check if it json input
    if (json_last_error() == JSON_ERROR_NONE) {
        if (isset($json["username"]) && isset($json["password"]) && isset($json["SW1"]) && isset($json["SW2"]) && isset($json["LED1"]) && isset($json["LED2"]) && isset($json["TS"])) {
            $in_username = $json["username"];  
            $in_password = $json["password"];  //if the expected fields are not null, get them
            $in_SW1 = $json["SW1"];
            $in_SW2 = $json["SW2"];
            $in_LED1 = $json["LED1"];
            $in_LED2 = $json["LED2"];
			$in_TS = $json["TS"];
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

						 
						 $stmt = $mysqli->prepare("SELECT COUNT(*) FROM active_alarms WHERE ACK = 0 AND alarmID = 8");
						 $stmt->execute();
                         $stmt->bind_result($count_test);
						 $stmt->fetch();
						 $stmt->close();
						 
						 $stmt = $mysqli->prepare("SELECT COUNT(*) FROM active_alarms WHERE ACK = 0 AND alarmID = 9");
						 $stmt->execute();
                         $stmt->bind_result($count_iris);
						 $stmt->fetch();
						 $stmt->close();
						 
						 $stmt = $mysqli->prepare("SELECT COUNT(*) FROM active_alarms WHERE ACK = 0 AND alarmID = 10");
						 $stmt->execute();
                         $stmt->bind_result($count_prox);
						 $stmt->fetch();
						 $stmt->close();
						 
						 $stmt = $mysqli->prepare("SELECT MAX(logID) FROM log");
						 $stmt->execute();
                         $stmt->bind_result($log_num);
						 $stmt->fetch();
						 $stmt->close();
						 
						 $stmt = $mysqli->prepare("SELECT msgID FROM log WHERE logID = $log_num");
						 $stmt->execute();
                         $stmt->bind_result($last_log);
						 $stmt->fetch();
						 $stmt->close();

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						 
                         if ($stmt = $mysqli->prepare("UPDATE senact set STATUS=? where devID = 'SW1'")) { //update SW1
                            $stmt->bind_param('i', $in_SW1); 
                            $stmt->execute();
                         } else {$error=0;}
                            $stmt->close();
							
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                         if (!$error && ($stmt = $mysqli->prepare("SELECT STATUS FROM senact where devID = 'SW1'"))) { //read IRIS
                            $stmt->execute();
                            $stmt->bind_result($SW1_STATUS);
                            $stmt->fetch();
                         } else {$error=1;}
                            $stmt->close();
							
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                            if ($stmt = $mysqli->prepare("UPDATE senact set STATUS=? where devID = 'SW2'")) { //update SW2
                            $stmt->bind_param('i', $in_SW2); 
                            $stmt->execute();
                         } else {$error=2;}
                            $stmt->close();
							
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							
                         if (!$error && ($stmt = $mysqli->prepare("SELECT STATUS FROM senact where devID = 'SW2'"))) { //read PROX
                            $stmt->execute();
                            $stmt->bind_result($SW2_STATUS);
                            $stmt->fetch();
                         } else {$error=3;}
                            $stmt->close();
							
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

						 if (($stmt = $mysqli->prepare("UPDATE senact set STATUS=1 where devID = 'LED2'")) && ($SW1_STATUS == 0) && ($SW2_STATUS == 1) && ($last_log != 5)) { //update LED2
                            $stmt->execute();
                         } else {$error=0;}
                            $stmt->close();
						
                         if (($stmt = $mysqli->prepare("UPDATE senact set STATUS=1 where devID = 'LED2'")) && ($SW1_STATUS == 1) && ($SW2_STATUS == 0) && ($last_log != 5)) { //update LED2
                            $stmt->execute();
                         } else {$error=0;}
                            $stmt->close();
						
							
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							
                         if (!$error && ($stmt = $mysqli->prepare("SELECT STATUS FROM senact where devID = 'LED2'"))) { //read LED2
                             $stmt->execute();
                             $stmt->bind_result($LED2_STATUS);
                             $stmt->fetch();
                         } else {$error=6;}
                            $stmt->close();
							
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
                        if (($stmt = $mysqli->prepare("UPDATE senact set STATUS=1 where devID = 'LED1'")) && ($SW1_STATUS == 1) && ($SW2_STATUS == 1) && ($LED2_STATUS == 0)) { //update LED1
                            $stmt->execute();
                         } else {$error=0;}
                            $stmt->close();
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                         if (!$error && ($stmt = $mysqli->prepare("SELECT STATUS FROM senact where devID = 'LED1'"))) { //read LED1
                             $stmt->execute();
                             $stmt->bind_result($LED1_STATUS);
                             $stmt->fetch();
                         } else {$error=4;}
                            $stmt->close();
							

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
						 if (!$error && ($LED1_STATUS == "1")){
							 if (!$error && ($last_log != 5) && ($LED2_STATUS == "0") && ($SW1_STATUS == "1") && ($SW2_STATUS == "1")){
								 $stmt = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
								 $stmt->bind_param('isis', $logID, $in_TS, $open, $msg);
								 $open = 5;
								 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $open");
								 $data->execute();
								 $data->bind_result($msg);
								 $data->fetch();
								 $data->close();
								 $logID = $log_num + 1;
								 $stmt->execute();
								 $stmt->close();
									 
							 }
							  
							 else if (!$error && ($last_log != 5)){
								 $stmt = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
								 $stmt->bind_param('isis', $logID, $in_TS, $open, $msg);
								 $open = 7;
								 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $open");
								 $data->execute();
								 $data->bind_result($msg);
								 $data->fetch();
								 $data->close();
								 $logID = $log_num + 1;
								 $stmt->execute();
								 $stmt->close();
									 
							 }
							 
						 }
						 
						 if (!$error && ($LED1_STATUS == "0")){
							 if (!$error && ($last_log == 5) && ($LED2_STATUS == "0") && ($SW1_STATUS == "0") && ($SW2_STATUS == "0")){
								 $stmt = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
								 $stmt->bind_param('isis', $logID, $in_TS, $close, $msg);
								 $close = 6;
								 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $close");
								 $data->execute();
								 $data->bind_result($msg);
								 $data->fetch();
								 $data->close();
								 $logID = $log_num + 1;
								 $stmt->execute();
								 $stmt->close();
									 
							 }
						 }
						 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						 
						 if (!$error && ($LED2_STATUS == "1")){
							 if (!$error && ($LED2_STATUS == "1") && ($SW1_STATUS == "0") && ($SW2_STATUS == "0") && ($count_test == 0)){
								 $stmt = $mysqli->prepare("INSERT INTO active_alarms (alarmID, sinceTS, ACK) VALUES (?, ?, ?)");
								 $stmt->bind_param('isi', $alarmID, $in_TS, $ACK); 
								 $alarmID = 8;
								 $ACK = 0;
								 $stmt->execute();
								 $stmt->close();
								 
								 $logID = $log_num + 1;
								 $log = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
								 $log->bind_param('isis', $logID, $in_TS, $alarmID, $msg);
								 
								 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $alarmID");
								 $data->execute();
								 $data->bind_result($msg);
								 $data->fetch();
								 $data->close();
								 
								 $log->execute();
								 $log->close();
							 }
							 else if (!$error && ($LED2_STATUS == "1") &&  ($SW1_STATUS == "0") && ($SW2_STATUS == "1") && ($count_iris == 0)){
								 $stmt = $mysqli->prepare("INSERT INTO active_alarms (alarmID, sinceTS, ACK) VALUES (?, ?, ?)");
								 $stmt->bind_param('isi', $alarmID, $in_TS, $ACK); 
								 $alarmID = 9;
								 $ACK = 0;
								 $stmt->execute();
								 $stmt->close();
								 
								 $logID = $log_num + 1;
								 $log = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
								 $log->bind_param('isis', $logID, $in_TS, $alarmID, $msg);
								 
								 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $alarmID");
								 $data->execute();
								 $data->bind_result($msg);
								 $data->fetch();
								 $data->close();
								 
								 $log->execute();
								 $log->close();
							 }
							 else if (!$error && ($LED2_STATUS == "1") &&  ($SW1_STATUS == "1") && ($SW2_STATUS == "0")&& ($count_prox == 0)){
								 $stmt = $mysqli->prepare("INSERT INTO active_alarms (alarmID, sinceTS, ACK) VALUES (?, ?, ?)");
								 $stmt->bind_param('isi', $alarmID, $in_TS, $ACK); 
								 $alarmID = 10;
								 $ACK = 0;
								 $stmt->execute();
								 $stmt->close();
								 
								 $logID = $log_num + 1;
								 $log = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
								 $log->bind_param('isis', $logID, $in_TS, $alarmID, $msg);
								 
								 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $alarmID");
								 $data->execute();
								 $data->bind_result($msg);
								 $data->fetch();
								 $data->close();
								 
								 $log->execute();
								 $log->close();
							 }
							 else if (!$error && ($LED2_STATUS == "1") &&  ($SW1_STATUS == "1") && ($SW2_STATUS == "1") && ($count_test == 0)){
								 $stmt = $mysqli->prepare("INSERT INTO active_alarms (alarmID, sinceTS, ACK) VALUES (?, ?, ?)");
								 $stmt->bind_param('isi', $alarmID, $in_TS, $ACK); 
								 $alarmID = 8;
								 $ACK = 0;
								 $stmt->execute();
								 $stmt->close();
								 
								 $logID = $log_num + 1;
								 $log = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
								 $log->bind_param('isis', $logID, $in_TS, $alarmID, $msg);
								 
								 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $alarmID");
								 $data->execute();
								 $data->bind_result($msg);
								 $data->fetch();
								 $data->close();
								 
								 $log->execute();
								 $log->close();
							 }
						 }
						 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    } else {$error=7;}
                } else {$error=8;}
            } else {$error=9;}
        } else {$error=10;}
    } else {$error=11;}
} else {$error=12;}
if ($error){
   $out_json['success'] = 0; 	//flag failure
}
$out_json['SW1'] = $SW1_STATUS;
$out_json['SW2'] = $SW2_STATUS;
$out_json['LED1'] = $LED1_STATUS; 
$out_json['LED2'] = $LED2_STATUS;
$TS_STATUS = $in_TS;
$out_json['TS']= $TS_STATUS;
$out_json['error'] = $error;  //provide error (if any) number for debugging
echo json_encode($out_json);  //encode the data in json format
?>
