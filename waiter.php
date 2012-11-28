<?php header('Refresh: 30'); ?>

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

	
    <title>waiterPage</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<style type='text/css'>
	body {
		background-image: url('images/bg.png');
		background-repeat:repeat;
		text-shadow: 3px 3px 3px #000;
		font-family: "BankGothic Md BT Medium";
		color: FFFFFF;
		font-size: 12px;
	}
	p.ttle{
		font-family: Capture_it;
		color: FFFFFF;
		font-size: 39px;
		font-weight:lighter;
	}

	p.bddy{
		font-family: BankGothic Md BT Medium;
		color: FFFFFF;
		font-size: 16px;
	}

	
	@font-face {  
 		font-family:  Capture_it ;  
  		src: local(Capture_it), url( fonts/Capture_it.ttf ) format("truetype"); /* non-IE */  
	}
	@font-face{
		font-family:  BankGothic Md BT Medium ;  
  		src: local(BankGothic Md BT), url( "fonts/BankGothic Md BT.ttf" ) format("opentype"); /* non-IE */  
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

<body>

<td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="submit" name="submit" value="Edit Tables"> </td> <br />
<label><input type="text" name="open_table" maxlength="5" id="user" /> Open Table</label><br />
<label><input type="text" name="close_table" maxlength="5" id="user" /> Close Table</label><br />
</form>

<?php if(isset($_POST['submit'])) 
{
$f9 = $_POST["open_table"];
$f10 = $_POST["close_table"];
$username="root";
$password="droidbox";
$database="droidbox";

mysql_connect("localhost");
@mysql_select_db($database) or die( "Unable to select database");
	$cmd = "CALL open_table(".$f9.", @success, @message, @id_num);";	
	mysql_query($cmd);
	$cmd = "CALL close_table(".$f10.", @success, @message, @id_num);";
	mysql_query($cmd);
	mysql_close();	
}
?>


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


