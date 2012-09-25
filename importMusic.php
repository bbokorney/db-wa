<?php 
ini_set ("display_errors", "1");
error_reporting(E_ALL);
$errorOut = "Errors are as follows: <br>";
//check if the new music directory exists
if( !is_dir("newmusic") ) {
	//print("Error: New music directory cannot be found.<br><br>");
	$errorOut .= "Error: New music directory cannot be found.<br>";
}

//initialize ID3 tag reader
require_once("getid3/getid3.php");
$getID3 = new getID3;

//find all files in the new music directory
$srcdir = "newmusic";
$destdir = "library";
$files = scandir($srcdir);
foreach($files as $f) {
	//ignore the parent and current directories
	if($f != "." && $f != "..") {
		//echo ("Getting info of ".$f."<br>");
		//get ID3 info
		$info = $getID3->analyze("newmusic/" . $f);
		//copy info into comments
		getid3_lib::CopyTagsToComments($info);
		//store this audio file in the library
		$ret = storeFile($info);
		if($ret != "") {
			$errorOut .= $ret . "<br>";
		}
	}
}
echo $errorOut;

/* if(file_exists("import_error.txt")) {
	
}
 */

/* print_r($files);
print("<br>"); */

/* $info = $getID3->analyze('newmusic/' . $files[2]);
getid3_lib::CopyTagsToComments($info);
echo 'file path = ' . $info['filenamepath'] . '<br>';
echo 'artist = ' . $info['comments_html']['artist'][0] . '<br>';
echo 'album = ' . $info['comments_html']['album'][0] . '<br>';
echo 'title = ' . $info['comments_html']['title'][0] . '<br>';
echo 'genre = ' . $info['comments_html']['genre'][0] . '<br>';
echo 'length = ' . $info['playtime_string'] . '<br>';
echo 'length_num = ' . $info['playtime_seconds'] . '<br>';
 */

?>
<?php
//store files into their proper location in the library
function storeFile($info) {
	$filename = "";
	$artist = "";
	$album = "";
	
	$filename = $info["filename"];
	$artist = $info["comments_html"]["artist"][0];
	$album = $info["comments_html"]["album"][0];
	
	//check that file has artist and album info
	if($artist == "") {
		echo "Artist name was empty.<br>";
		return $filename.": Artist info could not be found.";
	}
	if($album == "") {
		return $filename.": Album info could not be found.";
	}
	
	$destFP = "./library/".$artist;
	//check if directory for this artist already exists
	if(!is_dir($destFP)) {
		if(!mkdir($destFP, 0775)) {
			return $filename.": Unable to make artist directory.";
		}
	}
	
	$destFP .= "/".$album;
	//check if directory for this album already exists
	if(!is_dir($destFP)) {
		if(!mkdir($destFP, 0775)) {
			return $filename.": Unable to make album directory.";
		}
	}
	
	//store file in appropriate location
	if(copy("./newmusic/".$filename, $destFP.$filename)) {
		return $filename.": Unable to move file to library.";
	}
	
	//TODO add song and info to DB
	
	return "";
}

?>
