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
	<a style="float:right;margin-right:10px;background-color:black;" href="ExamAdd.php" class="btn">Add Exam</a><br><br>
	<h1 align="center">Exam</h1>
<?php
	$queryGet = "SELECT
					e.id AS id,
					e.name AS exam_name,
					e.datetime AS datetime,
					COUNT(she.student_id) AS num_stud
				FROM
					exam e
				LEFT JOIN
					student_has_exam she ON e.id = she.exam_id
				GROUP BY
					e.id, e.name;
";	
	$resultGet = mysqli_query($link,$queryGet);
	if(!$resultGet)
	{
		die ("Invalid Query - get Items List: ". mysqli_error($link));
	}
	else
	{?>
	<table id="table" border="1" align="center">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th colspan=2>Exam Date & Time</th>
			<th>No Students</th>
			<th>Action</th>
		</tr>	 
		<form>
<?php	$no=1;
		if(mysqli_num_rows($resultGet)>0){
		while($row= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
		{	
			$datetimeObject = new DateTime($row['datetime']);

			// Get separate date and time variables
			$date = $datetimeObject->format('Y-m-d');
			$time = $datetimeObject->format('H:i:s');
			?>
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $row['exam_name']?></td>
				<td><?php echo $date?></td>
				<td><?php echo $time?></td>
				<td><?php echo $row['num_stud']?></td>
				<td><a href="ExamEdit.php?id=<?php echo $row['id'];?>">
					<img border="0" alt="editB" src="../CSS/btn/editB.png" width="25" height="25"></a>
					<a href="Delete.php?examID=<?php echo $row['id'];?>" onclick="return confirm('Are you sure?')">
					<img border="0" alt="editB" src="../CSS/btn/delB.png" width="25" height="25"></a></a>
				</td>
			</tr>
		<?php	$no++;}}
		else{
?>
			<tr>
				<td colspan="6">No Data</td>
			</tr>
		<?php	}?>
		</form>	
	</table>
	<br><br><br><br>
<?php
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
