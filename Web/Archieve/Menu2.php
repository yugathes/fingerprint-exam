<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	* {
	  box-sizing: border-box;
	}

	body {
	  font-family: Arial, Helvetica, sans-serif;
	}

	/* Float four columns side by side */
	.column {
	  float: left;
	  width: 33.3%;
	  padding: 0 10px;
	}

	/* Remove extra left and right margins, due to padding */
	.row {margin: 0 20px;color: black;}

	/* Clear floats after the columns */
	.row:after {
	  content: "";
	  display: table;
	  clear: both;
	}

	/* Responsive columns */
	@media screen and (max-width: 600px) {
	  .column {
		width: 100%;
		display: block;
		margin-bottom: 20px;
	  }
	}

	/* Style the counter cards */
	.card {
	  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
	  padding: 16px;
	  color: white;
	  text-align: center;
	  background-color: black;
	}
	.card p {
		font-size: 25;
	}
</style>
</head>
<body>
<?php

	$lecturerQ = "select * from users where type_user='Lecturer'";
	$lecturerR = mysqli_query($link,$lecturerQ);
	$lecturer = mysqli_num_rows($lecturerR);
	$studentQ = "select * from student";
	$studentR = mysqli_query($link,$studentQ);
	$student = mysqli_num_rows($studentR);
	$faceQ = "select * from student where enrol_fingerprint='1'";
	$faceR = mysqli_query($link,$faceQ);
	$face = mysqli_num_rows($faceR);
	?>
	<h1 align="center">Welcome to UNITEN Exam Attendance System </h1>

	<div class="row">
		<div class="column">
			<div class="card">
				<h3>Total Student Fingerprint Enrolled</h3>
				<p><?php echo $face;?></p>
			</div>
		</div>
  
		<div class="column">
			<div class="card">
				<h3>Total Lecturer</h3>
				<p><?php echo $lecturer;?></p>
			</div>
		</div>
  
		<div class="column">
			<div class="card">
				<h3>Total Student</h3>
				<p><?php echo $student;?></p>
			</div>
		</div>
</div>
	
<?php
	}
	
else	{
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Auth/Login.php');
}
?>
</body>
</html>
