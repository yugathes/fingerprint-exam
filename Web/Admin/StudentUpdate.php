<?php
    session_start();
	include "../Auth/connection.php";
	$name = $_POST["name"];
	$student_id = $_POST["student_id"];
	$email = $_POST["email"];
	$ic_no = $_POST["ic_no"];
	$uID = $_POST["id"];
		
	$queryInsert = "UPDATE student SET
	   name = '".$name."', 
	   ic_no = '".$ic_no."', 
	   student_id = '".$student_id."', 
	   email = '".$email."'
	   WHERE id = '$uID'";

	$resultInsert = mysqli_query($link,$queryInsert);
	if (!$resultInsert)
	{
		die ("Error: ".mysqli_error($link));
	}		
	else {
        $success = "Student Detail has been Updated";
        $_SESSION['notification'] = $success;
        header("Location: Student.php");
        exit();
	}
?>