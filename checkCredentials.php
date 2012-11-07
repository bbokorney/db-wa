<?php
$response = array();
if(!isset($_POST["t_num"]) || $_POST["t_num"] == null) {
	$response["success"] = 1;
	$response["message"] = "Table number not set.";
	die(json_encode($response));
}
if(!isset($_POST["t_code"]) || $_POST["t_code"] == null) {
	$response["success"] = 1;
	$response["message"] = "Table code not set.";
	die(json_encode($response));
}
$sql = new mysqli("localhost");
if(!$sql->select_db("droidbox")) {
	die("Unable to select database.");
}
$cmd = "CALL check_credentials(".$_POST["t_num"].",".$_POST["t_code"].",@success,@message);";
$cmd .= "SELECT @success,@message;";
if($sql->multi_query($cmd)) {
	while($sql->next_result()) {
		if($result = $sql->store_result()) {
			$row = $result->fetch_row();
			$response["success"] = $row[0];
			$response["message"] = $row[1];
			echo json_encode($response);
		}
	}
}
?>