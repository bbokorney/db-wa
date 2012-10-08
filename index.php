<!-- Got this from a tutorial for html5.  What we need is myfunc() to refresh the page, thus calling a new song and updating the queue.


‘myaudio.addEventListener(‘ended’,myfunc)’ – This will call ‘myfunc()’ once the audio has finished -->




<html>
<head>
<title>mockupDBpage</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	<script>
	var myaudio = new Audio('testAudio.mp3');
	myaudio.play();
	</script>
</audio>

<!-- end audio player section -->

<!-- Database query php -->

<?php
$username="root";
$password="droidbox";
$database="droidbox";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="select title,artist from song,queue WHERE id = songID ORDER BY priority,request_type,time_requested LIMIT 4";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
?>

<!-- end database query php -->

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
			<img src="images/mockupDBpage_02.png" width="637" height="206" alt=""></td>
		<td rowspan="2">
			<img src="images/mockupDBpage_03.png" width="643" height="462" alt=""></td>
	</tr>
	<tr>
		<td>
			<table border="0" cellspacing="2" cellpadding="2">
			<tr>
			<td><font face="Arial, Helvetica, sans-serif" color="white" size="3">Coming Up:</font></td>
			</tr>

			<?php
			$i=0;
			while ($i < $num) {

			$f1=mysql_result($result,$i,"title");
			$f2=mysql_result($result,$i,"artist");
			?>

			<tr>
			<td><font face="Arial, Helvetica, sans-serif" color="white" size="3"><?php echo $i+1; echo ") ".$f2." - ".$f1; ?> </font></td>
			</tr>

			<?php
			$i++;
			}
			?>
		<!--	<img src="images/mockupDBpage_04.png" width="637" height="256" alt=""> --> </td>
	</tr>
</table>
<!-- End Save for Web Slices -->

</body>
</div>
</html>
