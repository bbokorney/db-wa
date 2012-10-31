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
