<!--password protection stuff-->
<?php
$username = "droidbox";
$password = "droidbox";
$nonsense = "supercalifragilisticexpialidocious";

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {
?>
<!-- pw stuff-->

<html>
<script type="text/javascript" src="jquery.js"></script>
<head>
<title>Droidbox</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type='text/css'>
body {
	background-image: url('images/bg.png');
	background-repeat:repeat;
} 

.ttle{
		font-family: Capture_it;
		color: FFFFFF;
		font-size: 39px;
		font-weight:lighter;
		text-shadow: 3px 3px 3px #000;
	}
	
.bddy{
		font-family: BankGothic Md BT Medium;
		color: FFFFFF;
		font-size: 16px;
		text-shadow: 3px 3px 3px #000;
	}

	
@font-face {  
 		font-family:  Capture_it ;  
  		src: local(Capture_it), url( fonts/Capture_it.ttf ) format("truetype"); /* non-IE */  
	}
@font-face{
		font-family:  BankGothic Md BT Medium ;  
  		src: local(BankGothic Md BT), url( "fonts/BankGothic Md BT.ttf" ) format("opentype"); /* non-IE */  
	}   


#content {position:absolute; top:0; bottom:0; left:0; right:0;
			margin:auto; height:75%; width:90%;}
</style>
</head>

<!-- audio player -->

<audio id="audio" controls="controls"></audio>

<!-- end audio player section -->

<div id="content">
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Save for Web Slices (mockupDBpage.psd) -->
<table id="Table_01" width="1280" height="720" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2">
			<img src="images/mockupDBpage_01.png" width="1280" height="258" alt=""></td>
	</tr>
	<tr>
		<td>
			<!-- Now Playing -->			
			<span class="ttle"><font color="white" size="5">Now Playing:</font></span>			
			<span class="bddy"><font id="nowPlaying" color="white" size="10"></font></span>
			<!-- end Now Playing -->
		</td>
		<td rowspan="2">
			<img src="images/mockupDBpage_03.png" width="643" height="462" alt=""></td>
	</tr>
	<tr>
		<!-- Queue -->
		<td id="queueList">
			<span class="ttle"><font color="white" size="5">Coming Up:</font></span><br />		
			
		 </td>
		 <!-- end Queue -->
	</tr>
</table>
<!-- End Save for Web Slices -->

<script>
	function getNextSong(auido) {		
		$.post(
			"getNextSongQueue.php",
			{ "songID" : songID },
			function(data) {
				var response = JSON.parse(data);				
				if(response.success != 0) {					
					showNowPlaying(response, nowPlaying);
					return;
				}			
				songID = response.songID;
				filepath = response.filepath;
				showNowPlaying(response, nowPlaying);
				playSong(filepath, audio);
				showQueue(queueList);
			}
		);
	}

	function playSong(filepath, audio) {
		if(audio == null) {
			console.log("Audio is null");			
			return;
		}		
		audio.src = filepath;
		audio.play();		
	}
	
	function showNowPlaying(response, nowPlaying) {		
		if(response.success == 0) {
			nowPlaying.innerHTML = "</br>" + response.title + " - " + response.artist;			
		}
		else {
			nowPlaying.innerHTML = "</br>No song currently playing.";
			songID = -1;			
		}
	}
	
	function showQueue(queueList) {		
		$.post(
			"getQueue.php",
			function(data) {
				if(audio.paused) {
					console.log("Audio is paused");	
					getNextSong(audio);
				}
				queueList.innerHTML = "";
				var response = JSON.parse(data);
				queueList.innerHTML += "<span class=\"ttle\"><font color=\"white\" size=\"5\">Coming Up:</font></span><br />";
				if(response.success != 0 || response.songs.length <= 1) {					
					queueList.innerHTML += "No songs currently in the queue.";
					return;
				}				
				for(var i = 1; i < response.songs.length && i < 4; ++i) {
					queueList.innerHTML += "<span class=\"bddy\"><font color=\"white\" size=\"6\">"
											+ i + ") " + response.songs[i].title + " - " + response.songs[i].artist + "</font></span><br />";					
				}
			}
		);
	}
	var filepath = "";
	var songID = -1;
	var audio = document.getElementById("audio");
	var nowPlaying = document.getElementById("nowPlaying");
	var queueList = document.getElementById("queueList");
	var audioPlaying = false;
	audio.addEventListener("ended", getNextSong);
	getNextSong(audio);
	setInterval("showQueue(queueList)", 3000);
	getNextSong(audio);
</script>
</body>
</div>
</html>

<!--Rest of password protection stuff-->
<?php
      exit;
   } else {
      echo "Bad Cookie.";
      exit;
   }
}

if (isset($_GET['p']) && $_GET['p'] == "login") {
   if ($_POST['user'] != $username) {
      echo "Sorry, that username does not match.";
      exit;
   } else if ($_POST['keypass'] != $password) {
      echo "Sorry, that password does not match.";
      exit;
   } else if ($_POST['user'] == $username && $_POST['keypass'] == $password) {
      setcookie('PrivatePageLogin', md5($_POST['keypass'].$nonsense));
      header("Location: $_SERVER[PHP_SELF]");
   } else {
      echo "Sorry, you could not be logged in at this time.";
   }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post">
<label><input type="text" name="user" id="user" /> Name</label><br />
<label><input type="password" name="keypass" id="keypass" /> Password</label><br />
<input type="submit" id="submit" value="Login" />
</form>

<!--end pw protection stuff-->
