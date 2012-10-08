<?php
//This page takes a songID and add it to the queue if it is not already present in it.
$response = array();
if(!isset($_POST["songID"])) {
//song ID parameter wasn't properly set
	$response["message"] = "Error: song ID not found.";
	echo json_encode($response);
	die("Error: song ID not found.");
}

$con = mysql_connect("localhost");
if(!mysql_select_db("droidbox", $con)) {
	die("Unable to select database. " . mysql_error());
}

//check if the requested song is already in the queue
$sql = "SELECT id FROM queue WHERE id = ". $_POST["songID"];
$result = mysql_query($sql, $con);
//this song is already in the queue
if(mysql_num_rows($result) > 0) {
	$response["success"] = 1;
	$response["message"] = "Song is already in the queue";
}
//this song can be added to the queue
else {
	$sql = "INSERT INTO queue VALUES (" . 
			$_POST["songID"] . ", " .
			0 . ", " .
			0 . ", " .
			"now() );";
	if(!mysql_query($sql, $con)) {
		$response["success"] = 1;
		$response["message"] = "Error: " . mysql_error();
		$response["sql"] = $sql;
	}
	else {
		$response["success"] = 0;
		$response["message"] = "Song successfully requested.";
	}
}
echo json_encode($response);
?>