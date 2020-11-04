<?php
require_once __DIR__ . '/../required/db_connect.php';
?>

		<?php
		if ($stmt=$mysqli->prepare("SELECT function, type, STATUS FROM senact LIMIT 100")) {
		$stmt->execute();
		$stmt->bind_result($function,$type,$STATUS);
		echo "<table>
				<tr>";
				
		echo "<th>Component</th>";
		echo "<th>Type</th>";
		echo "<th>Status</th>";
		echo "</tr>";
		
		while ($stmt->fetch()) {
			echo "<tr>";
		echo "<td>". $function .	"</td>";
		echo "<td>" .$type.	"</td>";
		echo "<td>" .$STATUS 	.	"</td>";
		echo "</tr>";
		}
		$stmt->close();
		}
		else {
		echo "error";
		$mysqli->close();
		}
		echo "</table>";
/////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		echo "</br>";
		echo "</br>";
		
		echo "</br>";
	
		echo "</br>";
		echo "</br>";
		
/////////////////////////////////////////////////////////////////////////////////////////////////////
		if ($stmt=$mysqli->prepare("SELECT * FROM active_alarms ORDER BY sinceTS ASC LIMIT 100")) {
		$stmt->execute();
		$stmt->bind_result($alarmID,$sinceTS,$ACK);
		echo "<table>
				<tr>";
				
		echo "<th>AlarmID</th>";
		echo "<th>sinceTS</th>";
		echo "<th>ACK</th>";
		echo "</tr>";
		
		while ($stmt->fetch()) {
			echo "<tr>";
		echo "<td>". $alarmID .	"</td>";
		echo "<td>" .$sinceTS.	"</td>";
		echo "<td>" .$ACK 	.	"</td>";
		echo "</tr>";
		}
		$stmt->close();
		}
		else {
		echo "error";
		$mysqli->close();
		}
		echo "</table>";
/////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		echo "</br>";
		echo "</br>";
		
		echo "</br>";
	
		echo "</br>";
		echo "</br>";
		
/////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if ($stmt=$mysqli->prepare("SELECT * FROM log ORDER BY logID desc LIMIT 100")) {
		$stmt->execute();
		$stmt->bind_result($logID,$TS,$msgID,$data);
		echo "<table>
				<tr>";
				
		echo "<th>LogID</th>";
		echo "<th>TS</th>";
		echo "<th>MsgID</th>";
		echo "<th>Data</th>";
		echo "</tr>";
		
		while ($stmt->fetch()) {
		echo "<tr>";
		echo "<td>". $logID .	"</td>";
		echo "<td>" .$TS.		"</td>";
		echo "<td>" .$msgID 	."</td>";
		echo "<td>" .$data 	.	"</td>";
		echo "</tr>";
		}
		$stmt->close();
		}
		else {
		echo "error";
		$mysqli->close();
		}
		echo "</table>";
		?>