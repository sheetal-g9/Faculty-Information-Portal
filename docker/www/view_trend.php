<!DOCTYPE html>
<html>
<head>
	<title>Trend</title>
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
	$to = $_POST['to'];
	$from = $_POST['from'];
	$faculties = array();
	$research_fields = array();
	$rno = 0;
	$fno = 0;
	
	$con = new mysqli("localhost","root","sheetalg","test");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	echo $from." ";
	echo $to." ";
	if($to == "") {
		$to = date("Y-m-d");
	}
	if($from == "") {
		$from = "1800-01-01";
	}

	$field = $_POST["research_field".$rno];
	$rno = $rno + 1;
	
	while($field) {
		array_push($research_fields, $field);
		$field = $_POST["research_field".$rno];
		$rno = $rno + 1;
	}

	$field = $_POST["faculty".$fno];
	$fno = $fno + 1;

	while($field) {
		array_push($faculties, $field);
		$field = $_POST["faculty".$fno];
		$fno = $fno + 1;
	}
	$rno--;
	$fno--;

	if(count($faculties) == 0) {
		$query = "select faculty_id from Faculty";
		$stmt = $con->prepare($query);
		$stmt->execute();

		$result = $stmt->get_result();
		if (mysqli_num_rows($result)) {
			while ($row = $result->fetch_assoc()) {
				array_push($faculties, $row['faculty_id']);
			}

			$result->free();
		}
	}
	$research = implode("','", $research_fields);

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

	$facs = implode("','", $faculties);

	$query = "select * from Faculty 
							NATURAL JOIN Publication_Faculty 
							NATURAL JOIN Publication 
						where faculty_id in ('$facs')
						and publication_date >= '$from' 
						and publication_date <= '$to' 
						order by faculty_id, research_fields
			";

	$query1 = "select * from Faculty where faculty_id in ('$facs')";

	$stmt = $con->prepare($query);

	function check($research_fields, $str) {
		$fields = explode(',', $str);
		foreach ($fields as $s) {
			foreach ($research_fields as $t) {
				$parts = explode(',', $t);
				foreach($parts as $super_string) {
					$match = strpos($s, $super_string);
					if ($match !== false) {
						return 1;
					}
				}
			}
		}
		return 0;
	}	

	try {
		$stmt->execute();
		$result = $stmt->get_result();

		$prev_f = "";
		$prev_r = "";

		if($result) 
		{
			echo "<h2 class='head'>Publication Trend</h2>
			<table class='table table-striped table-bordered'> 
				<thead class='thead-dark'>
				<tr>
					<th scope='col'>Faculty Name</th>
					<th scope='col'>Faculty Email</th>
					<th scope='col'>Faculty Department</th>
					<th scope='col'>Faculty Designation</th>
					<th scope='col'>Faculty Website</th>
					<th scope='col'>Faculty Research Fields</th>
					<th scope='col'>Research Field</th>
					<th scope='col'>Title</th>
					<th scope='col'>Role</th>
					<th scope='col'>Type</th>
					<th scope='col'>Description</th>
					<th scope='col'>Citations</th>
					<th scope='col'>Pages</th>
					<th scope='col'>Publication Date</th>
				</tr>
				</thead>
				<tbody>
			";

			while($row = $result->fetch_assoc())
			{
				$check_val = check($research_fields, $row['research_fields']);
				if($check_val == 1) {
					if($row['faculty_id'] != $prev_f) {
						printf("<tr>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
									<td> %s </td>
								</tr>", 
								$row['faculty_name'],
								$row['faculty_email'],
								$row['faculty_department'],
								$row['faculty_designation'],
								$row['faculty_website'],
								$row['faculty_research_fields'],
								$row['research_fields'],
								$row['title'],
								$row['role'],
								$row['type'],
								$row['description'],
								$row['citations'],
								$row['pages'],
								$row['publication_date']
						);
						
						$prev_f = $row['faculty_id'];
						$prev_r = $row['research_fields'];
					}
					else {
						if($row['research_fields'] != $prev_r) {
							printf("<tr>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
							 		</tr>", 
									$row['research_fields'],
									$row['title'],
									$row['role'],
									$row['description'],
									$row['citations'],
									$row['pages'],
									$row['publication_date']
							);
							$prev_r = $row['research_fields'];
						}
						else {
							printf("<tr>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
										<td> %s </td>
							 		</tr>", 
									$row['title'],
									$row['role'],
									$row['description'],
									$row['citations'],
									$row['pages'],
									$row['publication_date']
							);
						}
					}
				}
			}
			echo "</tbody> </table>";
			$result->free();
		}
	}
	catch (exception $e){
		echo $e;
	}
	finally {
		echo $val;
	}
?>

<div style="text-align:center;">
	<a class="btn" href="index.html">BACK TO HOME</a>
</div>

</body>
</html>