<?php header('Refresh: 3'); ?>

<!--password protection stuff-->
<?php
$username = "droidbox";
$password = "droidbox";
$nonsense = "supercalifragilisticexpialidocious";

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {
?>
<!-- pw stuff-->

<head>

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
mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM payment";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
?>

<?php
$f9 = $_POST["table"];
?>
</td>
<table border="0" cellspacing="2" cellpadding="2">
<tr>
<td>Table Number</td>
<td>  </td>
<td>  </td>
<td>Table ID</td>
<td>  </td>
<td>  </td>
<td>Number of Requests</td>
<td>  </td>
<td>  </td>

<!--<td>Close Table</td>-->

</tr>

<?php
$i=0;
while ($i < $num) {
	$f1=mysql_result($result,$i,"table_num");
	$f2=mysql_result($result,$i,"id_num");
	$f3=mysql_result($result,$i,"num_requests");
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
	<!--
	<td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<input type="submit" name="table".<?php echo $i?> value="Close">
	</form>
	
	<?php echo $i;?>
	-->

	</td>
	</tr>

	<?php
	$i++;
}
	?>
</center>
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

