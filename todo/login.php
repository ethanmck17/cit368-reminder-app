<?php
session_start();
if ($_SESSION["vars"]["logged_in"]) {
	header("Location: index.php");
}
$db_servername = "localhost";
$db_username = "cit368";
$db_password = "";
$db_dbname = "my_cit368";

// If the page was accessed after having pressed the login button, do login validation
if(isset($_POST["login_btn"]))
{
  	// User credentials
  	$username = $_POST["username"];
  	$password = $_POST["password"];

	// Connect to DB
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_dbname);

	// Check connection
	if (!$conn) {
		die("Connection failed " . mysqli_connect_error());
	}

	// DB query
	$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";

	// Send query
	$result = mysqli_query($conn, $query);

	// If at least one row matches the credentials, send the user onward.
	if (mysqli_num_rows($result) > 0) {
    	
        // Get the specific record
    	$row = $result->fetch_assoc();
        
        // Set session vars
        $session_vars = array("logged_in"=>true, "username"=>$username, "first_name"=>$row["first_name"], "last_name"=>$row["last_name"], "email"=>$row["email"]);
        $_SESSION["vars"] = $session_vars;
		header("Location: index.php");
	}
    
    // Otherwise, set variable to inform user that credentials are incorrect.
	else {
		$bad_credentials=true;
	}

	mysqli_close($conn);

}
else {
	$bad_credentials = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todo | LOGIN</title>
</head>
<body>
	<section id="login-form">
      <form action="login.php" method="post">
      	  <?php if ($bad_credentials) { echo "<p>Invalid user credentials.</p>" . $username; } ?>
          <input type="text" name="username" placeholder="Username">
          <input type="password" name="password" placeholder="Password">
          <input type="submit" name="login_btn" value="Go &rarr;">
      </form>
      <a href="create.php">Create account &rarr;</a>
 	</section>
</body>
</html>