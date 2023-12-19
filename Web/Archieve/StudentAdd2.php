<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";
if(isset($_GET['errorFlask'])){
	$errorServer = $_GET['errorFlask'];
	if($errorServer==1)
		$error = "Imaging error";
	if($errorServer==2)
		$error = "Other error";
	if($errorServer==3)
		$error = "Image too messy";
	if($errorServer==4)
		$error = "Could not identify features";
	if($errorServer==5)
		$error = "Image invalid";
	if($errorServer==6)
		$error = "Other error";	
	if($errorServer==7)
		$error = "Prints did not match";	
	if($errorServer==8)
		$error = "Bad storage location";	
	if($errorServer==9)
		$error = "Flash storage error";
	
	echo '<script type="text/javascript">
	window.onload = function () 
	{ 
	alert("'.$error.'");
	open("Menu.php","_top");
	}
	</script>';
}?>
<!DOCTYPE html>
<html>
<body>
	<?php 
	$queryCourse = "SELECT * FROM course";	
	$resultCourse = mysqli_query($link,$queryCourse);
	if(!$resultCourse)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
		
	}
	else
	{
		if(mysqli_num_rows($resultCourse)>0){
			$courseDatas[] = ['id' => '', 'name' => 'Choose One'];
			while($rowCourse= mysqli_fetch_array($resultCourse, MYSQLI_BOTH))
			{
				$courseDatas[] = $rowCourse;
			}
		}
		else
			$courseDatas[] = ['id' => '', 'name' => 'Please register course'];
	}
	$querySemester = "SELECT * FROM semester";	
	$resultSemester = mysqli_query($link,$querySemester);
	if(!$resultSemester)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
	}
	else
	{
		if(mysqli_num_rows($resultCourse)>0){
			$semesterDatas[] = ['id' => '', 'name' => 'Choose One'];
			while($rowSemester= mysqli_fetch_array($resultSemester, MYSQLI_BOTH))
			{
				$semesterDatas[] = $rowSemester;
			}	
		}
		else
			$semesterDatas[] = ['id' => '', 'name' => 'Please register semester'];
	}
	?>
	<div class="wrapper">
		<div class="middle">
			<div class="contentnew" style="margin-bottom: 50px;">
			<form class = "content" style="position: relative; width: 60%; margin:auto;left:0" action="StudentAdd.php" name="EditForm" method="POST">
				<h1 class="header">Add Student</h1>
					<div class="input-group">
						<label>Name</label>
						<input type="text" name="name"><br><br>
						<label>Student ID</label>
						<input type="text" name="student_id" pattern='^[A-Z][A-Z]0[01]\d{5}$'><br><br>
						<label>IC No</label>
						<input type="text" name="ic_no"><br><br>
						<label>Email</label>
						<input type="email" name="email"><br><br>
						<label>Course</label>
						<select name="course_id" required>
							<?php
							// Generate HTML options from the array
							foreach ($courseDatas as $courseData) {
								echo '<option value="' . $courseData['id'] . '">' . $courseData['name'] . '</option>';
							}
							?>
						</select><br><br>
						<label>Semester</label>
						<select name="semester_id" required>
							<?php
							// Generate HTML options from the array
							foreach ($semesterDatas as $semesterData) {
								echo '<option value="' . $semesterData['id'] . '">' . $semesterData['name'] . '</option>';
							}
							?>
						</select><br><br>
						<button style="position: relative;left: 80%"; type="submit" class="btn" name="studentAdd">Add</button>
					</div>
			</form>
			</div>
		</div>
	</div>
<?php
	if(isset($_POST['studentAdd']))
	{
		$name = $_POST['name'];
		$student_id = $_POST['student_id'];
		$ic_no = $_POST['ic_no'];
		$email = $_POST['email'];
		$enrol_fingerprint = 0;
		$course_id = $_POST['course_id'];
		$semester_id = $_POST['semester_id'];
		
		$sql = "INSERT INTO student (name, student_id, ic_no, email, enrol_fingerprint, course_id, semester_id) 
				values ('".$name."', '".$student_id."', '".$ic_no."', '".$email."', '".$enrol_fingerprint."', '".$course_id."', '".$semester_id."')";
		$result = mysqli_query($link, $sql);
		if (!$result)
		{
			die("Error:".mysqli_error($ds));
			$fail = "Please Check Registration.";
			echo "<script type='text/javascript'>alert('$fail');
			document.location='Student.php';
			</script>"; 
		}
		else
		{
			$success = "Registration Success.";
			echo "<script type='text/javascript'>alert('$success');
			document.location='Student.php';
			</script>"; 
		}
	}
}		
else	{
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Admin/Login.php');
}
	?>
</body>
</html>
