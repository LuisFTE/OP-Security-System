<!DOCTYPE html>
<?php
require_once __DIR__ . '/../required/db_connect.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE)or die($mysqli->error);

	$data1 = '';
	
	

	//query to get data from the table
	$sql = "SELECT * FROM log WHERE msgID=10";
    $result = mysqli_query($mysqli, $sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {

		$data1 = $data1 . '"'. $row['logID'].'",';
		
		
	}

	$data1 = trim($data1,",");
	
	
?>
<html>
	<head>
		<title>OP Security System</title>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
	</head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
    body, html {
    background-color:black;
    color:white;
    height: 100%;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    }

	.icon-bar {
	  width: 100%;
	  background-color: #555;
	  overflow: auto;
	}

	.icon-bar a {
	  float: left;
	  width: 20%;
	  text-align: center;
	  padding: 12px 0;
	  transition: all 0.3s ease;
	  color: white;
	  font-size: 36px;
	}

	.icon-bar a:hover {
	  background-color: #000;
	}

	.active {
	  background-color: #ff0000;
	}
	table {
	  border-collapse: collapse;
	  border-spacing: 0;
	  width: 100%;
	  border: 1px solid #ddd;
	}
    th, td {
      text-align: left;
      padding: 16px;
    }
    
    tr:nth-child(even) {
      background-color: #990000;
    }
	</style>
	<body>

	<div class="icon-bar">
	  <a href="https://luistamborrell.000webhostapp.com/indexloggedin.php#"><i class="fa fa-home"></i></a> 
	  <a href="https://luistamborrell.000webhostapp.com/alarms.php#"><i class="fa fa-bullhorn"></i></a> 
	  <a href="https://luistamborrell.000webhostapp.com/iris.php#"><i class="fa fa-eye"></i></a> 
	  <a class="active" href="#"><i class="fa fa-bullseye"></i></a>
	  <a href="https://luistamborrell.000webhostapp.com/logout.php#"><i class="fa fa-user-o"></i></a> 
	</div>
	
	
	<canvas id="chart" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>

			<script>
				var ctx = document.getElementById("chart").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'line',
		        data: {
		            labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
		            datasets: 
		            [{
		                label: "Proximity Fab Alarms",
		                data: [<?php echo $data1; ?>],
		                backgroundColor: 'transparent',
		                borderColor:'rgba(255,99,132)',
		                borderWidth: 3
		            }]

		        }
		        
		    });
			</script>

	        <center><div id ="active"></div></center>
			<script>
						
				$(document).ready(function() { //once the page is ready, runs the code
					setInterval(function() { //calls the function to be executed
						$('#active').load('prox_log.php') //loads info from DBpeople.php into this DIV
					}, 7000); //repeat every 3000 milliseconds
				});
			</script>
	
	</body>
</html>