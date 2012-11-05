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

//Handle updated information
if($_POST['dbUpdate'] == "Update Library Information")
{
	$errorMessage = "";
	$i=0;
	
	$varNum = $_POST['songNum'];
	$varID = $_POST['songID'];	
	$varDelete = $_POST['songDelete'];
	$varEnabled = $_POST['songEnabled'];
	$varTitle = $_POST['songTitle'];
	$varArtist = $_POST['songArtist'];
	$varAlbum = $_POST['songAlbum'];
	$varGenre = $_POST['songGenre'];
	$varLength = $_POST['songLength'];
	$varPlayCount = $_POST['songPlayCount'];

	//echo "debug: ".$varNum."<br />";
	//echo "UPDATE song SET enabled=\"".$varEnabled[$i]."\", title=\"".$varTitle[$i]."\", artist=\"".$varArtist[$i]."\", album=\"".$varAlbum[$i]."\", genre=\"".$varGenre[$i]."\" WHERE id=\"".$varID[$i]."\"; <br />" ;

	//if(empty($errorMessage)) 
	//{
		//$fs = fopen("mydata.csv","a");
		//fwrite($fs,$varName . ", " . $varMovie . "\n");
		//fclose($fs);
		
		mysql_connect("localhost");
		@mysql_select_db($database) or die( "Unable to select database");

		while ($i < $varNum) {
			//echo "UPDATE song SET enabled=\"".$varEnabled[$i]."\", title=\"".$varTitle[$i]."\", artist=\"".$varArtist[$i]."\", album=\"".$varAlbum[$i]."\", genre=\"".$varGenre[$i]."\" WHERE id=\"".$varID[$i]."\"; <br />" ;
			if($varDelete[$i] == 1){
			//echo "DELETE FROM song WHERE id=\"".$varID[$i]."\"";
			$query="DELETE FROM song WHERE id=\"".$varID[$i]."\"";
			}
			else {
			$query="UPDATE song SET enabled=\"".$varEnabled[$i]."\", title=\"".$varTitle[$i]."\", artist=\"".$varArtist[$i]."\", album=\"".$varAlbum[$i]."\", genre=\"".$varGenre[$i]."\" WHERE id=\"".$varID[$i]."\"";
			}
			mysql_query($query);

		$i++;
		}

		mysql_close();

		//header("Location: thank-you.html");
		//exit;
	//}
}

//Populate new table
mysql_connect("localhost");
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM song";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<input type="submit" name="dbUpdate" value="Update Library Information" />
<input type="submit" name="inportMusic" value="Import Music In Music Folder" />
<input type="text" name="searchQuery" maxlength="80" value="Search for text..." />
<input type="submit" name="searchSubmit" value="Search" />


<table border="0" cellspacing="2" cellpadding="2">
<tr>
<td><font face="Arial, Helvetica, sans-serif">DELETE?</font></td>
<td><font face="Arial, Helvetica, sans-serif">Enabled/<br />Disabled</font></td>
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
<td><input type="checkbox" name="songDelete[<?php echo $i; ?>]" value="1"></td>
<td><input type="checkbox" name="songEnabled[<?php echo $i; ?>]" value="1" <?php if($f1 == "1") {echo "checked";} ?>></td>
<td><input type="hidden" name="songID[<?php echo $i; ?>]" maxlength="80" value="<?=$f2;?>" size=5 />
<font face="Arial, Helvetica, sans-serif"><?php echo $f2; ?></font></td>
<td><input type="text" name="songTitle[<?php echo $i; ?>]" maxlength="80" value="<?=$f3;?>" size=30 /></td>
<td><input type="text" name="songArtist[<?php echo $i; ?>]" maxlength="50" value="<?=$f4;?>" /></td>
<td><input type="text" name="songAlbum[<?php echo $i; ?>]" maxlength="50" value="<?=$f5;?>" /></td>

<td><select name="songGenre[<?php echo $i; ?>]">
<option <?php if($f6 == "Blues") {echo "selected";} ?> value="Blues" >Blues</option>
<option <?php if($f6 == "Classical") {echo "selected";} ?> value="Classical" >Classical</option>
<option <?php if($f6 == "Country") {echo "selected";} ?> value="Country" >Country</option>
<option <?php if($f6 == "Electronic/Indie") {echo "selected";} ?> value="Electronic/Indie" >Electronic/Indie</option>
<option <?php if($f6 == "Folk") {echo "selected";} ?> value="Folk" >Folk</option>
<option <?php if($f6 == "Jazz") {echo "selected";} ?> value="Jazz" >Jazz</option>
<option <?php if($f6 == "Reggae") {echo "selected";} ?> value="Reggae" >Reggae</option>
<option <?php if($f6 == "Rock") {echo "selected";} ?> value="Rock" >Rock</option>
<option <?php if($f6 == "Unknown") {echo "selected";} ?> value="Unknown" >Unknown</option>
</select></td>

<td><input type="hidden" name="songLength[<?php echo $i; ?>]" maxlength="50" value="<?=$f7;?>" size=5 />
<font face="Arial, Helvetica, sans-serif"><?php echo $f7; ?></font></td>
<td><input type="hidden" name="songPlayCount[<?php echo $i; ?>]" maxlength="50" value="<?=$f8;?>" size=5 />
<font face="Arial, Helvetica, sans-serif"><?php echo $f8; ?></font></td>
</tr>

<?php
$i++;
}
?>

<input type="hidden" name="songNum" value="<?=$num;?>" />

</form>

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
