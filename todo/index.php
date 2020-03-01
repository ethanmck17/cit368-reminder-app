<?php
session_start();

if (!$_SESSION["vars"]["logged_in"]){
	header("Location: login.php");
}
$db_servername = "localhost";
$db_username = "cit368";
$db_password = "";
$db_dbname = "my_cit368";
$username = $_SESSION["vars"]["username"];

// The key for task statuses
$statuses = array("Not started", "On track", "At risk", "Complete");

	// Connect to db
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

	// Check connection
	if (!$conn) {
		die("Failure: " . mysqli_connect_error());
	}
    else {
		//echo "Success";
    }

	// DB query
	$query = "SELECT * FROM task WHERE username='$username'";

	// Send query
	$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todo | HOME</title>
    <style type="text/css">
    	.inline-block {
        	display: inline-block;
        }
        .invisibile-input {
        	border: 0px solid black;
            padding: 2px;
            background-color: white;
        }
    </style>
</head>
<body>
	<h1>Welcome <?php echo $_SESSION["vars"]["first_name"]; ?></h1>
    <a href="logout.php">Log out</a>
    	<br><br>
    <h2>Tasks:</h2>
    <?php
    	if (mysqli_num_rows($result) > 0) {
          // For each task, create a form for editing and deleting
          while($row = mysqli_fetch_assoc($result)) {
          	  echo "<form action='edit.php' class='inline-block' method='post'>";
              echo "<input type='text' class='invisible-input' name='task_name' value='" . $row["name"]. "'>";
              echo "<input type='text' class='invisible-input' name='task_location' value='" . $row["location"]. "'>";
              echo "<input type='date' class='invisible-input' name='task_due' value='" . $row["due"]. "'>";
              echo "<select name='task_status' class='invisible-input' value='" . $statuses[$row["status"]] . "'>
              			<option value='" . $row["status"] . "'>" . $statuses[$row["status"]] . "</option>
              			<option value=0>Not started</option>
              			<option value=1>On track</option>
              			<option value=2>At risk</option>
              			<option value=3>Complete</option>
                    </select>";
              echo "<input type='hidden' name='task_id' value='" . $row["id"] . "'>";
              echo "<input type='submit' name='edit_btn' value='Update &rarr;'>";
              echo "</form>";
              echo "<form action='delete.php' class='inline-block' method='post'>";
              echo "<input type='hidden' name='task_id' value='" . $row["id"] . "'>";
              echo "<input type='submit' name='delete_btn' value='Delete &rarr;'>";
              echo "</form><br>";
          }
      	} else {
          echo "0 results";
      	}
    ?>
    <form action="insert.php" method="post">
    	<input type="text" name="task_name" placeholder="Add task...">
    	<input type="text" name="task_location" placeholder="Task Location">
    	<input type="date" name="task_due">
        <input type="submit" name="insert_btn" value="Add &rarr;">
    </form>
</body>
</html>