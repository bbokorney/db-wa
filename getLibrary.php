<?php
$result = array();
if(isset($_POST["songID"])) {
	$result["message"] = "songID = " . ($_POST["songID"] + 30000);
}
else {
	$result["message"] = "song ID not found";
}
echo json_encode($result);
?>