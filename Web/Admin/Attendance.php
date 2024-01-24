<?php
session_start();
//if session exists
if(isset ($_SESSION["userId"])) //call this function to check if session exists or not
{
	include "Header.php";
	$user = $_SESSION['userId'];
	?>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style>
  .output{display:none}
  .output2{display:none}
.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 0px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 30%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 70%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=date] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}
input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}
select {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}
label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}

.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
	top: -70px;
    left: 150px;
    /* Position the tooltip */
    position: absolute;
    z-index: 1;
}
.tooltip .tooltiptext img{
	width: 120px;
	height:120px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
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
	display: inline;  
    margin-bottom: 10px;
	text-align: left;
	margin: 3px;
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
.input-group2 select {
	display: inline;
	float: right;
	width: 50%;
	padding: 5px 10px;
	font-size: 16px;
	border-radius: 5px;
	border: 1px solid gray;
	margin-bottom: 0px;
}
input[type=text] {
	margin-bottom: 0px;
}
.content button{
	display: block;
	float: right;	
}
.txt-center {
	text-align: center;
	display: inline;
    left: 50%;
    position: absolute;
}
.btn-take{
	padding: 8px;
    background: green;
    color: black;
	text-decoration: solid;
}
.btn-view{
	padding: 8px;
    background: blue;
    color: white;
	text-decoration: solid;
}
</style>
</head>

<body>
<?php
$queryGet = "SELECT
    e.id AS exam_id,
    e.name AS exam_name,
    e.datetime AS datetime,
    COUNT(she.student_id) AS num_stud,
    SUM(she.attendance) AS total_attendance
FROM
    exam e
LEFT JOIN
    student_has_exam she ON e.id = she.exam_id
GROUP BY
    e.id, e.name;";	
$resultGet = mysqli_query($link,$queryGet);
if(!$resultGet)
{	die ("Invalid Query - get Items List: ". mysqli_error($link));	}
else{	?>
	<center><h3>Attendance List</h3></center>
	<table id="table" border="1" align="center">
		<tr>
			<th>No</th>
			<th>Exam</th>
			<th colspan=2>Date & Time</th>
			<th>No Students</th>
			<th>Attendented Students</th>
			<th>Action</th>
		</tr>
<?php				if(mysqli_num_rows($resultGet)<=0){	?>
		<tr>
			<td colspan="4">No Student Registered</td>
		</tr><?php	}
		else{
			$no=1;
			while($row1= mysqli_fetch_array($resultGet, MYSQLI_BOTH))
			{	
				$datetimeObject = new DateTime($row1['datetime']);

				// Get separate date and time variables
				$date = $datetimeObject->format('Y-m-d');
				$time = $datetimeObject->format('H:i:s');
		?>
		<tr>
			<td><?php echo $no;?></td>
			
			<td><?php echo $row1['exam_name'];?></td>
			<td><?php echo $date;$no++;?></td>
			<td><?php echo $time?></td>
			<td><?php echo $row1['num_stud']?></td>
			<td><?php echo $row1['total_attendance'];?></td>
			<td>
				<a href="AttendanceTake.php?id=<?php echo $row1['exam_id'];?>" class="btn btn-take">More Info</a>
				<!--<a href="AttendanceView.php?id=<?php //echo $row1['exam_id'];?>" class="btn btn-view">View Attendance</a>-->
			</td>
		</tr><?php	}	}?>
	</table>
<?php	}?>
	<script>
		$("#class").on("change", function(){
		  var package = $(this).val();
		  $(".output").hide().prop("disabled", true)
		  $("#" + package).show().prop("disabled", false);
		});

	</script>
	<?php	
}
else{
    echo "No session exists or session has expired. Please log in again ";
	echo "Page will be redirect in 2 seconds";
	header('Refresh: 2; ../Auth/Login.php');
}	?>	 
</body>
</html>
