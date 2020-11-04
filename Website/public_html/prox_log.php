<?php
require_once __DIR__ . '/../required/db_connect.php';
?>

		<?php
		if ($stmt=$mysqli->prepare("SELECT logID, TS FROM log WHERE msgID=10 LIMIT 100")) {
		$stmt->execute();
		$stmt->bind_result($logID,$TS);
		echo "<table>
				<tr>";
				
		echo "<th>LogID</th>";
		echo "<th>TS</th>";
		echo "</tr>";
		
		while ($stmt->fetch()) {
			echo "<tr>";
		echo "<td>". $logID .	"</td>";
		echo "<td>" .$TS.	"</td>";
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