<?php
$response = array();
$response["success"] = 0;
$response["message"] = "Success!";
if(!isset($_POST["songID"])) {
	$response["success"] = 1;
	$response["message"] = "Song id not set.";
	die(json_encode($response));
}
$sql = new mysqli("localhost");
if(!$sql->select_db("droidbox")) {	
	die("Unable to connect to database.");
}

$cmd = "CALL get_next_song_queue(".$_POST["songID"].");";
$cmd .= "SELECT id,title,artist,file_path,length FROM song,queue 
		WHERE id = songID and priority >= 0 ORDER BY request_type, priority DESC, time_requested LIMIT 1;";

if($sql->multi_query($cmd)) {
	if(!$sql->next_result()) {
		$response["success"] = 1;
		$response["message"] = "No next result.";
		die(json_encode($response));		
	}
	if(!$result = $sql->store_result()) {
		$response["success"] = 1;
		$response["message"] = "No result to store.";
		die(json_encode($response));		
	}
	if(!$row = $result->fetch_row()) {
		$response["success"] = 1;
		$response["message"] = "Queue is empty.";
		die(json_encode($response));
	}
	else {		
		$response["songID"] = $row[0];
		$response["title"] = $row[1];
		$response["artist"] = $row[2];
		$response["filepath"] = $row[3];
		$reponse["length"] = $row[4];
		$result->free();
	}
}
else {
	$response["success"] = 1;
	$response["message"] = $sql->error;
	die(json_encode($response));
}
echo(json_encode($response));
?>