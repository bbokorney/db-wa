<?php
//This page returns all of the metadata for the music library
$response = array();
$con = mysql_connect("localhost");
if(!mysql_select_db("droidbox", $con)) {
	die("Unable to select database. " . mysql_error());
}
//query db for song metadata
$sql = "SELECT id, title, artist, album FROM song;";
$result = mysql_query($sql, $con);
//if there were results from the query
if(mysql_num_rows($result) > 0) {
	//put results into return value
	$response["songs"] = array();
	while($row = mysql_fetch_array($result)) {
		$song = array();
		$song["id"] = $row["id"];
		$song["title"] = $row["title"];
		$song["artist"] = $row["artist"];
		$song["album"] = $row["album"];
		array_push($response["songs"], $song);
	}
	$response["success"] = 0;
	echo json_encode($response);
}
//if no results were returned
else {
	$response["success"] = 1;
	$response["message"] = "No songs in library.";
	echo "Error: " . mysql_error()."<br>";
	echo json_encode($response);
}
?>