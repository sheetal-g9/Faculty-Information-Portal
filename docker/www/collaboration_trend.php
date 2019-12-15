<!DOCTYPE html>
<html>
<head>
	<title>Collaboration Trend</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		body {
			padding : 4%;
		}
		.table {
			font-size: 0.85em;
		}
	</style>
</head>
<body>

<?php
	$faculty_id = $_POST['faculty_id'];
	$from = $_POST['from'];
	$to = $_POST['to'];
	$research_fields = array();

	$con = new mysqli("localhost","root","sheetalg","test");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if($to == "") {
		$to = date("Y-m-d");
	}
	if($from == "") {
		$from = "1800-01-01";
	}

	$no = 0;
	$field = $_POST["research_field".$no];

	while($field) {
		array_push($research_fields, $field);
		$no = $no + 1;
		$field = $_POST['research_field'.$no]; 
	}

	$selection_query = "SELECT * FROM Faculty WHERE faculty_id = '$faculty_id';";

	// printf("%s<br>", $selection_query);

	$result = $con->query($selection_query);

	if (mysqli_num_rows($result) == 1)
	{
		// Printing result.
		echo "<h2 class='head'>Faculty Details</h2>
			<table class='table table-striped table-bordered'> 
				<thead class='thead-dark'>
				<tr>
					<th scope='col'>Faculty ID</th>
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
					</tr>",
					$row['faculty_id'],
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
		die();
	}
	if(count($research_fields) == 0) {
		$query = "select research_fields from Publication";
		$stmt = $con->prepare($query);
		$stmt->execute();

		$result = $stmt->get_result();
		if (mysqli_num_rows($result)) {
			while ($row = $result->fetch_assoc()) {
				array_push($research_fields, $row['research_fields']);
			}

			$result->free();
		}
	}

	$research = implode("','", $research_fields);

	$query = "
				select * from 
						(
							select  * from Publication_Faculty 
								NATURAL JOIN Publication
							where faculty_id = '$faculty_id'
						) as D 
					NATURAL JOIN 
						(
							select 
								publication_id, 
								faculty_id as o_faculty_id, 
								role as o_role,   
								faculty_name as o_faculty_name,    
								faculty_email as o_faculty_email,    
								faculty_department as o_faculty_department,    
								faculty_designation as o_faculty_designation,    
								faculty_website as o_faculty_website,    
								faculty_research_fields as o_faculty_research_fields  
							from Publication_Faculty
							NATURAL JOIN
							Faculty
						) as L
					where faculty_id != o_faculty_id
					and research_fields in ('$research')
					and publication_date >= '$from'
					and publication_date <= '$to';
		";

	echo $query;
	$stmt = $con->prepare($query);
	$stmt->execute();

	$result = $stmt->get_result();

	echo $result->num_rows;
	
	if($result->num_rows) {
		echo "<h2 class='head'>Collaboration Details</h2>
			<table class='table table-striped table-bordered'> 
				<thead class='thead-dark'>
					<th> </th>
					<th colspan='5' style='text-align:center;'>Collaborated With</th>
					<th colspan='6' style='text-align:center;'>Collaborated On</th>
				</thead>

				<thead class='thead-dark'>
				<tr>
					<th scope='col'>Faculty Role</th>
					<th scope='col'>Name</th>
					<th scope='col'>Email</th>
					<th scope='col'>Role</th>
					<th scope='col'>Department</th>
					<th scope='col'>Designation</th>
					<th scope='col'>Publication Title</th>
					<th scope='col'>Research Field</th>
					<th scope='col'>Description</th>
					<th scope='col'>Citations</th>
					<th scope='col'>Pages</th>
					<th scope='col'>Publication Date</th>
				</tr>
				</thead>
		";
		echo "<tbody>";
	
		while($row = $result->fetch_assoc()) {
			printf("<tr>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
					</tr>",
					$row['role'],
					$row['o_faculty_name'],
					$row['o_faculty_email'],
					$row['o_role'],
					$row['o_faculty_department'],
					$row['o_faculty_designation'],
					$row['title'],
					$row['research_fields'],
					$row['description'],
					$row['citations'],
					$row['pages'],
					$row['publication_date']
			);
		}

		echo "<tbody></table>";

		$result->free();
	}
	else
	{
		echo "<h2 class='head'>No Collaboration!!</h2>";
	}

?>

<div style="text-align:center;">
	<a class="btn" href="index.html">BACK TO HOME</a>
</div>

</body>
</html>
