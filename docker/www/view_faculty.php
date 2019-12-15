<html>
<head>
	<title>Faculty Details</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h2 class="head">Faculty Details</h2>
<?php

	/* Read the data from html form and assign them to the variables */
	$faculty_id = $_POST['faculty_id'];
	$faculty_password = $_POST['faculty_password'];

	/* Connect with MySQL database */
	$host = "localhost";
	$user = "root";
	$pass = "sheetalg";
	$dbname = "test";

	// Create the DB connection.
	$conn = new mysqli($host, $user, $pass, $dbname);

	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error . "\n");
	}

	/* Construct the MySQL query */
	$selection_query = "SELECT * FROM Faculty WHERE faculty_id = '$faculty_id' AND faculty_password = '$faculty_password';";

	// printf("%s<br>", $selection_query);

	$result = $conn->query($selection_query);

	if (mysqli_num_rows($result) == 1)
	{
		// Printing result.
		echo "<table class='table table-striped table-bordered'> 
				<thead class='thead-dark'>
				<tr>
					<th scope='col'>Faculty ID</th>
					<th scope='col'>Password</th>
					<th scope='col'>Name</th>
					<th scope='col'>Email</th>
					<th scope='col'>Department</th>
					<th scope='col'>Designation</th>
					<th scope='col'>Website</th>
					<th scope='col'>Research Fields</th>
				</tr>
				</thead>
		";
		echo "<tbody>";
		while ($row = $result->fetch_assoc())
		{
			printf("<tr>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
					</tr>",
					$row['faculty_id'],
					$row['faculty_password'], 
					$row['faculty_name'], 
					$row['faculty_email'], 
					$row['faculty_department'], 
					$row['faculty_designation'], 
					$row['faculty_website'], 
					$row['faculty_research_fields']
			);
		}
		echo "</tbody></table>";
	}
	else
	{
		echo "<h2 class='head'>ERROR: User not found.</h2><br>";
	}
	if ($result)
		$result->free();

	$selection_query = "SELECT * FROM Publication_Faculty
	 					NATURAL JOIN Publication
	 					where faculty_id = '$faculty_id'";

	$result = $conn->query($selection_query);

	if (mysqli_num_rows($result))
	{
		echo "<h2 class='head'>Publication Details</h2>
		<table class='table table-striped table-bordered'> 
			<thead class='thead-dark'>
			<tr>
				<th scope='col'>Publication ID</th>
				<th scope='col'>Title</th>
				<th scope='col'>Type</th>
				<th scope='col'>Publication Date</th>
				<th scope='col'>Pages</th>
				<th scope='col'>Research Fields</th>
				<th scope='col'>Citations</th>
			</tr>
			</thead>
		";
		echo "<tbody>";
		// Printing result.
		while ($row = $result->fetch_assoc())
		{
			printf("<tr>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
				 	</tr>",
				 	$row['publication_id'],
					$row['title'],
					$row['type'], 
					$row['publication_date'], 
					$row['pages'], 
					$row['research_fields'], 
					$row['citations']
			);
		}
	}

	echo "</tbody></table>";
	if ($result)
		$result->free();

	$find_in_journal = "SELECT * FROM Journal_Publication WHERE publication_id in (select publication_id from Publication_Faculty where faculty_id = '$faculty_id');";
	$result = $conn -> query($find_in_journal);

	$find_in_conference = "SELECT * FROM Conference_Publication WHERE publication_id in (select publication_id from Publication_Faculty where faculty_id = '$faculty_id');";
	$result_conf = $conn -> query($find_in_conference);

	// Status of find_in_journal and find_in_conference.
	// echo mysqli_num_rows($result) . "<br>";
	// echo mysqli_num_rows($result_conf) . "<br>";

	if (mysqli_num_rows($result))
	{
		// Journal Publication.

		echo "	<h2 class='head'> Journal Details </h2>
				<table class='table table-striped table-bordered'>
					<thead class='thead-dark'>
						<th>Journal Name</th>
						<th>Volume</th>
						<th>No</th>
					</thead>
				<tbody>";

		while ($row = $result->fetch_assoc())
		{
			printf("<tr>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
					</tr>",
					$row['journal_name'], 
					$row['volume'], 
					$row['no']
			);
		}
		echo "<tbody> </table>";
		
		if ($result)
			$result->free();
	}

	if(mysqli_num_rows($result_conf))
	{
		// Conference Publication.
		
		echo "	<h2 class='head'> Conference Details </h2>
				<table class='table table-striped table-bordered'>
					<thead class='thead-dark'>
						<th>Organisation</th>
						<th>Location</th>
					</thead>
				<tbody>";
		
		while ($row = $result_conf->fetch_assoc())
		{
			printf("<tr>
						<td> %s </td>
						<td> %s </td>
					</tr>",
					$row['organisation'], 
					$row['location']
			);
		}
		echo "<tbody> </table>";

		if ($result_conf)
			$result_conf -> free();
	} 
	

	$view_project = "SELECT * FROM Project WHERE project_id in (select project_id from Project_Faculty where faculty_id = '$faculty_id');";
		
	// printf("%s<br>", $view_project);
	
	$result = $conn -> query($view_project);

	if (mysqli_num_rows($result))
	{
		// Printing result.

		echo "	<h2 class='head'> Project Details </h2>
					<table class='table table-striped table-bordered'>
						<thead class='thead-dark'>
							<th>Project ID</th>
							<th>Title</th>
							<th>Description</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Funding Agency</th>
							<th>Budget</th>
						</thead>
					<tbody>";

		while ($row = $result->fetch_assoc())
		{
			printf("<tr>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
						<td> %s </td>
						<td> %d </td>
					</tr>",
					$row['project_id'], 
					$row['title'], 
					$row['description'], 
					$row['start_date'], 
					$row['end_date'], 
					$row['funding_agency'], 
					$row['budget']
			);
		}
		echo "<tbody> </table>";
		$result->free();
	}

	$conn->close();
?>

<div style="text-align:center;">
	<a class="btn" href="index.html">BACK TO HOME</a>
</div>

</body>
</html>

<!-- INSERT INTO Faculty VALUES ('F001', '$faculty_password', '$faculty_name', '$faculty_email', '$faculty_department', '$faculty_designation', '$faculty_website', '$faculty_research_fields'); -->