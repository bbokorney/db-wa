<?php
$database = "droidbox";
mysql_connect("localhost");
@mysql_select_db($database) or die( "Unable to select database");
$query = "SELECT id, title, artist, album FROM song,queue WHERE id = songID ORDER BY request_type,priority DESC,time_requested";
$result = mysql_query($query);
$song = array();
if(mysql_num_rows($result) > 0) {
	//put results into return value
	$response["songs"] = array();
	while($row = mysql_fetch_array($result)) {		
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
	$response["message"] = "No songs in queue.";
	echo json_encode($response);
}
?>