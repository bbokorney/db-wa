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
	
	//myaudio.duration = songLength;
	//function refresh()
	//{
 	//	window.location.replace(localhost/db-wa);
	//}
	
//NEED to write my func, refreshes page when song ends!!!!!!!!
	//myaudio.addEventListener('ended',myaudio.refresh());

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
			<img src="images/mockupDBpage_02.png" width="637" height="206" alt=""></td>
		<td rowspan="2">
			<img src="images/mockupDBpage_03.png" width="643" height="462" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/mockupDBpage_04.png" width="637" height="256" alt=""></td>
	</tr>
</table>
<!-- End Save for Web Slices -->

</body>
</div>
</html>
