<?php
if (isset($_POST['login'])){
    require_once __DIR__ . '/../../required/db_connect.php';
    $username = $_POST['uname'];
    $password = $_POST['psw'];
    if ($stmt=$mysqli->prepare("SELECT password FROM webuser WHERE pname = ? LIMIT 1")) {
                 $stmt->bind_param('s', $username);
                 $stmt->execute(); 
                 $stmt->store_result();	//store_result to get num_rows etc.
                 $stmt->bind_result($db_password);	//get the hashed password
                 $stmt->fetch();
                if ($stmt->num_rows == 1) {		//if user exists, verify the password
                    if (password_verify($password, $db_password)) {
			             $stmt->close();
						 
						 $stmt = $mysqli->prepare("SELECT MAX(logID) FROM log");
						 $stmt->execute();
                         $stmt->bind_result($log_num);
						 $stmt->fetch();
						 $stmt->close();
						 
						 $logID = $log_num + 1;
						 $log = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
						 $log->bind_param('isis', $logID, $in_TS, $msgID, $msg);
						 $msgID = 2;
						 date_default_timezone_set("America/Chicago");
		                 $in_TS = date("Y-m-d H:i:s");
						 $in_TS = date("Y-m-d H:i:s");
						 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $msgID");
						 $data->execute();
						 $data->bind_result($msg);
						 $data->fetch();
						 $data->close();
						 
						 $log->execute();
						 $log->close();
						 
			            session_start();
			            $_SESSION['userID'] = $username;
			            header("Location: https://luistamborrell.000webhostapp.com/indexloggedin.php");
						
                    }
                    else{
                        header("Location: https://luistamborrell.000webhostapp.com/login.php?error=wrongpassword");
						$stmt = $mysqli->prepare("SELECT MAX(logID) FROM log");
						 $stmt->execute();
                         $stmt->bind_result($log_num);
						 $stmt->fetch();
						 $stmt->close();
						 
						 $logID = $log_num + 1;
						 $log = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
						 $log->bind_param('isis', $logID, $in_TS, $msgID, $msg);
						 $msgID = 3;
						 
						 date_default_timezone_set("America/Chicago");
	                	$in_TS = date("Y-m-d H:i:s");
						 $in_TS = date("Y-m-d H:i:s");
						 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $msgID");
						 $data->execute();
						 $data->bind_result($msg);
						 $data->fetch();
						 $data->close();
						 
						 $log->execute();
						 $log->close();
                    }
                }
                else{
                    header("Location: https://luistamborrell.000webhostapp.com/login.php?error=wrongusername");
					$stmt = $mysqli->prepare("SELECT MAX(logID) FROM log");
						 $stmt->execute();
                         $stmt->bind_result($log_num);
						 $stmt->fetch();
						 $stmt->close();
						 
						 $logID = $log_num + 1;
						 $log = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
						 $log->bind_param('isis', $logID, $in_TS, $msgID, $msg);
						 $msgID = 3;
						 date_default_timezone_set("America/Chicago");
		                 $in_TS = date("Y-m-d H:i:s");
						 $in_TS = date("Y-m-d H:i:s");
						 $data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $msgID");
						 $data->execute();
						 $data->bind_result($msg);
						 $data->fetch();
						 $data->close();
						 
						 $log->execute();
						 $log->close();
                }
    }   
}
