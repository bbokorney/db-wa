<!-- Genereates sql queries -->
<?php
$username="root";
$password="droidbox";
$database="droidbox";

//mysql_connect(localhost,$username,$password);
mysql_connect("localhost");
@mysql_select_db($database) or die( "Unable to select database");
$query="select title,artist,file_path,length from song,queue WHERE id = songID ORDER BY priority,request_type,time_requested LIMIT 4 OFFSET 1";
$result=mysql_query($query);

$query="select title,artist,file_path,length from song,queue WHERE id = songID ORDER BY priority,request_type,time_requested LIMIT 1";
$now_playing=mysql_query($query);

$num=mysql_numrows($result);
$filepath = ".";
$songLength = -1;
if(mysql_numrows($now_playing) > 0) {
	$filepath=mysql_result($now_playing,0,"file_path");
	$songLength=mysql_result($now_playing,0,"length");
}
$query="delete from queue where songID=(SELECT id FROM song WHERE file_path=\"".$filepath."\")";
$update_queue=mysql_query($query);

mysql_close();
?>

<html>
<head>



<title>mockupDBpage</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<META HTTP-EQUIV="REFRESH" content="<?php echo($songLength); ?>;URL=http://localhost/db-wa/">

<!--Either somehow has to change 60 to the length of the current track
	or not refresh, instead loop updating the current track and now playing queue
	and playing the next song when the current song finishes..? -->


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

<!-- attempting to add audio player -->

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
			$descrip = "";
			if(mysql_num_rows($now_playing) < 1) {
				$descrip =  "<br /> No song is currently playing.";
			}
			else {
				$f1=mysql_result($now_playing,0,"title");
				$f2=mysql_result($now_playing,0,"artist");
				$descrip = "<br />".$f2." - ".$f1;
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
			$i=0;
			$minQueue=2;
			while ($i < $num) {

			$f1=mysql_result($result,$i,"title");
			$f2=mysql_result($result,$i,"artist");
			?>

			<font face="Arial, Helvetica, sans-serif" color="white" size="6"><?php echo $i+1; echo ") ".$f2." - ".$f1."<br />"; ?> </font>

			<?php
			$i++;
			}
			?>
			<!-- end Queue -->
			

			<!-- Empty Queue message -->
			<?php
			if ($num<$minQueue){
				echo "<font face="Arial, Helvetica, sans-serif" color="white" size="5">Low Queue, MAKE REQUESTS!!</font><br />"
			}
					
			?>


		 </td>
	</tr>
</table>
<!-- End Save for Web Slices -->

</body>
</div>
</html>
