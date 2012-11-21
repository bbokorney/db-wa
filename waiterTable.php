<?php
$username="root";
$password="droidbox";
$database="droidbox";

mysql_connect("localhost");
mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM payment";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
?>

<table border="0" cellspacing="2" cellpadding="2">
<tr>
<td>Table Number</td>
<td>  </td>
<td>  </td>
<td>Table ID</td>
<td>  </td>
<td>  </td>
<td>Nickname</td>
<td>  </td>
<td>  </td>
<td>Number of Requests</td>
<td>  </td>
<td>  </td>
</tr>

<?php
$i=0;
while ($i < $num) {
	$f1=mysql_result($result,$i,"table_num");
	$f2=mysql_result($result,$i,"id_num");
	$f3=mysql_result($result,$i,"nickname");
	$f4=mysql_result($result,$i,"num_requests");
?>
	<tr>
	<td><?php echo $f1; ?></td>
	<td>  </td>
	<td>  </td>
	<td><?php echo $f2; ?></td>
	<td>  </td>
	<td>  </td>
	<td><?php echo $f3; ?></td>
	<td>  </td>
	<td>  </td>
	<td><?php echo $f4; ?></td>
	<td>  </td>
	<td>  </td>
	</td>
	</tr>
	<?php
	$i++;
}
?>

	
	
</center>
</body>
</html>
