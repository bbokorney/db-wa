<?php
//This page takes a songID and add it to the queue if it is not already present in it.
$response = array();
if(!isset($_POST["songID"])) {
//song ID parameter wasn't properly set
	$response["success"] = "1";
	$response["message"] = "Error: song ID not found.";
	die(json_encode($response));
}
if(!isset($_POST["t_num"])) {
//table number wasn't set
	$response["success"] = "1";
	$response["message"] = "Error: table number not found.";
	die(json_encode($response));
}
if(!isset($_POST["t_code"])) {
//table code wasn't set
	$response["success"] = "1";
	$response["message"] = "Error: table code not found.";
	die(json_encode($response));
}
if(!isset($_POST["req_type"])) {
//request type wasn't set
	$response["success"] = "1";
	$response["message"] = "Error: request type not found.";
	die(json_encode($response));
}

$sql = new mysqli("localhost");
if(!$sql->select_db("droidbox")) {	
	$response["success"] = 1;
	$response["message"] = "Unable to select database. " . $sql->error;
	die(json_encode($response));
}
//execute stored proc call, check that it returned a result
// $cmd = "CALL request_song(".$_POST["songID"].",".$_POST["t_num"].",".$_POST["t_code"].",".$_POST["req_type"].",". 
						// "@success, @message); SELECT @success, @message;";
$cmd = "CALL request_song_all_free(".$_POST["songID"].",".$_POST["t_num"].",".$_POST["t_code"].",".$_POST["req_type"].",". 
						"@success, @message); SELECT @success, @message;";
if($sql->multi_query($cmd)) {
	//read results from the request
	do {			
		if($result = $sql->store_result()) {
			$row = $result->fetch_row();
			$response["success"] = $row[0];
			$response["message"] = $row[1];
			$result->free();
		}				
	} while($sql->next_result());	
	$sql->close();
	die(json_encode($response));
}
else {
	$response["success"] = 1;
	$response["message"] = "Error: " . $sql->error;
	die(json_encode($response));
}
?>