<?php
session_start();
if ($_SESSION["logged_in"]) {
	header("Location: index.php");
}
$db_servername = "localhost";
$db_username = "cit368";
$db_password = "";
$db_name = "my_cit368";

if(isset($_POST["create_btn"]))
{
  	// User credentials
  	$first_name = $_POST["first_name"];
  	$last_name = $_POST["last_name"];
  	$email = $_POST["email"];
  	$username = $_POST["username"];
  	$password = $_POST["password"];

	// Connect to database
	$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_name);

	// Check connection
	if (!$conn) {
		die("Connection failed " . mysqli_connect_error());
	}
	echo "Connected successfully";

	// DB query
	$query = "INSERT INTO user(first_name, last_name, email, username, password) VALUES('$first_name', '$last_name', '$email', '$username', '$password')";

	// Send the query
    if (mysqli_query($conn, $query)) {
        echo "New record created successfully";
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

	mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Todo | CREATE</title>
</head>
<body>
	<section id="create-form">
    	<h1>Create Account</h1>
        <form action="create.php" method="post">
            <?php if ($bad_credentials) { echo "<p>Invalid credentials.</p>"; } ?>
            <input type="text" name="first_name" placeholder="First Name">
            <input type="text" name="last_name" placeholder="Last Name">
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="create_btn" value="Go &rarr;">
        </form>
        <a href="login.php">Login to existing account &rarr;</a>
 	</section>
</body>
</html>