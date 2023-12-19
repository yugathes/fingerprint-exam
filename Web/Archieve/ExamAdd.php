<?php
//call this function to check if session exists or not
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";
	?>
<!DOCTYPE html>
<html>
<head>
<style>
.mid{
	margin: auto;
	width: 50%;
	padding: 10px;
	
}
.content2 {
	margin: auto;
	margin-top: 20px;
	width: 100%;
	padding: 20px; 
	border: 1px solid #483235;
	background: white;
	border-radius: 10px 10px 10px 10px;
}
.input-group2 {
  margin: 10px 0px 10px 0px;
}
.input-group2 label {
	display: inline-flex;  
    margin-bottom: 10px;
	text-align: left;
	margin: 3px;
}
.input-group2 input {
	display: inline;
	float: right;
	height: 30px;
	width: 70%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.input-group2 select {
	display: inline;
	float: right;
	height: 30px;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.input-group2 textarea {
	display: inline;
	float: right;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
}
.content button{
	display: block;
	float: right;
	
}
</style>
</head>
<body>
	<div class="mid">
		<form class="content2" action="ExamAdd.php" method="POST">
			<h1 class="header">Exam Registration</h1>
				<div class="input-group2">
					<label>Subject Name*</label>
					<input type="text" name="name" required><br><br>
					<label>Date & Time</label>
					<input type="datetime-local" name="datetime"><br><br>
					<p style="margin-top: 0px;float: right;color: red;">* is required to fill</p>
				</div> 	
				<br>
				<button type="submit" class="btn" style="margin-top: 10px;" name="reg_subject">Register</button>	
		</form>
	</div>
	<br><br><br><br>
<?php
	if(isset($_POST['reg_subject']))
	{
		$name = $_POST['name'];
		$datetime = $_POST['datetime'];
		
		$sql = "INSERT INTO exam (name, datetime) 
				values ('".$name."', '".$datetime."')";
		$result = mysqli_query($link, $sql);
		if (!$result)
		{
			die("Error:".mysqli_error($ds));
			$fail = "Please Check Registration.";
			echo "<script type='text/javascript'>alert('$fail');
			document.location='Exam.php';
			</script>"; 
		}
		else
		{
			$success = "Registration Success.";
			echo "<script type='text/javascript'>alert('$success');
			document.location='Exam.php';
			</script>"; 
		}
	}	
}	
else	{
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Auth/Login.php');
}
?>
</body>
</html>
