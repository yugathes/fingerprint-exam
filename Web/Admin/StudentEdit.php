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
<?php
	$pID = $_GET["id"];
	$queryGet = "select * from student where id='".$pID."'";

	$resultGet = mysqli_query($link,$queryGet);

	if(!$resultGet)
	{
		die ("Invalid Query - get Register List: ". mysqli_error($link));
	}
	else
	{?>
                            <h6>Student Info</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Student Information</p>
                            <form action="StudentUpdate.php" name="EditForm" method="POST">
                            <?php	while($baris= mysqli_fetch_array($resultGet, MYSQLI_BOTH))	{?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Name</label>
                                        <input class="form-control" type="text" name="name" value="<?php echo $baris['name']; ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $baris['id']; ?>">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="<?php echo $baris['email'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Student ID</label>
                                        <input class="form-control" type="text" name="student_id" pattern="^[A-Z][A-Z]0[01]\d{5}$" value="<?php echo $baris['student_id'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">IC No</label>
                                        <input class="form-control" type="text" name="ic_no" value="<?php echo $baris['ic_no'] ?>">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Maintenance</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Fingerprint Enrollment</label>
                                        <?php if($baris['enrol_fingerprint']==0) {?>
                                            <?php	$link = "http://".$ip.":5000/enroll?uid=".$baris['id'];?>
                                           <a class="form-control btn btn-primary btn-sm ms-auto text-uppercase text-lg" href="<?php echo $link;?>">
                                                    Enroll
                                            </a><?php	}
                                         else if($baris['enrol_fingerprint']==1){	?>
                                            <input class="form-control text-uppercase text-lg-center text-success font-weight-bold" type="text" name="enrollment" value="Enrolled" >
                                        <?php	}	else{}?>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal light">
                            <div class="row">
                                <button type="submit" class="btn btn-primary btn-lg ms-auto" name="staff">Edit</button>
                            </div>

                            <?php	}?>
                            </form>
                        </div>
                        <?php
}?>
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