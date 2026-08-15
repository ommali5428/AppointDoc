<?php 
session_start();
error_reporting(0);
//include('includes/dbconnection.php');
include('C:\xampp\htdocs\img\AppointDoc\conn.php');
if(isset($_POST['submit']))
  {
    $fname=$_POST['fname'];
    $mobno=$_POST['mobno'];
    $email=$_POST['email'];
    $sid=$_POST['specializationid'];
	$qf=$_POST['qf']; //
	$exp=$_POST['exp']; // 
	$hd=$_POST['hd'];//
	$time=$_POST['time'];//
	
	
$password=md5($_POST['password']);
    $ret="select Email from tbldoctor where Email=:email";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ); 

		
		
		$images = $_FILES["images"]["name"];
			$extension = substr($images,strlen($images)-4,strlen($images));
			
			//allowed extension_loaded
			$allowed_extension = array(".jpg","jpeg",".png",".gif");
			
			//validation for allowed extension .in_array() search an array for specific value
			if(!in_array($extension,$allowed_extension))
			{
				echo "<script>alert('featured image has invalid format. Only jpg/jpeg/png/gif format allowed');
						</script>";
			}
			else
			{
				$images = md5($images).time().$extension;
				move_uploaded_file($_FILES["images"]["tmp_name"],"images/".$images);
			}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
if($query -> rowCount() == 0)
{
$sql="Insert Into tbldoctor(FullName,MobileNumber,Email,Specialization,Password,qualification,experience,hospital_detail,timing,images)Values(:fname,:mobno,:email,:sid,:password,:qf,:exp,:hd,:time,:images)";

$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobno',$mobno,PDO::PARAM_INT);
$query->bindParam(':sid',$sid,PDO::PARAM_INT);

$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':qf',$qf,PDO::PARAM_STR);
$query->bindParam(':exp',$exp,PDO::PARAM_STR);
$query->bindParam(':hd',$hd,PDO::PARAM_STR);
$query->bindParam(':time',$time,PDO::PARAM_STR);
$query->bindParam(':images',$images,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

echo "<script>alert('You have signup  Successfully');</script>";
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";
}
}
 else
{

echo "<script>alert('Email-id already exist. Please try again');</script>";
}
}
  
  
  

  ?>
<!doctype html>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Signup Page</title>
	

	<link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/misc-pages.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
</head>
<body class="simple-page" style="background-color:  #44B4FF  ;">
	<div id="back-to-home">
		<a href="/./img/AppointDoc/index.php"  style="font-size: 15px; border: 2px solid #E6EDF1;  "><span style="margin-left: 10px; margin-right: 10px;">Home</span></a>
	</div>
	<div class="-page-wrap">
		
		<div class="" style="width:1000px; margin-left:250px;">
		
		<div class="simple-page-form animated flipInY" id="login-form">
	<h4 class="form-title m-b-xl text-center">Sign Up With Your Account</h4>
	<form method="post" action="" enctype="multipart/form-data">
		<div class="form-group">
			<input id="fname" type="text" class="form-control" placeholder="Full Name" name="fname" required="true">
		</div>

		<div class="form-group">
			<input id="email" type="email" class="form-control" placeholder="Email" name="email" required="true">
		</div>
		<div class="form-group">
			<input id="mobno" type="text" class="form-control" placeholder="Mobile" name="mobno" maxlength="10" pattern="[0-9]+" required="true">
		</div>
		<div class="form-group">
			<select class="form-control" name="specializationid">
				<option value="">Choose Specialization</option>
				<?php
$sql1="SELECT * from tblspecialization";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query1->rowCount() > 0)
{
foreach($results1 as $row1)
{               ?>
				<option value="<?php  echo htmlentities($row1->ID);?>"><?php  echo htmlentities($row1->Specialization);?></option><?php $cnt=$cnt+1;}} ?> 
			</select>
			
		</div>
		
		<div class="form-group">
			<input id="qf" type="text" class="form-control" placeholder="Qualification" name="qf" required="true">
		</div>
		
		<div class="form-group">
			<input id="exp" type="text" class="form-control" placeholder="Experience" name="exp" required="true">
		</div>
		
		<div class="form-group">
			<input id="hd" type="text" class="form-control" placeholder="Hospital Detail" name="hd" required="true">
		</div>
		
		<div class="form-group">
			<input id="images" type="file" class="form-control" placeholder="" name="images" required="true">
		</div>
		
		
		<div class="form-group">
			<input id="time" type="text" class="form-control" placeholder="Timing" name="time" required="true">
		</div>
		
		
		

		<div class="form-group">
			<input id="password" type="password" class="form-control" placeholder="Password" name="password" required="true">
		</div>

		<input type="submit" class="btn btn-primary"  style="background-color:  #44B4FF  ;" value="Register" name="submit">
	</form>
</div><!-- #login-form -->

<div class="simple-page-footer">
	<p>
		<small>Do you have an account ?</small>
		<a href="login.php">SIGN IN</a>
	</p>
</div>


	</div><!-- .simple-page-wrap -->
</body>
</html>