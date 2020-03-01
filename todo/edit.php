<?php
session_start();

if (!$_SESSION["vars"]["logged_in"]){
	header("Location: login.php");
}
if(!isset($_POST["edit_btn"])) {
	header("Location: index.php");
}
// Get variable from POST submission
$task = $_POST["task_name"];
$due = $_POST["task_due"];
$location = $_POST["task_location"];
$status = $_POST["task_status"];
$task_id = $_POST["task_id"];

// The key for task statuses
$statuses = array("Not started", "On track", "At risk", "Complete");

$db_servername = "localhost";
$db_username = "cit368";
$db_password = "";
$db_dbname = "my_cit368";
$username = $_SESSION["vars"]["username"];

	// Connect to DB
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

	// Check connection
	if (!$conn) {
		die("Failure: " . mysqli_connect_error());
	}
    else {
		echo "Success.";
    }

	// DB query
	$query = "UPDATE task SET
    name='$task', 
    location='$location', 
    due='$due', 
    status=" . $status . "
    WHERE username='$username' AND id=" . $task_id;

    if (mysqli_query($conn, $query)) {
    	echo "Record updated successfully";
        header("Location: index.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
