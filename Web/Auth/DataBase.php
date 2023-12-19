<?php
session_start();

// initializing variables
$staffId = "";
$password    = "";
$errors = array(); 

// connect to the database
$ds = mysqli_connect('localhost', 'root', '', 'library');


 // LOGIN USER
if (isset($_POST['login_user'])) {
  $staffId = mysqli_real_escape_string($ds, $_POST['staffId']);
  $password = mysqli_real_escape_string($ds, $_POST['password']);
  
  if (empty($staffId)) {
  	array_push($errors, "staffId is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	  	//encrypt the password before saving in the database$password = md5($password)
  	$query = "SELECT * FROM users WHERE staffId='$staffId' AND password='$password'";
  	$results = mysqli_query($ds, $query);
  	if (mysqli_num_rows($results) == TRUE) 
	{
	     while($baris= mysqli_fetch_array($results, MYSQLI_BOTH))
	    {
		    $type_user = $baris['type_user'];
			$id = $baris['id'];
			$name = $baris['name'];
	    }
		if ($type_user == "Admin")
		{
			$_SESSION['userId'] = $id;
			$_SESSION['name'] = $name;
			$_SESSION['success'] = "You are now logged in";
			header('location: ../Admin/Menu.php');
		}
		elseif ($type_user == "Lecturer")
		{
			$_SESSION['userId'] = $id;
			$_SESSION['name'] = $name;
			$_SESSION['success'] = "You are now logged in";
			header('location: ../Lecturer/Menu.php');
		}
  	}
	else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>
