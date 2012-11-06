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
mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM payment";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<label><input type="text" name="user" id="user" maxlength="5" /> New Table #</label><br />
<input type="submit" name="dbUpdate" value="Open Table" />


<?php if(isset($_POST['submit'])) 
{

$username="root";
$password="droidbox";
$database="droidbox";

mysql_connect("localhost");
@mysql_select_db($database) or die( "Unable to select database");
	echo "f9 =".$f9."<br>";
	$f9 = 7;
	echo "f9 =".$f9."<br>";
	$cmd = "CALL open_table(".$f9.", @success, @message, @id_num);";
	echo $cmd."<br>";	
	mysql_query($cmd);
	echo mysql_error()."<br>";

mysql_close();	
}
?></td>

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
<td>Actions</td>

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
	<td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<input type="submit" name="submit" value="Close">
	</form>
	<?php if(isset($_POST['submit'])) {
	$cmd = "CALL close_table(".$f1." @success, @message); SELECT @success, @message;";
	mysql_query($cmd);	
	}?></td>
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

