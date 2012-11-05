<head>
<?php
$username="root";
$password="droidbox";
$database="droidbox";

mysql_connect("localhost");
@mysql_select_db($database) or die( "Unable to select database");

mysql_close();
?>

    <title>waiterPage</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<style type='text/css'>
	body {
		background-image: url('images/bg.png');
		background-repeat:repeat;
		text-shadow: 3px 3px 3px #000;
		font-family: "Bank Gothic";
		color: FFFFFF;
		font-size: 12px;
	}
	p.ttle{
		font-family: "Capture it";
		color: FFFFFF;
		font-size: 39px;
		font-weight:lighter;
	}

	@font-face {  
		font-family:  Bank Gothic ;  
  		src: local(fonts/bankGothic.ttf), url( /fonts/bankGothic.ttf ) format("truetype"); /* non-IE */  
	}  

	.element    { 	
		font-family: "Bank Gothic"; color: FFFFFF;	font-size: 30px;
		font-weight:lighter; position:absolute; 
	}
	#element-1    { color:lightblue; z-index:1; }
	#element-2    { color:lightgreen; margin:10px 0 0 45px; z-index:2; }

	.table {	display:table;}
	.tr {    	display:table-row;}
	.td {    	display:table-cell;}

	@font-face {  
 		font-family:  Capture it ;  
  		src: local(fonts/Capture it.ttf), url( /fonts/Capture it.ttf ) format("truetype"); /* non-IE */  
	}  

	#content {
		position:absolute; top:0; bottom:0; left:0; right:0;
		margin:auto; height:75%; width:90%;
	}
	</style>
	<script src="raphael.js"></script>
	<script src="processing.js"></script>
	</head>
	<center>

	<p class = "ttle">
	<font color="white">Waiter Page</font>
	</p>


<!--Trying this-->
<body>
<?php
$username="root";
$password="droidbox";
$database="droidbox";

mysql_connect("localhost");
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM song";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
?>
<table border="0" cellspacing="2" cellpadding="2">
<tr>
<td>Table Number</td>
<td>  </td>
<td>  </td>
<td>  </td>
<td>  </td>
<td>Number of Requests</td>
<td>  </td>
<td>  </td>
<td>Actions</td>

</tr>

<?php
$i=0;
while ($i < $num) {

$f1=mysql_result($result,$i,"tableNumber");
$f2=mysql_result($result,$i,"numRequests");

?>

<tr>
<td><?php echo $f1; ?></td>
<td>  </td>
<td>  </td>
<td>  </td>
<td>  </td>
<td><?php echo $f2; ?></td>
<td>  </td>
<td>  </td>
<td><button type="button" onclick="alert('Hello world!')">Enable</button></td>
</tr>

<?php
$i++;
}
?>
</center>
</body>
</html>


