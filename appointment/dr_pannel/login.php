<?php
session_start();
error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

if(isset($_POST['login'])) 
  {
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID,Email FROM tbldoctor WHERE Email=:email and Password=:password";
    $query=$dbh->prepare($sql);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
	
    if($query->rowCount() > 0)
{
foreach ($results as $result) {
$_SESSION['damsid']=$result->ID;
$_SESSION['damsemailid']=$result->Email;

}
$_SESSION['login']=$_POST['email'];
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
} else{
echo "<script>alert('Invalid Details');</script>";
}
}

?>
<!doctype html>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Login Page</title>
	

	<link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/misc-pages.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
</head>
<body class="simple-page" style="background-color: ; background-image: url('/./img/AppointDoc/drimages/19373.jpg');  background-size: 100%; ">
	<div id="back-to-home">
		<a href="/./img/AppointDoc/index.php"  style="font-size: 15px; border: 2px solid #E6EDF1;  "><span style="margin-left: 10px; margin-right: 10px;">Home</span></a>
	</div>
	<div class="simple-page-wrap" style="margin-top: 150px;" >
		<div class="simple-page-logo animated swing">
			
				<span style="color: white"><i ></i></span>
				<span style="color: white"></span>
			
		</div><!-- logo -->
		<div class="simple-page-form animated " id="login-form">
	<h4 class="form-title m-b-xl text-center">Sign In With Your Account</h4>
	<form method="post" name="login">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Enter Registered Email ID" required="true" name="email">
		</div>

		<div class="form-group">
			<input type="password" class="form-control" placeholder="Password" name="password" required="true">
		</div>

		
		<input type="submit" class="btn btn-primary" style="background-color:  #3F00FF  ;" name="login" value="Sign IN">
	</form>
	<hr />
	<a style="color: #3F00FF">Contact The Admin For Signup</a>
</div><!-- #login-form -->

<div class="simple-page-footer">
	<p><a href="forgot-password.php">FORGOT YOUR PASSWORD ?</a></p>
	
</div><!-- .simple-page-footer -->


	</div><!-- .simple-page-wrap -->
</body>
</html>