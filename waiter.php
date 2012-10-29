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

.element    { 	font-family: "Bank Gothic"; color: FFFFFF;	font-size: 30px;
	font-weight:lighter; position:absolute; }
#element-1    { color:lightblue; z-index:1; }
#element-2    { color:lightgreen; margin:10px 0 0 45px; z-index:2; }

.table {	display:table;}
.tr {    	display:table-row;}
.td {    	display:table-cell;}

@font-face {  
  font-family:  Capture it ;  
  src: local(fonts/Capture it.ttf), url( /fonts/Capture it.ttf ) format("truetype"); /* non-IE */  
}  

#content {position:absolute; top:0; bottom:0; left:0; right:0;
			margin:auto; height:75%; width:90%;}
</style>
<script src="raphael.js"></script>
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
<table>
<td></td>
</table>
</center>
</html>