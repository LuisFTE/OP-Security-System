<!DOCTYPE html>

<html>
	<head>
		<title>OP Security System</title>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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
	  <a class="active" href="#"><i class="fa fa-bullhorn"></i></a> 
	  <a href="https://luistamborrell.000webhostapp.com/iris.php#"><i class="fa fa-eye"></i></a> 
	  <a href="https://luistamborrell.000webhostapp.com/prox.php#"><i class="fa fa-bullseye"></i></a>
	  <a href="https://luistamborrell.000webhostapp.com/logout.php#"><i class="fa fa-user-o"></i></a> 
	</div>
	

		
	
	<center><div id ="active"></div></center>
	<script>
				
		$(document).ready(function() { //once the page is ready, runs the code
			setInterval(function() { //calls the function to be executed
				$('#active').load('active_alarms.php') //loads info from DBpeople.php into this DIV
			}, 7000); //repeat every 3000 milliseconds
		});
	</script>
	

	
	</body>
</html>