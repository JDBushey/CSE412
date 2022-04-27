<?php
          $servername = "localhost";
          $username = "root";
          $password = "";
		  
		  
		  session_start();
		  $userID1 = $_SESSION['eneteredID'];


			$mysqli = new mysqli("localhost", "root", "", "cse412"); //The Blank string is the password
			
			//$_POST['newPlaylist'] = "";
			//unset($_POST['newPlaylist']);
			
			if(isset($_POST['newPlaylist']))
			//if($_POST['newPlaylist'] == "Add New Playlist")
			{
				$stmt = $mysqli->prepare("SELECT COUNT(*) AS 'count'
										FROM playlists");
		  
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc(); // or while (...)
				
				$nextID = $row["count"];
				
				$enter = $mysqli->prepare("INSERT INTO playlists (id, playlistname, description)
														VALUES(?, 'New Playlist', '')");
				$enter->bind_param("s", $nextID);
				$enter->execute();
				
				$enter = $mysqli->prepare("INSERT INTO users_playlists (playlistID, userID)
														VALUES(?, ?)");
				$enter->bind_param("ss", $nextID, $userID1);
				$enter->execute();
				
				$_POST['newPlaylist'] = "";
				unset($_POST['newPlaylist']);
			}
			
			
          ?>