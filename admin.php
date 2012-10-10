<html>
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
<td><font face="Arial, Helvetica, sans-serif">Enabled</font></td>
<td><font face="Arial, Helvetica, sans-serif">ID</font></td>
<td><font face="Arial, Helvetica, sans-serif">Title</font></td>
<td><font face="Arial, Helvetica, sans-serif">Artist</font></td>
<td><font face="Arial, Helvetica, sans-serif">Album</font></td>
<td><font face="Arial, Helvetica, sans-serif">Genre</font></td>
<td><font face="Arial, Helvetica, sans-serif">Length</font></td>
<td><font face="Arial, Helvetica, sans-serif">Play Count</font></td>
</tr>

<?php
$i=0;
while ($i < $num) {

$f1=mysql_result($result,$i,"enabled");
$f2=mysql_result($result,$i,"id");
$f3=mysql_result($result,$i,"title");
$f4=mysql_result($result,$i,"artist");
$f5=mysql_result($result,$i,"album");
$f6=mysql_result($result,$i,"genre");
$f7=mysql_result($result,$i,"length");
$f8=mysql_result($result,$i,"num_played");
?>

<tr>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $f1; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $f2; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $f3; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $f4; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $f5; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $f6; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $f7; ?></font></td>
<td><font face="Arial, Helvetica, sans-serif"><?php echo $f8; ?></font></td>
</tr>

<?php
$i++;
}
?>
</body>
</html>
