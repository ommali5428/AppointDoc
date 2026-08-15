<?php
session_start();
error_reporting(0);

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
				move_uploaded_file($_FILES["images"]["tmp_name"],"../appointment/dr_pannel/images/".$images);
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
<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Doctors Profile</title>
  
  <style>
  table{
	  border: solid 2px black;
	  }
  td{
	  border: solid 2px black;
  }
  th{
	  border: solid 2px black;
	 
	  
	  
	  
  }
  img{
		width: 400px;
  }
  
  </style>
  
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

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
  <section class="app-content">
    <div class="row">
     
      <div class="col-md-12">
        <div class="widget">
          <header class="widget-header">
            <h3 class="widget-title">Doctors Pofile</h3>
          </header><!-- .widget-header -->
          <hr class="widget-separator">
		  <br>
          <div class="widget-body">
           
            <form class="form-horizontal" method="post"  enctype="multipart/form-data">
			<div class="table-responsive">
							<table class="table table-bordered table-hover js-basic-example dataTable table-custom">
								<thead>
									<tr>
										
										<th>Name</th>
										<th>Qualification</th>
										<th>Experience</th>
										<th>Hospital_detail</th>
									<th>Timing</th>
										<th>Specialist</th>
										<th>Images</th>
										<th>Action</th>
										
									</tr>
								</thead>
								
								<tbody>
							<?php 
							$query="select * from tbldoctor";
							$result=mysqli_query($conn,$query);
							while($row= mysqli_fetch_array($result))
							{
								
							?>
								
								
								
								
								
								<tr>
										<td><?php echo $row[1];?></td>
										<td><?php echo $row[6];?></td>
										<td><?php echo $row[7];?></td>
										<td><?php echo $row[8];?></td>
										<td><?php echo $row[9];?></td>
										<td>
							<?php 
							
							
							$sp = $row['Specialization'] ;	
							
							
											$query1="select * from tblspecialization where ID = $sp";
											$result1 =mysqli_query($conn,$query1);
			
			while($row1 = mysqli_fetch_array($result1))
				{
					echo $row1[1];
				}
							
									
							
							?>            
								</td>
										
										
										<td><img src="/./img/AppointDoc/appointment/dr_pannel/images/<?php echo $row[10];?>" ></td>
                        
                 
										<td style="width: 185px;"><center>
										<a href="/./img/AppointDoc/admin/updatedr.php?upid=<?php echo $row['ID'];?>">
										<input type="" name="" value="Edit" class="btn btn-primary" style="width: 80px;"></a>&nbsp;
										
										<a href="/./img/AppointDoc/admin/deletedr.php?deleteid=<?php echo $row['ID'];?>">

										<input type="" name="" value="Delete" class="btn btn-primary" style="width: 80px;"></a>
										</center>
										</td>
									</tr>
							<?php } ?>
	
								</tbody>
							</table>	
						</div>
                 
            </form>
          </div><!-- .widget-body -->
        </div><!-- .widget -->
      </div><!-- END column -->

    </div><!-- .row -->
  </section><!-- #dash-content -->
</div><!-- .wrap -->
  <!-- APP FOOTER -->
  <?php include_once('includes/footer.php');?>
  <!-- /#app-footer -->
</main>
<!--========== END app main -->


  
  <!-- SIDE PANEL -->
 

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
</body>
</html>
