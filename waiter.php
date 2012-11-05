<?php
$username="root";
$password="droidbox";
$database="droidbox";

mysql_connect("localhost");
@mysql_select_db($database) or die( "Unable to select database");

mysql_close();
?>


<!-- autorefresh every 15 seconds to maintain an updated queue -->
<?php header('Refresh: 15'); ?>

<!-- attempting to add password protection!-->
<?php
$username = "droidbox";
$password = "droidbox";
$nonsense = "supercalifragilisticexpialidocious";

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {
?>

<!-- EVERYTHING FOR WAITER PAGE SHOULD BE BELOW HERE-->

    <title>waiterPage</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<style type='text/css'>
	body {
		background-image: url('images/bg.png');
		background-repeat:repeat;
		text-shadow: 3px 3px 3px #000;
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
	<!--<script src="raphael.js"></script>-->
	<script src="processing.js"></script>
	</head>
	<center>

	<p class = "ttle">
	<font color="white">Waiter Page</font>
	</p>

<!--
<script type="text/javascript">
// Creates canvas 320 × 200 at 10, 50
var paper = Raphael(10, 50, 800, 600);

var table1 = paper.rect(40, 40, 200, 100, 10);
table1.attr("fill", "#fff");
table1.attr("stroke", "#000");

table1.onMouseOver = function(){
	table1.attr("fill", "#ff0");
};
</script>
-->

	<script type="text/processing" data-processing-target="mycanvas">
	int valueX = 10;
	int valueY = 10;

	void setup(){
		size(800,600);
		//background();
		fill(255,0,0);
		rect(10,10,100,50,10);
	}

	void draw(){
		background();
		line(0, 0, width, height);
		rect(valueX,valueY,100,50,10);
		rect(10,70,100,50,10);
		rect(10,130,100,50,10);
		rect(10,190,100,50,10);
	}

	mouseDragged(){
	valueX = valueX+mouseX;
	valueY = valueY+mouseY;
}
</script>
<canvas id="mycanvas"></canvas>
<table>
<td></td>
</table>
</center>
</html>

<!--End waiter page stuff, below is the other part of the password protection-->

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
<!-- end password protection -->




