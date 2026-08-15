
<?php
session_start();
error_reporting(0);
//include('includes/dbconnection.php');
include('C:\xampp\htdocs\img\AppointDoc\conn.php');

if(isset($_GET['upid']))
	{
		$upid=$_GET['upid'];
if(isset($_POST['insert'])){
	
	
	
	$name=$_POST['name'];
	$mobile=$_POST['mobile'];
	$email=$_POST['email'];
	$qf=$_POST['qf'];
	$hd=$_POST['hd'];
	$ex=$_POST['ex'];
	$time=$_POST['time'];
	
	/*$images = $_FILES["images"]["name"];
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
				move_uploaded_file($_FILES["images"]["tmp_name"],"../drimages/".$images);
			}*/

	$query="update tbldoctor set FullName='$name', MobileNumber=$mobile, Email='$email',qualification='$qf', experience='$ex', hospital_detail='$hd',timing='$time'   where ID=$upid";
	$result = mysqli_query($conn, $query);
		
			
if($result)
{

echo "<script>alert('Data updated  Successfully');</script>";
header('location:doctorprofile.php');
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";
}
}

	}






if (strlen($_SESSION['admin']==0)) {
  header('location:logout.php');
  } else{


 






  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Search Appointment Detail</title>
	
	<link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css assets/css/app.min.css -->
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/app.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	<script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
	<script>
		Breakpoints();
	</script>
</head>
	
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!--============= start main area -->



<?php include_once('includes/header.php');?>

<?php include_once('includes/sidebar.php');?>


<form id="basic-form" method="post" enctype="multipart/form-data" >
<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
	<section class="app-content">
		<div class="row">
			<!-- DOM dataTable -->
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
					<h3 class="widget-title">Update Doctors Information</h3>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<br>
					<header class="widget-header">
					<?php

	
		$upid=$_GET['upid'];
		$query="select * from tbldoctor where ID=$upid";
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
				
				{
					?>
					
			<?php
	


?>
						
                                <div class="form-group">
                                    <label>Name</label>
                                    <input id="name" type="text" name="name" required="true" class="form-control" value="<?php echo $row[1];?>" style="width: 70%;">
								</div>
								<div class="form-group">
                                    <label>Mobile Number</label>
                                    <input id="mobile" type="text" name="mobile" required="true" class="form-control" value="<?php echo $row[2];?>" style="width: 70%;">
								</div>
								<div class="form-group">
                                    <label>Email</label>
                                    <input id="email" type="text" name="email" required="true" class="form-control" value="<?php echo $row[3];?>" style="width: 70%;">
								</div>
								<?php 
							
							
							$sp = $row['Specialization'] ;	
							
							
											$query1="select * from tblspecialization where ID = $sp";
											$result1 =mysqli_query($conn,$query1);
			
			while($row1 = mysqli_fetch_array($result1))
				{
					
				?>
								
								<div class="form-group">
                                    <label>Specialist</label>
                                    <input id="email" type="text" name="email" required="true" class="form-control" value="<?php echo $row1[1];?>" style="width: 70%;">
								</div>
			<?php 	}	?>		
								
								
								<div class="form-group">
                                    <label>Qualification</label>
                                    <input id="qf" type="text" name="qf" required="true" class="form-control" value="<?php echo $row[6];?>"  style="width: 70%;">
								</div>
								<div class="form-group">
                                    <label>Exerience</label>
                                    <input id="ex" type="text" name="ex" required="true" class="form-control" value="<?php echo $row[7];?>"  style="width: 70%;">
								</div>
								  <div class="form-group">
                                    <label>Hospital_Detail</label>
                                    <input id="hd" type="text" name="hd" required="true" class="form-control" value="<?php echo $row[8];?>" style="width: 70%;">
								</div>
								<div class="form-group">
                                    <label>Timing</label>
                                    <input id="time" type="text" name="time" required="true" class="form-control" value="<?php echo $row[9];?>" style="width: 70%;">
								</div>
								
								
							  
                                <br>
                                <button type="submit" class="btn btn-primary" name="insert" id="submit">Update</button>&nbsp;&nbsp;&nbsp;
								
								<a href="/./img/AppointDoc/admin/changephoto.php?pid=<?php echo $row['ID'];?>">

										<input type="" name="" value="Change Photo" class="btn btn-primary" style="width: 128px;"></a>
                            
					</header><!-- .widget-header -->
					 <?php
				}
	
  ?>
					
					
				</div><!-- .widget -->
			</div><!-- END column -->
			
			
		</div><!-- .row -->
	</section><!-- .app-content -->
</div><!-- .wrap -->
  <!-- APP FOOTER -->
  <?php include_once('includes/footer.php');?>
  <!-- /#app-footer -->
</main>
<!--========== END app main -->


	
		<!-- build:js assets/js/core.min.js -->
	<script src="libs/bower/jquery/dist/jquery.js"></script>
	<script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
	<script src="libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
	<script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
	<script src="libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="libs/bower/PACE/pace.min.js"></script>
	<!-- endbuild -->

	<!-- build:js assets/js/app.min.js -->
	<script src="assets/js/library.js"></script>
	<script src="assets/js/plugins.js"></script>
	<script src="assets/js/app.js"></script>
	<!-- endbuild -->
	<script src="libs/bower/moment/moment.js"></script>
	<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
	<script src="assets/js/fullcalendar.js"></script>
	</form>
</body>
</html>
  <?php } ?>