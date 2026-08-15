<?php
session_start();
error_reporting(0);

//include('C:\xampp\htdocs\img\AppointDoc\conn.php');
include('header.php');


    if (strlen($_SESSION['uid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['update']))
  {
    $did=$_SESSION['uid'];
    $name=$_POST['name'];
 
  $email=$_POST['email'];
  $_SESSION['user_name']=$name;
  
  $sql="update user_form set name=:name,email=:email  where id=:did";
     $query = $dbh->prepare($sql);
     $query->bindParam(':name',$name,PDO::PARAM_STR);
     $query->bindParam(':email',$email,PDO::PARAM_STR);
     
     $query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();

        echo '<script>alert("Profile has been updated")</script>';
     

  }
  
 







  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <title> Doctor Profile</title>
  
  
 <link rel="stylesheet" href="/./img/AppointDoc/css/user.css"> 
  <!-- build:css assets/css/app.min.css -->
 
  
  <script>
    Breakpoints();
  </script>
</head>
  
<body style="background-color: white;" >
<!--============= start main area -->

            <form  class="form-horizontal" method="post" style="margin-left: 15%;">


<!-- APP MAIN ==========-->
<main align="">
  <div class="wrap">	
  <section class="app-content">
    <div class="row" style="margin-top: 120px; ">	
     
      
            <?php
			
	if(isset($_SESSION['uid']))
	{		
$did=$_SESSION['uid'];
$query="select * from user_form where id=$did";
$result=mysqli_query($conn,$query);
			
			
			while($row = mysqli_fetch_array($result))
				
				{

               ?>
			   <h1 align="center" style="padding-bottom: 10px; margin-right: 300px "> User Information</h1>
			   <hr></hr>
			   
              <div class="form-group" >
                <label for="exampleTextInput1" class="col-sm-3 control-label" > Name:</label>
                <div class="col-sm-9">
                  <input id="name" type="text" class="form-control" placeholder="" name="name" required="true" value="<?php  echo $row[1];?>" style="width: 50%;">
                </div>
              </div>
                          
              <div class="form-group"> 
                <label for="email2" class="col-sm-3 control-label"  >Email:</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" value="<?php  echo $row[2];?>" required='true' style="width: 50%;">
                </div>
              </div>
			  
			  
			  <?php 
		  } 
		  
	}
	?>
	<?php  
	
	if(isset($_SESSION['em']))
	{		
$appid=$_SESSION['em'];
$query="select * from tblappointment where Email='$appid' ";
$result=mysqli_query($conn,$query);
			
			
			while($row = mysqli_fetch_array($result))
				
				{
	
					
	?>
              
			   <div class="form-group">
                <label for="email2" class="col-sm-3 control-label"  >Appointment Number:</label>
                <div class="col-sm-9">
				
				
                  <label class="form-control" type="text" style="width: 50%;" ><?php echo $row[1];?></label>
				
				  
                </div>
              </div>
			  
			 
				<?php }
				
	}
	
	?>	
	 
			
		  <div class="row" >
                <div class="col-sm-9 col-sm-offset-3">
                  <input type="submit" class="button" name="update" value="Update" style="width: 100px; height: 30px;">
                </div>
              </div>
             
            
              
            
         

    </div><!-- .row -->
  </section><!-- #dash-content -->
</div><!-- .wrap -->
   

</main>

  
  
 </form>
 
</body>
</html>
  <?php } ?>