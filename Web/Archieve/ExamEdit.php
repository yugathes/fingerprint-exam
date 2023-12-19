<?php
session_start();

//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{	include "Header.php";?>
<!DOCTYPE html>
<html>
<head>
<style>
.checkbox {
	display: inline-flex; /* Use a flex container for horizontal alignment */
	align-items: center; /* Vertically center the elements */
}
        
.checkbox input[type="checkbox"] {
	margin-right: 10px; /* Add some space between the checkbox and input */
}
</style>
</head>
<body>
<?php
	$pID = $_GET["id"];
	$queryGet = "select * from exam where id='".$pID."'";

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
			<form class = "content" style="position: relative; width: 60%; margin:auto;left:0" action="ExamEdit.php" name="EditForm" method="POST">
				<h1 class="header">Edit Class Detail</h1>
				<?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
					<div class="input-group">
						<label>Name</label>
						<input type="text" name="name" value="<?php echo $baris['name']; ?>"><br><br>
						<input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
						<label>Date & Time</label>
						<input type="datetime-local" name="datetime" value="<?php echo $baris['datetime']; ?>">
						<br><br>
						<button style="position: relative;left: 80%"; type="submit" class="btn" name="exam_update">Update</button>
					</div> <?php	}?>
			</form>
			</div>
		</div>
	</div>
	<?php
	}
	if(isset($_POST['exam_update']))
	{
		$id = $_POST['id'];
		$className = $_POST['name'];
		$datetime = $_POST['datetime'];
		
		
		$queryInsert = "UPDATE exam SET
		   name = '".$className."', 
		   datetime = '".$datetime."'
		   WHERE id = '$id'";
		$result = mysqli_query($link,$queryInsert);
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
else {
	echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 5 seconds";
	header('Refresh: 5; ../Admin/Login.php');
}
	?>

</body>
</html>
