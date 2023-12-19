<?php
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
	open("Student.php","_top");
	}
	</script>';
}?>
<!DOCTYPE html>
<html>
<head>
</head>
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
	$pID = $_GET["id"];
	$queryGet = "select * from student where id='".$pID."'";

	$resultGet = mysqli_query($link,$queryGet);

	if(!$resultGet)
	{
		die ("Invalid Query - get Register List: ". mysqli_error($link));
	}
	else 
	{?>
	<div class="wrapper">
		<div class="middle">
			<div class="contentnew" style="margin-bottom: 50px;">
			<form class = "content" style="position: relative; width: 60%; margin:auto;left:0" action="StudentUpdate.php" name="EditForm" method="POST">
				<h1 class="header">Edit Student Detail</h1>
				<?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
					<div class="input-group">
						<label>Name</label>
						<input type="text" name="name" value="<?php echo $baris['name']; ?>"><br><br>
						<input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
						<label>Student ID</label>
						<input type="text" name="student_id" pattern="^[A-Z][A-Z]0[01]\d{5}$" value="<?php echo $baris['student_id'] ?>"><br><br>
						<label>IC No</label>
						<input type="text" name="ic_no" value="<?php echo $baris['ic_no'] ?>"><br><br>
						<label>Email</label>
						<input type="email" name="email" value="<?php echo $baris['email'] ?>"><br><br>
						<label>Course</label>
						<select name="course_id" required>
							<?php
							
							// Generate HTML options from the array
							foreach ($courseDatas as $courseData) {
								$value = '';
								if($baris['course_id']== $courseData['id'])
									$value = ' selected';
								echo '<option value="' . $courseData['id'] . '"  '.$value.'>' . $courseData['name'] . '</option>';
							}
							?>
						</select><br><br>
						<label>Semester</label>
						<select name="semester_id" required>
							<?php
							
							// Generate HTML options from the array
							foreach ($semesterDatas as $semesterData) {
								$value2 = '';
								// echo $semesterData['id'];
								if($baris['semester_id'] == $semesterData['id']){
									echo "Hi";
									$value2 = ' selected';}
								echo '<option value="' . $semesterData['id'] . '" '.$value2.'>' . $semesterData['name'] . '</option>';
							}
							?>
						</select><br><br>
						<label>Fingerprint Enrollment</label>
						<?php if($baris['enrol_fingerprint']==0) {?>
						<?php	$link = "http://".$ip.":5000/enroll?uid=".$baris['id'];?>
						<a href="<?php echo $link;?>">
						<p type="" class="btn" style="margin-top: 10px;">
							Enroll
						</p>
						</a></input><?php	} else{}?>
						<?php if($baris['enrol_fingerprint']==1){	?>
						<input type="text" name="enrollment" value="Enrolled" disabled><br><br>
						<?php	}	else{}?>
						<button style="position: relative;left: 80%"; type="submit" class="btn" name="staff">Update</button>
					</div> <?php	}?>
			</form>
			</div>
		</div>
	</div>
	<?php
		}
}
else {
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Admin/Login.php');
}
	?>

</body>
</html>
