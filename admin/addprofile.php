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
  
  <title> Add New Doctor</title>
  
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
            <h3 class="widget-title">Add New Doctor Pofile</h3>
          </header><!-- .widget-header -->
          <hr class="widget-separator">
		  <br>
          <div class="widget-body">
			<table>
		
					<td style="">
		   
            <form class="form-horizontal" method="post"  enctype="multipart/form-data">
		<div class="form-group">
			 <div class="col-sm-9">
			<input id="fname" type="text" class="form-control" placeholder="Full Name" name="fname" required="true" style="width: 220%">
			  </div>
		</div>
		
        <div class="form-group">
			 <div class="col-sm-9">
			<input id="email" type="email" class="form-control" placeholder="Email" name="email" required="true" style="width: 220%">
					  </div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-9">
			<input id="mobno" type="text" class="form-control" placeholder="Mobile" name="mobno" maxlength="10" pattern="[0-9]+" required="true" style="width: 220%">
		  </div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-9">
			<select class="form-control" name="specializationid" style="width: 220%	">
				<option value="" >Choose Specialization</option>
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
		</div>
		
		<div class="form-group">
			<div class="col-sm-9">
			<input id="qf" type="text" class="form-control" placeholder="Qualification" name="qf" required="true" style="width: 220%">
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-9">
			<input id="exp" type="text" class="form-control" placeholder="Experience" name="exp" required="true" style="width: 220%" >
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-9">
		
			<input id="hd" type="text" class="form-control" placeholder="Hospital Detail" name="hd" required="true" style="width: 220%" >
			</div>
		</div>
		
		<div class="form-group">
			
			<div class="col-sm-9">
			<input id="images" type="file" class="form-control" placeholder="" name="images" required="true" style="width: 220%" >
			</div>
		</div>
		
		
		<div class="form-group">
			<div class="col-sm-9">
			<input id="time" type="text" class="form-control" placeholder="Timing" name="time" required="true" style="width: 220%"  >
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-9">
			<input id="password" type="password" class="form-control" placeholder="Password" name="password" required="true" style="width: 220%">
			</div>
		</div>
		
		
		
		
		
         
              <div class="row">
                <div class="col-sm-9 col-sm-offset-3">
                  <button type="submit" class="btn btn-success" name="submit">Submit</button>
                </div>
              </div>
            </form>
			</td>
			<td style="float: right; margin-left: 350px; margin-top: 30px;">			
				<img src="/./img/AppointDoc/drimages/—Pngtree—hospital medical symbol_5415984.png" style="width: 400px;" >
	</td>
			</table>
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
<?php  ?>