<html>
<head>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
<a class='stretched-link btn' href='/'>BACK TO HOME</a>
<?php
	$title = $_POST['title'];
	$publication_type = $_POST['publication_type'];
	$research_fields = $_POST['research_fields'];
	$description = $_POST['description'];
	$citations = $_POST['citations'];
	$pages = $_POST['page_from']."-".$_POST['page_to'];
	$date = strval($_POST['publication_date']);
	
	/* Connect with MySQL database */
	$host = "db";
	$user = "root";
	$pass = "test";
	$dbname = "myDb";

	// Create the DB connection.
	$conn = new mysqli($host, $user, $pass, $dbname);

	$check_query = "
		select * from Publication
			where title = '$title';
	";

	// echo $check_query . "<br>";

	$check_result = $conn -> query($check_query);

	if (mysqli_num_rows($check_result))
	{
		echo "<h2 class='head'>ERROR: The publication could not be registered.</h2><br>";
		die();
	}

	// $query_pub = "insert into Publication values (?, ?, ?, ?, ?, ?, ?)";
	$query_pub = "insert into Publication(title, research_fields, description, citations, type, pages, publication_date) values (?, ?, ?, ?, ?, ?, ?);";
	
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// echo "<br>$query_pub<br>";

	$stmt = $conn->prepare($query_pub);
	// $stmt->bind_param("sssssss", $title, $title, $research_fields, $description, $citations, $pages, $date);
	$stmt->bind_param("sssssss", $title, $research_fields, $description, $citations, $publication_type, $pages, $date);
	$stmt->execute();

	$result = $stmt->get_result();
	// echo $stmt->affected_rows;
	if ($stmt->affected_rows != -1)
	{
		echo "<h2 class='head'> INSERTION SUCCESSFUL.</h2><br>";
	}
	else
	{
		echo "<h2 class='head'>ERROR: The publication could not be registered.</h2><br>";
		die();
	}
	// echo $stmt->affected_rows;

	// Set Publication ID.

	// If publication_id is considered as title.
	// $publication_id = $title;
	
	// For AUTO_INCREMENTed publication_id.
	$publication_id = $con->insert_id;

	// Display Publication ID.
	// echo "<br>Publication ID : $publication_id<br>";

	if($publication_type == "journal") {
		$journal_name = $_POST['journal_name'];
		$volume = $_POST['volume'];
		$no = $_POST['no'];

		$query_jour = "insert into Journal_Publication values (?, ?, ?, ?)";

		$stmt = $conn->prepare($query_jour);
		$stmt->bind_param("ssss", $publication_id, $journal_name, $volume, $no);
		$stmt->execute();

		$result = $stmt->get_result();

		// echo $stmt->affected_rows;
	}	
	else {
		$organisation = $_POST['organisation'];
		$location = $_POST['location'];

		$query_confer = "insert into Conference_Publication values (?, ?, ?)";
		// echo "<br>".$query_confer."<br>";

		$stmt = $conn->prepare($query_confer);
		$stmt->bind_param("sss", $publication_id, $organisation, $location);
		$stmt->execute();

		$result = $stmt->get_result();

		// echo $stmt->affected_rows;
	}

	// Add (faculty, publication) pairs to Publication_Faculty table.
	$num = 0;
	$faculty_member = 'faculty' . $num;
	// echo "<br>" . $faculty_member . "<br>";
	while ($_POST[$faculty_member])
	{
		// echo $faculty_member . "<br>";
		$faculty_id = $_POST[$faculty_member];
		$role = $_POST['role' . $num];

		$insert_query = "INSERT INTO Publication_Faculty(publication_id, faculty_id, role) VALUES(?, ?, ?);";


		$stmt = $conn->prepare($insert_query);
		$stmt->bind_param("sss", $publication_id, $faculty_id, $role);
		$stmt->execute();

		$result = $stmt->get_result();

		// echo $stmt->affected_rows;

		$num++;
		$faculty_member = 'faculty' . $num;
	}

?>
</body>
</html>