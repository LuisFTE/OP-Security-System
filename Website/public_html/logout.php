<!DOCTYPE html>

<html>
	<head>
		<title>OP Security System</title>
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
	button {
      background-color: red;
      color: black;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
    }
    
    button:hover {
      opacity: 0.8;
    }
	
    
	</style>
	<body>
	<div class="icon-bar">
	  <a href="https://luistamborrell.000webhostapp.com/indexloggedin.php#"><i class="fa fa-home"></i></a> 
	  <a href="https://luistamborrell.000webhostapp.com/alarms.php#"><i class="fa fa-bullhorn"></i></a> 
	  <a href="https://luistamborrell.000webhostapp.com/iris.php#"><i class="fa fa-eye"></i></a> 
	  <a href="https://luistamborrell.000webhostapp.com/prox.php#"><i class="fa fa-bullseye"></i></a>
	  <a class="active" href="#"><i class="fa fa-user-o"></i></a> 
	</div>
	<center><h2>Log Out</h2></center>
	<br/>
	<br/>
	<br/>
	
    <form action="scripts/logout_script.php" method="post">
    <center><button type="submit" style="width:auto;">Log Out</button></center>
	</form>
	
	</body>
</html>