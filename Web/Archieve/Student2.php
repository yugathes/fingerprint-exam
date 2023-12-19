<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html>
<head>
<style>
	/* Apply the CSS rule to the <td> elements with a class of "word-wrap" */
	.word-wrap {
		white-space: pre-line; /* Allow wrapping */
		width: 120px; /* Adjust the width as needed */
	}
</style>
</head>
<body>
	<a style="float:right;margin-right:10px" href="StudentAdd.php" class="btn">Add Student</a><br><br>
	<h1 align="center"> Student Users</h1>
	<br>
<?php
	$queryGet = "select * from student";	
	$resultGet = mysqli_query($link,$queryGet);
	if(!$resultGet)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
	}
	else
	{?>
	<table id="table" border="1" align="center">
		<tr>
			<th>Name</th>
			<th>Student ID</th>
			<th>IC No</th>
			<th>Email</th>
			<th>Course</th>
			<th>Semester</th>
			<th>Fingerprint Enrollment</th>
			<th>Action</th>
		</tr>	 
		
<?php	while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
		{	?>
			<tr>
				<td><?php echo $row['name']?></td>
				<td><?php echo $row['student_id'];?></td>
				<td><?php echo $row['ic_no']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td class='word-wrap'><?php echo getCourseName($row['course_id']); ?></td>
				<td class='word-wrap'><?php echo getSemesterName($row['semester_id']); ?></td>
				<td><?php if($row['enrol_fingerprint']==1) echo "Enrolled"; else echo "Haven't Enrolled";?></td>
				<td><a href="StudentEdit.php?id=<?php echo $row['id'];?>">
					<img border="0" alt="editB" src="../CSS/btn/editB.png" width="25" height="25"></a>
					<a href="Delete.php?sid=<?php echo $row['id'];?>" onclick="return confirm('Are you sure?')">
					<img border="0" alt="editB" src="../CSS/btn/delB.png" width="25" height="25"></a></a>
				</td>
			</tr>
<?php	}?>
		
	</table>
<?php
	}
}		
else	{
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Admin/Login.php');
}
if (isset($_POST['updateBTN'])) 
{
	$username =$_POST["username"];
	$verification = "Verified";
	$queryInsert = "UPDATE users SET 
					verification = '".$verification."' 
					WHERE username = '".$username."'";
	 
	$resultInsert = mysqli_query($link,$queryInsert);
	if (!$resultInsert)
	{
		die ("Error: ".mysqli_error($link));
	}
	else 
	{
		echo '<script type="text/javascript">
		            window.onload = function () 
		            { 
					alert("User been verified...");
					open("Retailer.php","_top");
					}
					</script>';

	}
}
	?>
</body>
</html>
