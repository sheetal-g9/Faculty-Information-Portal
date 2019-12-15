<html>
<head>
	<title>Publication Details</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
<?php

	$research_type = $_POST['research_type'];

	// Display research type.
	// echo "$research_type<br>";

	// Connect with MySQL database.
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

	if ($research_type == "publication")
	{
		$publication_id = $_POST['publication_id'];

		/* Construct the MySQL query */
		// $view_publication = "SELECT * FROM Publication WHERE publication_id = '$publication_id';";
		$view_publication = "SELECT * FROM Publication WHERE title = '$publication_id';";

		// printf("%s<br>", $view_publication);

		$result = $conn->query($view_publication);

		// echo mysqli_num_rows($result)."<br>";
		if (mysqli_num_rows($result))
		{
			echo "<h2 class='head'>Publication Details</h2>
			<table class='table table-striped table-bordered'> 
				<thead class='thead-dark'>
				<tr>
					<th scope='col'>Publication ID</th>
					<th scope='col'>Title</th>
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
					 	</tr>",
						$row['publication_id'], 
						$row['title'], 
						$row['publication_date'], 
						$row['pages'], 
						$row['research_fields'], 
						$row['citations']
				);

				$publication_id = $row['publication_id'];
			}

			echo "</tbody></table>";
			if ($result)
				$result->free();

			// Find the type of publication.
			$find_in_journal = "SELECT * FROM Journal_Publication WHERE publication_id = '$publication_id';";
			$result = $conn -> query($find_in_journal);

			$find_in_conference = "SELECT * FROM Conference_Publication WHERE publication_id = '$publication_id';";
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
		}
		else {
			echo "<h2 class='head'> No Publication matches given info!!</h2>";
		}
	}
	else
	{
		$project_id = $_POST['project_id'];
		
		// $view_project = "SELECT * FROM Project WHERE project_id = '$project_id';";
		$view_project = "SELECT * FROM Project WHERE title = '$project_id';";
		
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
		else {
			echo "<h2 class='head'> No Project matches given info!!</h2>";
		}
	}

	$conn->close();
?>

<div style="text-align:center;">
	<a class="btn" href="index.html">BACK TO HOME</a>
</div>

</body>
</html>