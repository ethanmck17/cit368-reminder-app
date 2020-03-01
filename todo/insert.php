<?php
session_start();

if (!$_SESSION["vars"]["logged_in"]){
	header("Location: login.php");
}
if(!isset($_POST["insert_btn"]))
{
	header("Location: index.php");
}
// Get variable from POST submission
$task = $_POST["task_name"];
$due = $_POST["task_due"];
$location = $_POST["task_location"];

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

	// DB query
	$query = "INSERT INTO task(name,location,due,status,username) VALUES('$task', '$location', '$due', 0, '$username')";

    if (mysqli_query($conn, $query)) {
        echo "New record created successfully";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
	?>
