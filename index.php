<!--password protection stuff-->
<?php
$username = "droidbox";
$password = "droidbox";
$nonsense = "supercalifragilisticexpialidocious";

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {
?>
<!-- pw stuff-->

<!-- Genereates sql queries -->
<?php
session_start();
$sql = new mysqli("localhost");
if(!$sql->select_db("droidbox")) {	
	die("Unable to connect to database.");
}
$curr_song_id = -1;
$title = null;
$artist = null;
$filepath = null;
$songLength = -1;

//check if this is the first time the jukebox has been started
if(isset($_SESSION["curr_song_id"])) {
	$curr_song_id = $_SESSION["curr_song_id"];
}
else {
	echo "Current song id not set.<br>";
}

//execute stored proc call, check that it returned a result
$cmd = "CALL get_next_song_queue(".$curr_song_id.");";
$cmd .= "SELECT id,title,artist,file_path,length FROM song,queue 
		WHERE id = songID ORDER BY request_type, priority DESC, time_requested LIMIT 1;";
$cmd .= "SELECT id,title,artist,file_path,length FROM song,queue 
		WHERE id = songID ORDER BY request_type, priority DESC, time_requested LIMIT 4 OFFSET 1;";
$curr_song_id = -1;
if($sql->multi_query($cmd)) {
	if(!$sql->next_result()) {
		die("No next result.");		
	}
	if(!$result = $sql->store_result()) {
		die("No result to store");
	}
	if(!$row = $result->fetch_row()) {
		//die("No rows in result.");
		$curr_song_id = -1;
	}
	else {
		$_SESSION["curr_song_id"] = $row[0];
		$curr_song_id = $row[0];
		$title = $row[1];
		$artist = $row[2];
		$filepath = $row[3];
		$songLength = $row[4];
		$result->free();	
	}
}
else {
	die("Error: ".$sql->error."<br>");
}
?>

<html>
<head>

<title>mockupDBpage</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<META HTTP-EQUIV="REFRESH" content="<?php echo($songLength); ?>;URL=http://localhost/db-wa/">

<script src="nowPlaying.js" type="text/javascript"></script>
<style type='text/css'>
body {
	background-image: url('images/bg.png');
	background-repeat:repeat;
} 
#content {position:absolute; top:0; bottom:0; left:0; right:0;
			margin:auto; height:75%; width:90%;}
</style>
</head>

<!-- audio player -->

<audio controls="controls">
  	<source src="track.ogg" type="audio/ogg" />
  	<source src="track.mp3" type="audio/mpeg" />
	
	Your browser does not support the audio element.
	<script language="javascript">
	var myaudio = new Audio('<?php echo($filepath); ?>');
	myaudio.play();
	
	//myaudio.addEventListener("onended",timedRefresh);
	</script>
	
	
</audio>

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
			<font face="Arial, Helvetica, sans-serif" color="white" size="5">Now Playing:</font>
			<?php				
			if($curr_song_id == -1) {
				$descrip =  "<br /> No song is currently playing.";
			}
			else {				
				$descrip = "<br />".$title." - ".$artist;
			}
			?>
			<font face="Arial, Helvetica, sans-serif" color="white" size="10"><?php echo $descrip; ?> </font>

			<!-- end Now Playing -->
		</td>
		<td rowspan="2">
			<img src="images/mockupDBpage_03.png" width="643" height="462" alt=""></td>
	</tr>
	<tr>
		<td>
			<!-- Queue -->			
			<font face="Arial, Helvetica, sans-serif" color="white" size="5">Coming Up:</font><br />

			<?php
			$count=0;
			$minQueue=2;									
			if(!$sql->next_result()) {
				die("No next result.");		
			}
			if(!$result = $sql->store_result()) {
				die("No result to store");
			}
			while($row = $result->fetch_row()) {
				$title = $row[1];
				$artist = $row[2];					
			?>
			<font face="Arial, Helvetica, sans-serif" color="white" size="6"><?php echo $count+1; echo ") ".$title." - ".$artist."<br />"; ?> </font>
			<?php
			++$count;
			}
			?>
			<!-- end Queue -->
			

			<!-- Low Queue message -->
			<?php
			if ($count<$minQueue){
			echo "<font face=\"Arial, Helvetica, sans-serif\" color=\"white\" size=\"6\">!!!Low Queue--Send Requests!!! <br /> </font>";
			}
					
			?>	

		 </td>
	</tr>
</table>
<!-- End Save for Web Slices -->

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
