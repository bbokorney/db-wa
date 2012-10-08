<?php
//This page takes a songID and add it to the queue if it is not already present in it.
$result = array();
if(!isset($_POST["songID"])) {
//song ID parameter wasn't properly set
	$result["message"] = "Error: song ID not found.";
	echo json_encode($result);
}
?>