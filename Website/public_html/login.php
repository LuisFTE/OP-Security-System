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
	
	.error {
	    color:red;
	    
	}
	
	input[type=text], input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    
    /* Set a style for all buttons */
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
    
    /* Extra styles for the cancel button */
    .cancelbtn {
      width: auto;
      padding: 10px 18px;
      background-color: #f44336;
    }
    
    /* Center the image and position the close button */
    .imgcontainer {
      text-align: center;
      margin: 24px 0 12px 0;
      position: relative;
    }
    
    img.avatar {
      width:800;
      height:800;
      border-radius: 50%;
    }
    
    .container {
      padding: 16px;
    }
    
    span.psw {
      float: right;
      padding-top: 16px;
    }
    
    /* The Modal (background) */
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      padding-top: 60px;
    }
    
    /* Modal Content/Box */
    .modal-content {
      background-color: #fefefe;
      margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
      border: 1px solid #888;
      width: 80%; /* Could be more or less, depending on screen size */
    }
    
    /* The Close Button (x) */
    .close {
      position: absolute;
      right: 25px;
      top: 0;
      color: #000;
      font-size: 35px;
      font-weight: bold;
    }
    
    .close:hover,
    .close:focus {
      color: red;
      cursor: pointer;
    }
    
    /* Add Zoom Animation */
    .animate {
      -webkit-animation: animatezoom 0.6s;
      animation: animatezoom 0.6s
    }
    
    @-webkit-keyframes animatezoom {
      from {-webkit-transform: scale(0)} 
      to {-webkit-transform: scale(1)}
    }
      
    @keyframes animatezoom {
      from {transform: scale(0)} 
      to {transform: scale(1)}
    }
    
    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
      span.psw {
         display: block;
         float: none;
      }
      .cancelbtn {
         width: 100%;
      }
    }
    
	</style>
	<body>
	<div class="icon-bar">
	  <a href="https://luistamborrell.000webhostapp.com/index.php#"><i class="fa fa-home"></i></a> 
	  <a href="#"><i class="fa fa-bullhorn"></i></a> 
	  <a href="#"><i class="fa fa-eye"></i></a> 
	  <a href="#"><i class="fa fa-bullseye"></i></a>
	  <a class="active" href="#"><i class="fa fa-user-o"></i></a> 
	</div>
	
	 <center><h2>Log in</h2></center>
	 <br/>
	 <br/>
	 <?php
	 if(isset($_GET['error'])){
	     if($_GET['error']=="wrongusername"){
	         echo '<center><p class="error"><b><i>No username match found!<b/><i/></p></center>';
	     }
	     else if($_GET['error']=="wrongpassword"){
	          echo '<center><p class="error"><b><i>Wrong password!<b/><i/></p></center>';
	     }
	 }
	 ?>
	 <br/>

    <center><button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Log in</button></center>
    
    <div id="id01" class="modal">
      
      <form class="modal-content animate" action="scripts/login_script.php" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAjVBMVEUAAAD////z8/Pj4+P6+vrc3Nzt7e3q6uoFBQXk5OTX19d7e3vAwMB+fn7w8PCBgYG4uLhJSUkuLi6Pj49vb2+pqalnZ2chISGjo6NbW1sRERFCQkIxMTHGxsYbGxu/v7+mpqZNTU1eXl6bm5s6OjrOzs6SkpImJiacnJyysrKIiIgVFRU9PT1TU1N0dHS5hZWgAAALbElEQVR4nN2d6XaiQBCFWwQXNOK+Ja6JS3Ti+z/eSFQEZanqug2e3D9z5pwZ5FPopepWtSqZlm257eXeG3a6o/lxWlO16XE+6naG3n7Zdi3b+Ocrg9dulZu9/rtKVa1z6s3qlsG7MEXotBurUTpcSKNVY+EYuhMThM54ciTD3XWcLE1QogmtpqcBd5c3Qz+xUMJKeyjCu2jYbiFvCkdotyc1AJ+v6XqBG2NRhO4JRHdTA/VOQggr4w8wn6+vAeRpBRDWZWNLimqH6gsQOn1TfL86lQsmdNZG+XwN6wUSls3+fjc1RIwCwspbLny+DoIxR59wmxufr33uhO1c+Xw1cyV0M/ZERrTSWwNoER4K4PP1mROh2y0I8LzM0fgZ+YT5jaBx6hkndL8KBVTqnbvIYRJ+Fszna2CQ0CpiCH3WD2vzyCF0i0a7acQZcBiEg6LBQlqYIGwUTRXRAU5o/xTN9KAhmLBqIkwh04q436ARuqgoGlIj2raRRDgrGiZBLoow/50SVRsM4XfRHCmaIQhfaRp8Vva+OJMQC1jrvnexo1YmYhYhCrA7/J45t/Wk7cy+h6hdZtaDmkGIeQc747gtT3ncgVw9Y7hJJ1wg7sBLnrfKkO10+qSRSrgBfLyXvvRoIZa7qZviNMKy/LPX2euO8kT8KfOKHqFFdxokaErb5MhXFO8pe+IUQvGG/ocai6+upB+11iEUZ104YTFxBDb5wxIJx9LP5IVve9KPS3whkgjFwygzIlbaSz8waUxLILSlS6stE1D+oH7xCKWrjTc2oPzF73MIpY/MuwZgqSSNlLTphNLAaE3PQiFdYcR/bByhLV32M6KZEUnX+T9UQqm9iRzoe5I0ZBmXC48hFE8U+jYfR/rRMVPGM6EtXY7Sw9HPkj4+HQqh2MMlMYhWpR8+ziYUP6OeABCwGn56Tp8IxTlemRFN/AU/7TIeCcWRp5g3gSNbnCB5DNs8ENrS68e8CDyJNxnHdEJ5ZEjqlpQnmh++4yiheD5SH0JA+WSlptHBPEoot9onLPAZkqdioxNyhBBgRYhf33MkDi48LKoihPK4Hinfla6m/CYiU3KYEBEATotc0oTwtITvIkyI8AOJAQETllKNeELETziXE5YAt6FCkdoQIaJmqQsgROQXQ+HTOyEgS5Ec8OIIkVg83ufEOyHE86QXgooKYg9cPhNWENeVL2lK8pDb5UaCXE1AKI45/wox0swhdxIkvwNC8XLwIgAh5kaCcNjtlhBTha+XIQxm/dstIaYKX+JSM8yYru6ZkyshZpxRJJNShlAmuttO+EoI8wV9iwlhJrNNhBDjbFGp6WaiYBWNjTBhHXVV+bLN3qFuZWeHCJeoqyolLcGWB1ICbUKEQBO3VvVVSMCyxrc7IWwkVfKVKbDqaGQHhFCPrOwxhVatOAEhtGC5kY6QIWhrhs+AEHnVyP6aLXHuKaL3GyFqTXqVJPkELsyxroToqmz9HDBqTXpT+0r4D3xd/Tw+IGAbkXchtMCX1fdiwAs7uhdC8GvoS+85xa0dA1V+CTHxi4iK8UTFaPNLaKI9iY6vDd2lyNfWJ5TnlRMuzZSRNgYTn9DA0+8rd39prL7sM6GBgeZXOXuEE1Q9E5r58hTP522s1ZR7JjRXwTwhe/VhQZQnjc+E5q6uprSeMiYrON9Kyp4avL4aZs/9gJqZFK3PhCavf9Yh3chXMVzm/1FS6OX8sw7JtU+O+TYGtgJYHzK1WsbWH+7zaCRiqZzKfD/8GtIbm19Dus6pU5Gr8u04U+u+wyK+NLWVsbn2RTRQqLTaq2qsDE74L6FPVVxrsnzUUEaXNC+gtXrFvixIrf484b8/T/jXxxmlQD6hF9ZfH0l9/fX3sPbnf8WpwjgBX1dzlfNmJnft/vx80VXo9Oir6Z96tY6PaE2UiZzWK+mkTKVEXkVbBSgVI2rUWZ/ePM97O607+a0WxzlEE2uT7WBWt6OtnGy7PhtsYWfvJGugIC3ZErRbHRZueuNm210cjP6iCwX0c0b04zUdaldq21l4psZ0R+HdNEp99TZ8c1trczDhKLDxuad+W79tROsbHb6d2grq+dq9yatkZyfka9kpKVgtyXlynWHOErOaOMNr/0wI8rF0vpGH3rUGIDd070wIyaI35NVAj3IhP2TzTChPAn8tzZyyWfmUb+3KZ8KKznmTIf2TNxlIlD0QMo5avnNPlH3a6R5SRJXsJVr9ehMF+6e5wd8v0FJA2Pgl1P+WDuZP8/VV0R9zmr+EuivTFamtPUQb3bmjfHGy6w01y8z7Qkpvo+4XXvuEOibhL8Dpkiy5OqHr/pVQYxN8yucNDKulsb/6vhLy53z+yVkI8Qec6pWwxH0ApP28dMV1we1KN0Lm4rsoQDZiLyDkFYhLq0Ql4q1ONgEhK5Ihqy+UijPc1KyAkLML/lcoIKvH0un3f1wIGQu3vOfBRzGKJy79HS6EFfJoWuRLeBH5eZtfdq3XngpUN/ko/5n+UeTZ+1oGeSWkPqb6x/LiRJ34r01IroTUF1jecE4u6pt4/ee3P2lzaWzD7NxFi6fe+kPeCGmbRHlvFoRoj+mtBiJoe0SqDJBHtBEitYAIHjfF+m/Fj6S+SC9iEEEKCC3KlFgM0aMojRd2z/3aSHGC1/gNKcvo+7R2J6R8M5MigJ5EWJ7U7vnL0INH2ZnkG36K15Jwn6HeHCFC0oQhbZIkF+k2Q/uD8OBBWZwiWj/KRMlkhDtShwlJ3468XZlMpD1CeIsXmQBIGxN+LwGkSJ1mImGICCFt6ZZHNiZJtD1QpGg1OonTAj3Frd1o24qUnuzUDhJFDajEHFLUy/OwEKNFTqfFBGvqNBfcwy79calJ+5ZGReyEKzTTfe2R6OHvxHDGPP9fsUpMAj52UH3aLhAryI95I9aJ4cCnpfMTIbWt35x2djtKZWq888nY87zlo2Zbp/kluRntFAnnPTG6vuc39ZNj8jEtuETnruW1l6I3CYoxn8UFJugHBum09OKLnlKLyznEhl7o3o4PvGPvUQ7d+EU+/5DlsDEdQuV0jyWfYck7r6dvxph4UYvj72WcQ8pMtcr7sCeJVSqR0HIz6Txglk+qbybKaLEM2szzgJkdi414FL95JpikMS8xjM00Sv2g94wu87x19rncfNuphxxxLK45KPnw05RUBNs73JN0gQ6rwq4fSGnsm0Jo8Yuge4g9VZ3f2CmtI2xaOkmn7+dJ+j7qFCHM0x6e1ISZVuPPjsTb3tYyA6cuHdNTgponohz0fkhXs+9Y+kY1I+mp63JfjbmQzqduB76M8G1WWlf/2ISPAz1yPPP0K0ey1oyZiWtRnfC/7SJrlmy1e6LCysxFcXZqXloKPZ94+021+khqVeuzT+9H2lole9VPMB9gzvfYddb9/qnhHbzGqd9H1asTtjUUe4XJLrgyUd50koEEdYwWWqTxmmaRcV+x19KOtkQkmoCqRlrTi/RD3MtQbU72q3V5IR+PTTdymW9qzBHdTcCwquXUcZgkxuqeY8aDnjYlUZcTh2bZDa082lNni+euYxoq8+0cHS9mlJ1rGXWLnjZW3Mws3xRb7JjKr2jRsP1uimti966R6tIyNhs59IYgrXoWPeu2W0SnvolerlLXnA49FJKiqW6GS99+n2sru6l+Za6gwKCa36jaE+RERCUUDvR4z0R5olyBsEjEMb+p6gtzIeIyGMO/45s41wMo9KnT/TdMHbcAlyeklKkyNrHMecd0D0MVa23QD6uH8iLhytGsNmzUmQ+BBhZowV31G3EeZr8J9SChSwpbC9E64HiYoS1WJoom3b1WwmW+HpjwHZsqC3Xbpw69of3ux2uacjmaLHxtlRe9fkbwaro6bWd1k+Y/86W9tuW2x3tv2OmO5sdpTdWmx/noYzU87JdtxzZfd/sfNIOxdDATde8AAAAASUVORK5CYII=" alt="Avatar" class="avatar">
        </div>
    
        <div class="container">
            <form>
              <label for="uname"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="uname" required>
        
              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="psw" required>
                
              <button type="submit" name="login">Login</button>
              <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
              </label>
        </div>
    
        <div class="container" style="background-color:#f1f1f1">
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
          <span class="psw">Forgot password?</a></span>
        </div>
      </form>
    </div>
    
        <script>
        // Get the modal
        var modal = document.getElementById('id01');
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        </script>
    </body>
</html>