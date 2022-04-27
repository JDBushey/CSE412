<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Account Login">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Login</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
    <link rel="stylesheet" href="login.css" media="screen">
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
            <h2 class="u-text u-text-default u-text-palette-1-base u-text-1">Account Login</h2>
            <div class="u-expanded-width-xs u-form u-login-control u-form-1">
              <form action="#" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" style="padding: 0px;">
                
                
              </form>
			  
				<form method="post">
				
				<div class="u-form-group u-form-name">
                  <label for="username-a30d" class="u-label u-text-grey-25 u-label-1">Username *</label>
                  <input type="text" placeholder="Enter your Username" id="username-a30d" name="username" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-input-1" required="">
                </div>
				
				
                <div class="u-form-group u-form-password">
                  <label for="password-a30d" class="u-label u-text-grey-25 u-label-2">Password *</label>
                  <input type="text" placeholder="Enter your Password" id="password-a30d" name="password" class="u-border-2 u-border-grey-10 u-grey-10 u-input u-input-rectangle u-input-2" required="">
                </div>
				
				
			  
					<div class="u-align-left u-form-group u-form-submit">
						<input type="submit" name="submit"value="Login" class="u-btn u-btn-submit u-button-style u-btn-1">
					</div>
				
				</form>
			  
			  <?php
					$servername = "localhost";
					$username = "root";
					$password = "";
		  
					//$enterUsername = "default13561389874561";
					
					session_start();


					$mysqli = new mysqli("localhost", "root", "", "cse412"); //The Blank string is the password
					
					
					if(isset($_POST['submit'])) {
						
						$enterUsername = $_POST['username'];//assigning your input value
						$enterPassword = $_POST['password'];//assigning your input value
						//$_POST = array();

					}
		  
					$stmt = $mysqli->prepare("SELECT COUNT(*) AS 'count', users.id, users.password, users.username
												FROM users
												WHERE users.username = ?");
		  
		  
					$stmt->bind_param("s", $enterUsername);
					$stmt->execute();
					$result = $stmt->get_result();
					$row = $result->fetch_assoc(); // or while (...)
						
					$userID = $row["id"];
					$userUsername = $row["username"];
					$userPassword = $row["password"];
					
					
				
			
					if ($row["count"] == "0") {
						//echo "doesnt exist";
						
						//echo '<script>alert("$enterUsername")</script>';
						
				
					} else {
						//echo "user exists";
						
						if($userPassword == $enterPassword){
							//echo "login";
							//$userID1 = $userID;
							$_SESSION['eneteredID'] = $userID;
							//$_POST['eneteredID'] = $userID;
							
							header("Location: http://localhost/cse412/home.php");
							exit();
							
						}
						
						
						
					}
			
				?>
			  
			  
            </div>
            <a href="http://localhost/cse412/createaccount.php" class="u-border-1 u-border-active-palette-1-base u-border-hover-palette-1-base u-btn u-button-style u-login-control u-login-create-account u-none u-text-palette-1-base u-btn-2">Don't have an account?</a>
          </div>
        </div>
      </div>
    </section>
    
  </body>
</html>