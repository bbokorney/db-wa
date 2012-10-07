<?php 
ini_set ("display_errors", "1");
error_reporting(E_ALL);
$errorOut = "Errors are as follows: <br>";

//check if the new music directory exists
if(!is_dir("newmusic")) {
	die("Error: New music directory cannot be found.<br>");
}

//initialize connection to server
$con = mysql_connect("localhost");
//select database
if(!mysql_select_db("droidbox", $con)) {
	die('Unable to select database. ' . mysql_error());
}

//initialize ID3 tag reader
require_once("getid3/getid3.php");
$getID3 = new getID3;

//find all files in the new music directory
$srcdir = "newmusic";
$destdir = "library";
$files = scandir($srcdir);
//move the files to the library
foreach($files as $f) {
	//ignore the parent and current directories
	if($f != "." && $f != "..") {
		//get ID3 info
		$info = $getID3->analyze("newmusic/" . $f);
		//copy info into comments
		getid3_lib::CopyTagsToComments($info);
		//store this audio file in the library
		$ret = storeFile($info, $con);
		//check for errors moving to the library
		if($ret != "") {
			$errorOut .= $ret . "<br>";
		}
	}
}
if($errorOut != "Errors are as follows: <br>") {
	echo $errorOut;
}


mysql_close();

?>

<?php
//stores files into their proper location in the library and adds their record to the db
function storeFile($info, $con) {
	$filename = "";
	$title = "";
	$artist = "";
	$album = "";
	$genre = "";
	$length = -1;
	
	//get the song info from the ID3 tag reader
	$filename = $info["filename"];
	$title = $info['comments_html']['title'][0];
	$artist = $info["comments_html"]["artist"][0];
	$album = $info["comments_html"]["album"][0];
	$genre = $info["comments_html"]["genre"][0];
	$length = $info['playtime_seconds'];
	
	/***lots of error checking for missing information****/
	
	//check for the file name
	if($filename == "") {
		return "No file name.";
	}
	//check that file has title, artist, album, and genre info
	if($title == "") {
		return $filename.": Title info could not be found.";	
	}
	if($artist == "") {
		return $filename.": Artist info could not be found.";
	}
	if($album == "") {
		return $filename.": Album info could not be found.";
	}
	//if genre can't be found, make it unknown
	if($genre == "") {
		$genre = "Unknown";
	}
	//check that the song length can be found
	if($length == -1) {
		return $filename.": Unable to find song length.";
	}
	
	/******now make the file path to place the song in the libray******/
	
	$destFP = "./library/".$artist;
	//check if directory for this artist already exists
	//if not, make the directory
	if(!is_dir($destFP) && !mkdir($destFP, 0775)) {
		return $filename.": Unable to make artist directory.";
	}
	
	$destFP .= "/".$album;
	//check if directory for this album already exists
	//if not, make the directory
	if(!is_dir($destFP) && !mkdir($destFP, 0775)) {
		return $filename.": Unable to make album directory.";
	}
	
	/******now we can place the song in the library******/
	
	$destFP .= "/".$filename;
	//store file in appropriate location
	if(file_exists($destFP)) {
		return $filename.": File already exists in library.";
	}
	if(!rename("./newmusic/".$filename, $destFP)) {
		return $filename.": Unable to move file to library.";
	}
	
	//TODO fix the ampersands
	
	//build the sql query
	$sql = "INSERT INTO song VALUES ( " .
			"0, \"" .
			$title . "\", \"" .
			$artist . "\", \"" .  
			$album . "\", \"" .
			$genre . "\", " .
			ceil($length) . "," .
			" 0, \"" .
			$destFP . "\"," .
			" 1);";
			//the first parameter is the ID, which doesn't matter because
			//the filed is autoincremented in the database
			//the third to last line is the number of times played
			//the last line is the song enabled field, which we set initially to 1 (enabled)
	
	//exectute the query
	if(!mysql_query($sql, $con)) {
		return "Error: ".mysql_error();
	}
	return "";
}

?>
