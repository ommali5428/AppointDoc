<?php
session_start();
error_reporting(0);
//include('includes/dbconnection.php');
include('C:\xampp\htdocs\img\AppointDoc\conn.php');


if(isset($_POST['insert'])){
	
	
	
	$specialization=$_POST['specialization'];
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
				move_uploaded_file($_FILES["images"]["tmp_name"],"../drimages/".$images);
			}

	$sql="Insert Into tblspecialization(ID,Specialization,images)Values('',:specialization,:images)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':specialization',$specialization,PDO::PARAM_STR);
	$query->bindParam(':images',$images,PDO::PARAM_STR);
	$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

echo "<script>alert('Data Inserted  Successfully');</script>";
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";
}
}








if (strlen($_SESSION['admin']==0)) {
  header('location:logout.php');
  } else{


 






  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Categories</title>
	
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
            <h3 class="widget-title">Insert New Specialists Category</h3>
          </header><!-- .widget-header -->
          <hr class="widget-separator">
		  <br>
				
				
					<header class="widget-header">
						
                                <div class="form-group">
                                    <label>Enter Specialization</label>
                                    <input id="specialization" type="text" name="specialization" required="true" class="form-control" placeholder="Enter Specialization" style="width: 70%;">
								</div>
								<div class="form-group">
                                    <label>Upload photo</label>
                                    <input id="images" type="file" name="images" required="true" class="form-control" placeholder="" style="width: 70%;">
                                </div>
                              
                                <button type="submit" class="btn btn-primary" name="insert" id="submit">Insert</button>
                              <br>
							  <hr/>
					</header><!-- .widget-header -->
					 <?php

  ?>
					<header class="widget-header">
            <h3 class="widget-title">Specialization Categories</h3>
          </header><!-- .widget-header -->
          
		 
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-bordered table-hover js-basic-example dataTable table-custom">
								<thead>
									<tr>
										<th>ID</th>
										<th>Specialization</th>
										
									
										<th>Action</th>
										
									</tr>
								</thead>
							
								<tbody>
                  <?php
              $docid=$_SESSION['admin'];
$sql="SELECT * from tblspecialization";
$query = $dbh -> prepare($sql);
//$query-> bindParam(':docid', $docid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
									<tr>
										<td><?php echo htmlentities($row->ID);?></td>
										<td><?php  echo htmlentities($row->Specialization);?></td>
										
                                              
                 
										<td style="width: 300px;"><center>
										<a href="/./img/AppointDoc/admin/updatecat.php?upid=<?php echo ($row->ID);?>">
										<input type="" name="" value="Edit" class="btn btn-primary" style="width: 80px;"></a>&nbsp;
										
										<a href="/./img/AppointDoc/admin/deletecat.php?deleteid=<?php echo ($row->ID);?>">
										<input type="" name="" value="Delete" class="btn btn-primary" style="width: 80px;"></a>
										</center>
										</td>
										
									</tr>
								
	
								</tbody>
                  
                <?php 
$cnt=$cnt+1;
} } else { ?>
  <tr>
    <td colspan="8"> No record found</td>

  </tr>
  <?php } }?>
							</table>
						</div>
					</div><!-- .widget-body -->
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

	<!-- APP CUSTOMIZER -->
<?php //include_once('includes/customizer.php');?>

	
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
