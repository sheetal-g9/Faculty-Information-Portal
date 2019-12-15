<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<a class="stretched-link btn" href='/'>BACK TO HOME</a>
<?php

	$title = $_POST['title'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$description = $_POST['description'];
	$funding_agency = $_POST['funding_agency'];
	$budget = $_POST['budget'];
	
	/* Connect with MySQL database */
	$host = "db";
	$user = "root";
	$pass = "test";
	$dbname = "myDb";

	// Create the DB connection.
	$conn = new mysqli($host, $user, $pass, $dbname);
	
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$check_query = "
		select * from Project
			where title = '$title';
	";

	// echo $check_query . "<br>";

	$check_result = $conn -> query($check_query);
	
	if (mysqli_num_rows($check_result))
	{
		echo "<h2 class='head'>ERROR: The Project could not be registered.</h2><br>";
		die();
	}

	$query = "insert into Project(title, description, start_date, end_date, funding_agency, budget) values (?, ?, ?, ?, ?, ?)";
	// echo $title." ";
	// echo $description." ";
	// echo $start_date." ";
	// echo $end_date." ";
	// echo $funding_agency." ";
	// echo $budget." ";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("sssssi", $title, $description, $start_date, $end_date, $funding_agency, $budget);

	$stmt->execute();

	$result = $stmt->get_result();

	if ($result->affected_rows != -1)
	{
		echo "<h2 class='head'> INSERTION SUCCESSFUL.</h2><br>";
	}
	else
	{
		echo "<h2 class='head'>ERROR: The Project could not be registered1.</h2><br>";
		die();
	}
	// echo $stmt->affected_rows;

	// For AUTO_INCREMENTed project_id.
	$project_id = $conn->insert_id;

	// Add (faculty, project) pairs to project_Faculty table.
	$num = 0;
	$faculty_member = 'faculty' . $num;
	// echo "<br>" . $faculty_member . "<br>";
	while ($_POST[$faculty_member])
	{
		// echo $faculty_member . "<br>";
		$faculty_id = $_POST[$faculty_member];
		$project_designation = $_POST['role' . $num];

		$insert_query = "
			INSERT INTO Project_Faculty(project_id, faculty_id, project_designation) 
				VALUES(?, ?, ?);
		";

		// echo $insert_query . "<br>";

		$stmt = $conn->prepare($insert_query);
		$stmt->bind_param("sss", $project_id, $faculty_id, $project_designation);
		$stmt->execute();

		$result = $stmt->get_result();

		// echo $stmt->affected_rows;

		$num++;
		$faculty_member = 'faculty' . $num;
	}

?>
</body>
</html>	