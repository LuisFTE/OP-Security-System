<?php
require_once __DIR__ . '/../../required/db_connect.php';
$input = file_get_contents("php://input");
session_start();
session_unset();
session_destroy();
$stmt = $mysqli->prepare("SELECT MAX(logID) FROM log");
$stmt->execute();
$stmt->bind_result($log_num);
$stmt->fetch();
$stmt->close();

$logID = $log_num + 1;
$log = $mysqli->prepare("INSERT INTO log (logID, TS, msgID, data) VALUES (?, ?, ?, ?)");
$log->bind_param('isis', $logID, $in_TS, $msgID, $msg);
$msgID = 4;
date_default_timezone_set("America/Chicago");
$in_TS = date("Y-m-d H:i:s");
$data = $mysqli->prepare("SELECT msgDesc FROM msgs WHERE msgID = $msgID");
$data->execute();
$data->bind_result($msg);
$data->fetch();
$data->close();

$log->execute();
$log->close();
header("Location: https://luistamborrell.000webhostapp.com/index.php");

?>