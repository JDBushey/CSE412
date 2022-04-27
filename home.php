<!DOCTYPE html>
<html>
  <head>
    <title>Playlist Creator</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
    </style>
  </head>
  
  
  <script>
	
	var loadedPlaylist = null;
	var allowedPlaylists; 
	
	document.cookie="allow_new_playlist = flase";
 
	function updateSongs(num) {
		
		const myElement = document.getElementById("playlist" + num);
		const displayName = document.getElementById("playlist-display-name");
		let text = myElement.textContent;
		
		if(loadedPlaylist != null){
			const pastSection = document.getElementById("section" + loadedPlaylist);
			pastSection.style.display = "none"
		}	
		
		const section = document.getElementById("section" + num);
		section.style.display = "block"
		loadedPlaylist = num;
		
		displayName.value = text;
		
		//alert(text);
	}
	
	function setAllowedPlaylists(num){
		allowedPlaylists = num;
		
	}
	
	function increaseAllowedPlaylists(){
		allowedPlaylists++;
		
	}
	
	function increasePlaylists(num){
		if(allowedPlaylists > num){
			document.cookie="allow_new_playlist=true";
			return true;
		} else {
			document.cookie="allow_new_playlist=flase";
			return true;
			return false;
		}
	}
	
	function getNameChange(){
		const displayName = document.getElementById("playlist-display-name");
		
		return displayName.value;
		
		
	}
	
	
	
	
</script>

