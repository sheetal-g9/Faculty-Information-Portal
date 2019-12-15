<!DOCTYPE html>
<html>
<head>
	<title>Faculty Portal</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

	<style type="text/css">
		body {
			background: #03a9f4;
		}
		.container {
			margin: 5% 5% 5% 5%;
			padding: 1% 5% 5% 5%;
			border-radius: 10px;
		}

		.head {
			text-align: center;
			font-size: 3.2em;
			color: #424242;
			margin: 50px 50px 40px 0px;
		}

		.card {
			/*color:#00b0ff;*/
			/*background: #00897b;*/
			padding-top: 15px;
			width:20%;
			margin: 20px 0px;
		}
	</style>
</head>
<body>
	<div class="container">
		<h2 class="head">Faculty Information Portal</h2>
		
		<div class="row">		
			<div class="card col-lg-3 col-md-3 col-sm-3 col-3">
			  <img src="image.png" class="card-img-top" alt="...">
			  <div class="card-body">
			    <h5 class="card-title">Register a new Faculty</h5>
				<a class="btn btn-primary" href="insert_faculty.html">Insert Faculty</a>
			  </div>
			</div>

			<div class="col-lg-1 col-md-1 col-sm-1 col-1"></div>
			
			<div class="card col-lg-3 col-md-3 col-sm-3 col-3">
			  <img src="image.png" class="card-img-top" alt="...">
			  <div class="card-body">
			    <h5 class="card-title">Insert a new Publication</h5>
				<a class="btn btn-primary" href="insert_publication.html">Insert Publication</a>
			  </div>
			</div>
			
			<div class="col-lg-1 col-md-1 col-sm-1 col-1"></div>

			<div class="card col-lg-3 col-md-3 col-sm-3 col-3">
			  <img src="image.png" class="card-img-top" alt="...">
			  <div class="card-body">
			    <h5 class="card-title">Insert a new Project</h5>
				<a class="btn btn-primary" href="insert_project.html">Insert Project</a>
			  </div>
			</div>
		</div>
		
		<div class="row">
			<div class="card col-lg-3 col-md-3 col-sm-3 col-3">
			  <img src="image.png" class="card-img-top" alt="...">
			  <div class="card-body">
			    <h5 class="card-title">View Details of a Faculty</h5>
				<a class="btn btn-primary" href="view_faculty.html">Faculty Details</a>
			  </div>
			</div>

			<div class="col-lg-1 col-md-1 col-sm-1 col-1"></div>
			<div class="card col-lg-3 col-md-3 col-sm-3 col-3">
				<img src="image.png" class="card-img-top" alt="...">
				<div class="card-body">
					<h5 class="card-title">View Research/Project Details</h5>
					<a class="btn btn-primary" href="view_research.html">Research Details</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="card col-lg-3 col-md-3 col-sm-3 col-3">
			  <img src="image.png" class="card-img-top" alt="...">
			  <div class="card-body">
			    <h5 class="card-title">View Trends</h5>
			    <p class="card-body">trends of publications for various facultiesover the past 3 years, by year</p>
				<a class="btn btn-primary" href="view_trend.html">Trends</a>
			  </div>
			</div>

			<div class="col-lg-1 col-md-1 col-sm-1 col-1"></div>
			<div class="card col-lg-3 col-md-3 col-sm-3 col-3">
				<img src="image.png" class="card-img-top" alt="...">
				<div class="card-body">
					<h5 class="card-title">Collaboration Trends</h5>
					<p class="card-body">The collaboration trends of a faculty</p>
					<a class="btn btn-primary" href="collaboration_trend.html">Collaboration Trends</a>
				</div>
			</div>
		</div>

		</div>
	</div>

</body>
</html>