<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content=" Create Account">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Create Account</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
	<link rel="stylesheet" href="login.css">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 4.8.2, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    


    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Home">
    <meta property="og:type" content="website">
  </head>
  <body data-home-page="Home.html" data-home-page-title="Home" class="u-body u-xl-mode"><header class="u-clearfix u-header u-header" id="sec-db0c"><div class="u-clearfix u-sheet u-sheet-1">
        
      </div></header>
    <section class="u-clearfix u-grey-10 u-section-1" id="carousel_e647">
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-align-center u-border-20 u-border-no-bottom u-border-no-left u-border-no-top u-border-palette-1-base u-container-style u-custom-border u-expanded-width-md u-expanded-width-sm u-expanded-width-xs u-group u-white u-group-1">
          <div class="u-container-layout u-valign-middle-xs u-valign-top-lg u-valign-top-xl u-container-layout-1">
            <h2 class="u-text u-text-default u-text-palette-1-base u-text-1">Create Account</h2>
            <div class="u-expanded-width-xs u-form u-form-1">
              <form method="post">
                <div class="u-form-group u-form-name">
                  <label for="username-a30d" class="u-label u-text-grey-25 u-label-1">Username *</label>
                  <input type="text" placeholder="Enter your Username" id="username-a30d" name="username" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-input-1" required="">
				  
				  <!-- username exists waring start hidden -->
				  <p id = "username-warning" class = "username-warning">This username already exists</p>
				  
				  
                </div>
                <div class="u-form-group u-form-password">
                  <label for="password-a30d" class="u-label u-text-grey-25 u-label-2">Password *</label>
                  <input type="text" placeholder="Enter your Password" id="password-a30d" name="password" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-input-2" required="">
				  
				  
				  
				  
				  
                </div>
                <div class="u-align-left">
                  <!-- <a href="#" class="u-btn u-btn-submit u-button-style u-btn-1">Login</a> -->
                  <!-- <input type="submit" value="submit" name="submit" class="u-form-control-hidden"> -->
				  <input type="submit" value="Submit" name="submit" class="u-btn u-btn-1">
                </div>
                
				
              </form>
			  
				<!-- SQL userame check and account creation here -->
				
				<?php
					$servername = "localhost";
					$username = "root";
					$password = "";
		  
					$enterUsername = "default13561389874561";


					$mysqli = new mysqli("localhost", "root", "", "cse412"); //The Blank string is the password
					
					
					if(isset($_POST['submit'])) {
						
						$enterUsername = $_POST['username'];//assigning your input value
						$enterPassword = $_POST['password'];//assigning your input value
						//$_POST = array();
						
						$stmt = $mysqli->prepare("SELECT COUNT(*) AS 'count'
												FROM users
												WHERE users.username = ?");
		  
		  
						$stmt->bind_param("s", $enterUsername);
						$stmt->execute();
						$result = $stmt->get_result();
						$row = $result->fetch_assoc(); // or while (...)
				
			
						if ($row["count"] == "0") {
				
							echo "it worked";
							echo '<script type="text/javascript">','usernameExists(false);','</script>';
							//echo '<script>alert("Your account has been created! \nRedirecting to login page.")</script>';
							
							$stmt = $mysqli->prepare("SELECT COUNT(*) AS 'count'
												FROM users");
		  
		  
							$stmt->execute();
							$result = $stmt->get_result();
							$row = $result->fetch_assoc(); // or while (...)
							
							$nextID = $row["count"];
							
							
							$enter = $mysqli->prepare("INSERT INTO users (id, username, password)
														VALUES(?, ?, ?)");
							$enter->bind_param("sss", $nextID, $enterUsername, $enterPassword);
							$enter->execute();
							
							
							
							
							header("Location: http://localhost/cse412/login.php");
							exit();
				
						} else {
							echo "That username already exists";
							echo '<script type="text/javascript">','usernameExists(true);','</script>';
						}

					}
		  
					
			
				?>
				
				
				
            </div>
          </div>
        </div>
      </div>
    </section>
	<script>
		function usernameExists(bool){
			//username-warning
			if(bool){
				onst myElement = document.getElementById("username-warning");
				myElement.style.display = "block"
			} else {
				onst myElement = document.getElementById("username-warning");
				myElement.style.display = "none"
			}
			
		}
	
	
	
	</script>
    
  </body>
</html>