<body class="w3-light-grey">

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="https://song-database.w3spaces.com/musicNotes.png" style="width:100%" alt="Avatar">
          <div class="w3-display-bottomleft w3-container w3-text-black">
            <h2>Playlist Creator</h2>
          </div>
        </div>
        <div class="w3-container">
          <b style="font-size:140%;"><i class="fa-fw w3-xxlarge w3-text-teal"></i>Playlists: &emsp;</b>
		  
			<form method="post">
				<input type="submit" name="newPlaylist" value="Add New Playlist" onclick="increaseAllowedPlaylists()"/>
			</form>
		  <br>
          <?php
		  ob_start();
          $servername = "localhost";
          $username = "root";
          $password = "";
		  
		  session_start();
		  $userID1 = $_SESSION['eneteredID'];


			$mysqli = new mysqli("localhost", "root", "", "cse412"); //The Blank string is the password
			
			//$_POST['newPlaylist'] = "";
			//unset($_POST['newPlaylist']);
			
			
			// Get number of playlists
			
			$stmt = $mysqli->prepare("SELECT MAX(playlists.id) AS 'max'
										FROM playlists");
		  
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc(); // or while (...)
				
			$nextID = $row["max"] + 1;
			
			
			// Pass number to js function to set a global js varriable  
			
			echo '<script type="text/javascript">', 'setAllowedPlaylists($nextID);', '</script>';
			
			
			$allow_playlist = $_COOKIE['allow_new_playlist'];
			
			if(isset($_POST['newPlaylist']))
			//if($_POST['newPlaylist'] == "Add New Playlist")
			{
				
				if($allow_playlist){
					
					$enter = $mysqli->prepare("INSERT INTO playlists (id, playlistname, description)
														VALUES(?, 'New Playlist', '')");
					$enter->bind_param("s", $nextID);
					$enter->execute();
				
					$enter = $mysqli->prepare("INSERT INTO users_playlists (playlistID, userID)
														VALUES(?, ?)");
					$enter->bind_param("ss", $nextID, $userID1);
					$enter->execute();
				
					//$_POST['newPlaylist'] = "";
					//echo "test";
					unset($_POST['newPlaylist']);
					
				}
				
			}
			
			
		  
			$stmt = $mysqli->prepare("SELECT playlists.playlistname, playlists.id
										FROM users JOIN users_playlists 
										ON users.id = users_playlists.userID
										JOIN playlists 
										ON users_playlists.playlistID = playlists.id
										WHERE users.id = ?");
		  
		  
			$stmt->bind_param("s", $userID1);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc(); // or while (...)
				
			echo "<form method='post'>";
			
			while ($row=$result->fetch_assoc()) {
				
				$name = $row["playlistname"];
				$id = $row["id"];
				
				$a = "playlist" . $id;
			
				//echo "<tr><td>$row[playlistname]</td></tr><br>";
				//class='songDisplay' onclick='updateSongs()'
				//echo "<li onclick='updateSongs($row[id])'>$row[playlistname]</li><br>";
				//echo "<input type='hidden' name='onePlaylist' id = $a onclick='updateSongs($id)'>$name</input><br>";
				echo "<a href='home.php?playlist=$id'>$name</a><br>";
				
			}
			
			echo "</form>";
			
			
          ?>
          <hr>

        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
    
      <div class="w3-container w3-card w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Song Search</h2>
        <div class="topnav">
          <div class="search-container">
		  
		  
		  <?php
		  ob_start();
			$servername = "localhost";
			$username = "root";
			$password = "";

			$mysqli = new mysqli("localhost", "root", "", "cse412"); //The Blank string is the password
		  
		  
		  
		  
		  if(isset($_GET["playlist"])){
			$currentPlaylist = $_GET["playlist"];
			
			$tempurl = "home.php?playlist=$currentPlaylist";
			echo "<form method='post' action=$tempurl>";
		  
			if(isset($_POST['searchvalue'])){
				$currentSearch = $_POST['searchvalue'];
				echo "<input type='text' name='searchvalue' value=$currentSearch />";
				
			} else {
				echo "<input type='text' name='searchvalue' value=''/>";
			}
			
			
			echo "<input type='submit' name='enterSearch' value='Search'/>";
			echo "</form>";
		  
		  
		  } else {
			  echo "<form>";
			  echo "<input type='text' name='searchvalue' value=''/>";
			  echo "<input type='submit' name='enterSearch' value='Search'/>";
			echo "</form>";
			  
		  }
		  
		  if(isset($_POST["enterSearch"])){
			  
			 if(isset($_POST['searchvalue'])){
				
				$currentSearch = $_POST['searchvalue'];
				
				
				$stmt = $mysqli->prepare("SELECT songs.name AS 'songName', artists.name AS 'artistName', songs.id AS 'id' FROM songs JOIN artist_credit 
												ON songs.artist_credit = artist_credit.id JOIN artists 
												ON artist_credit.artist = artists.id
												WHERE songs.name=? LIMIT 20");
												
				
				$stmt->bind_param("s", $currentSearch);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc(); // or while (...)
							
				while ($row=$result->fetch_assoc())
				{
					$tempurl = "home.php?playlist=$currentPlaylist&add=$row[id]";
					$songID = "addSong" . $row["id"];
						
					echo "<form method='post' action=$tempurl>";
					
					
					echo "<button type='submit' name='addSong' id=$songID>+</button>";
					
					echo "<tr><td>$row[songName]     $row[artistName]</td></tr>";
					
					echo "</form>";
					
				}
						
				unset($_POST['enterSearch']);
				unset($_POST['searchvalue']);
				
				
			 } 
		  }
		  
		  
		  
		  
		  ?>
          </div>
        </div>
        <!-- List 20ish top matches -->
		<table>
		<?php
			
			
			if(isset($_POST["addSong"])){
				
				$forAddition = $_GET["add"];
				
				$stmt2 = $mysqli->prepare("INSERT INTO playlists_songs
											VALUES(?, ?)");
			
		  
		  
				$stmt2->bind_param("ss", $currentPlaylist, $forAddition);
				$stmt2->execute();
				
				$url = 'home.php?playlist=' . $currentPlaylist;
				unset($_POST['addSong']);
				header( "Location: $url" );
			}
		
		
			

		?>
		</table>
		
        <hr>
      </div>

      <div class="w3-container w3-card w3-white">
		
		
		<?php
			$servername = "localhost";
			$username = "root";
			$password = "";

			$mysqli = new mysqli("localhost", "root", "", "cse412"); //The Blank string is the password
			
			if(isset($_GET["playlist"])){
				$currentPlaylist = $_GET["playlist"];
				
				$newPlaylistName = "MySongs";
				
				$tempurl = "home.php?playlist=$currentPlaylist&rename=$newPlaylistName";
				
				echo "<form method='post' action=$tempurl>";
				
				
				$mysqli = new mysqli("localhost", "root", "", "cse412"); //The Blank string is the password
				$stmt2 = $mysqli->prepare("SELECT playlists.playlistname 
											FROM playlists
											WHERE playlists.id =?");
			
		  
		  
				$stmt2->bind_param("s", $currentPlaylist);
				$stmt2->execute();
				$result2 = $stmt2->get_result();
				$row2 = $result2->fetch_assoc(); // or while (...)
					
				if($row2 != null){
					$getPlaylistNameFromRow2 = $row2["playlistname"];
				
				
				echo "<input id='playlist-display-name' name='selectPlaylistBox' class='w3-text-grey w3-padding-16' type='text' value=\"$getPlaylistNameFromRow2\">";
				
				echo "<button type='submit' name='renamePlaylist'>Rename Playlist</button>";
				
				echo "<button type='submit' name='deletePlaylist'>Delete Playlist</button>";
					
				} else {
					echo "<form method='post'>";
					echo "<input id='playlist-display-name' name='selectPlaylistBox' class='w3-text-grey w3-padding-16' type='text' value='Select a Playlist'>";
				}

				
			} else {
				echo "<form method='post'>";
				echo "<input id='playlist-display-name' name='selectPlaylistBox' class='w3-text-grey w3-padding-16' type='text' value='Select a Playlist'>";
			}
			
			echo "</form>";
		
		?>
		
	  
	  
		<br>
        <!-- Table of Songs -->
		<?php
		ob_start();
          $servername = "localhost";
          $username = "root";
          $password = "";

          $mysqli = new mysqli("localhost", "root", "", "cse412"); //The Blank string is the password
		  
		  //const displayName = document.getElementById("playlist-display-name");
		
			//return displayName.value;
		  
		  if(isset($_GET["playlist"])){
			  $currentPlaylist = $_GET["playlist"];
			  if(isset($_GET["rename"])){
				  
				if(isset($_POST['renamePlaylist'])){
					//$currentPlaylist = $_GET["playlist"];
					$newName = $_GET["rename"];
					//echo '<script> updateSongs($currentPlaylist); </script>';
				
				
					//$_POST['renamePlaylist']= $newName;
					$stmt = $mysqli->prepare("UPDATE playlists 
										SET playlistname =? 
										WHERE playlists.id = ?");
		  
		  
					$stmt->bind_param("ss", $newName, $currentPlaylist);
					$stmt->execute();
				
					$url = 'home.php?playlist=' . $currentPlaylist;
					unset($_POST['renamePlaylist']);
					header( "Location: $url" );
				}
				
				if(isset($_POST['deletePlaylist'])){
					$currentPlaylist = $_GET["playlist"];
					$newName = $_GET["rename"];
					//echo '<script> updateSongs($currentPlaylist); </script>';
				
				
					//$_POST['renamePlaylist']= $newName;
					$stmt = $mysqli->prepare("DELETE FROM users_playlists 
												WHERE users_playlists.playlistID = ?");
		  
		  
					$stmt->bind_param("s", $currentPlaylist);
					$stmt->execute();
					
					$stmt = $mysqli->prepare("DELETE FROM playlists 
												WHERE playlists.id = ?");
		  
		  
					$stmt->bind_param("s", $currentPlaylist);
					$stmt->execute();
				
					$url = 'home.php';
					header( "Location: $url" );
				}
				   
				
			}
		}
		  
			
			
			// List Songs in current play list
			
			$stmt2 = $mysqli->prepare("SELECT songs.name, songs.id
											FROM songs JOIN playlists_songs 
											ON songs.id = playlists_songs.songID
											WHERE playlists_songs.playlistID =?");
			
		  
		  
			$stmt2->bind_param("s", $currentPlaylist);
			$stmt2->execute();
			$result2 = $stmt2->get_result();
			$row2 = $result2->fetch_assoc(); // or while (...)	
			
		
			if($row2 != null){
				$songID = "song" . $row2["id"];
		
				//echo "<section  id = $sectionID>";
				//echo "<section>";
				
				
			
				
				
				while ($row2=$result2->fetch_assoc()) {
					
					//$tempString = "Javascript:window.location.href = 'home.php?playlist=$currentPlaylist&delete=$row2[id]';";
					$tempurl = "home.php?playlist=$currentPlaylist&delete=$row2[id]";
				
					echo "<form method='post' action=$tempurl>";
					
					//echo "<form method='post'>";
					
					echo "<button type='submit' name='deleteSong' id=$songID>X</button>";
					echo "$row2[name]<br>";
					
					echo "</form>";
				}
				
				//$callFunc = 'call'.$row["id"];
					
				
				
				//echo "</section>";
				
			}
			
			if(isset($_POST["deleteSong"])){
				
				$forDeletion = $_GET["delete"];
				
				$stmt2 = $mysqli->prepare("DELETE FROM playlists_songs
											WHERE playlists_songs.playlistID =?
											AND playlists_songs.songID =?");
			
		  
		  
				$stmt2->bind_param("ss", $currentPlaylist, $forDeletion);
				$stmt2->execute();
				
				$url = 'home.php?playlist=' . $currentPlaylist;
				unset($_POST['deleteSong']);
				header( "Location: $url" );
			}
		  

          ?>	
		
		
        <hr>
      </div>

    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>

<!-- Footer. This section contains an ad for W3Schools Spaces. You can leave it to support us. -->
<footer class="w3-container w3-teal w3-center w3-margin-top">
  <p>Created by: James Bushey</p>
 <p class="w3-small">This website was made with W3schools Spaces. Make your own free website today!</p>
 <a class="w3-button w3-round-xxlarge w3-small w3-light-grey w3-margin-bottom" href="https://www.w3schools.com/spaces" target="_blank">Start now</a> <!-- End footer -->
 </footer>

</body>
</html>