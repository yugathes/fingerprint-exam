<?php
session_start();
include "../Auth/connection.php";
if (isset($_POST['studentAdd'])) {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $ic_no = $_POST['ic_no'];
    $email = $_POST['email'];
    $enrol_fingerprint = 0;

    $sql = "INSERT INTO student (name, student_id, ic_no, email, enrol_fingerprint) 
				values ('" . $name . "', '" . $student_id . "', '" . $ic_no . "', '" . $email . "', '" . $enrol_fingerprint . "')";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        $fail = "Please Check Registration.";
        echo "<script type='text/javascript'>alert('$fail');
			document.location='StudentAdd.php';
			</script>";
        die("Error:" . mysqli_error($link));
    } else {
        $success = "Registration Success.";
        $_SESSION['notification'] = $success.', '.$name;
        header("Location: Student.php");
        exit();
    }
}
?>