<?php

session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
//if session exists
if(isset ($_SESSION["userId"])) //session userid gets value from text field named userid, shown in user.php
{
    include "Header.php";
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
    <html lang="en">

    <body class="g-sidenav-show dark-version bg-gray-100">

    <main class="main-content position-relative border-radius-lg ">
        <?php include "navbar.php";?>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Student Registration</h6>
                        </div>
                        <div class="card-body">
                            <form style="position: relative; width: 60%; margin:auto;left:0" action="StudentAddBE.php" name="EditForm" method="POST">
                            <p class="text-uppercase text-sm">Student Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Name</label>
                                        <input class="form-control" type="text" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Student ID</label>
                                        <input class="form-control" type="text" name="student_id"> <!--pattern="^[A-Z][A-Z]0[01]\d{5}$"-->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">IC No</label>
                                        <input class="form-control" type="text" name="ic_no">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal light">
                            <div class="row">
                                <button type="submit" class="btn btn-primary btn-lg ms-auto" name="studentAdd">Add</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include "footer.php";?>
    </body>
    </html>
<?php
}

else	{
    echo "No session exists or session has expired. Please log in again ";
    echo "Page will be redirect in 5 seconds";
    header('Refresh: 5; ../Auth/Login.php');
}
?>