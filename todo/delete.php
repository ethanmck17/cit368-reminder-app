<?php
session_start();

if (!$_SESSION["vars"]["logged_in"]){
	header("Location: login.php");
}
if(!isset($_POST["delete_btn"]))
{
	header("Location: index.php");
}
// Get variable from POST submission
$task_id = $_POST["task_id"];

$db_servername = "localhost";
$db_username = "cit368";
$db_password = "";
$db_dbname = "my_cit368";
$username = $_SESSION["vars"]["username"];

// Connect to database
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed " . mysqli_connect_error());
	}
    else {
		echo "Connected successfully";
    }

	$query = "DELETE FROM task WHERE id=$task_id AND username='$username'";

    if (mysqli_query($conn, $query)) {
        echo "Record deleted successfully";
        header("Location: index.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
	?>
