<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>

<?php

	/* Read the data from html form and assign them to the variables */
	// $faculty_id = $_POST['faculty_id'];
	$faculty_id = $_POST['faculty_email'];
	$faculty_password = $_POST['faculty_password'];
	$faculty_name = $_POST['faculty_name'];
	$faculty_email = $_POST['faculty_email'];
	$faculty_department = $_POST['faculty_department'];
	$faculty_designation = $_POST['faculty_designation'];
	$faculty_website = $_POST['faculty_website'];
	$faculty_research_fields = $_POST['faculty_research_fields'];

	/* Connect with MySQL database */
	$host = "db";
	$user = "root";
	$pass = "test";
	$dbname = "myDb";

	// Create the DB connection.
	$conn = new mysqli($host, $user, $pass, $dbname);

	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error . "\n");
	}

	/* Construct the MySQL query */
	$insertion_query = "INSERT INTO Faculty VALUES ('$faculty_id', '$faculty_password', '$faculty_name', '$faculty_email', '$faculty_department', '$faculty_designation', '$faculty_website', '$faculty_research_fields');";

	// printf("%s<br>", $insertion_query);

	$result = $conn->query($insertion_query);

	if (mysqli_affected_rows($conn) == 1)
	{
		echo "<h2 class='head'> REGISTRATION SUCCESSFUL.</h2><br>";
	}
	else
	{
		echo "<h2 class='head'>ERROR: The user could not be registered.</h2><br>";
	}
	// if ($result)
	// 	$result->free();
	$conn->close();
?>

<a class="stretched-link btn" href="/">BACK TO HOME</a>

</body>
</html>
