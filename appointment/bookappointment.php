<?php

//error_reporting(0);

include('C:\xampp\htdocs\img\AppointDoc\header.php');
//include('C:\xampp\htdocs\img\AppointDoc\conn.php');
$query="select AppointmentNumber from tblappointment";
$result=mysqli_query($conn,$query);
			
    if(isset($_POST['submit']))
  {
	  
	  if (strlen($_SESSION['uid'] == NULL)) {
  
		 echo '<script>alert("Please Login To Book Appointment")</script>';
echo "<script>window.location.href ='../login/login_form.php'</script>";
	  }
	  else{
		  
		
 $name=$_POST['name'];
  $mobnum=$_POST['phone'];
 $email=$_POST['email'];
 $appdate=$_POST['date'];
 $aaptime=$_POST['time'];
 $specialization=$_POST['specialization'];
  $doctorlist=$_POST['doctorlist'];
 $message=$_POST['message'];
 $aptnumber=mt_rand(100000000, 999999999);
 $cdate=date('Y-m-d');

if($appdate<=$cdate){
       echo '<script>alert("Appointment date must be greater than todays date")</script>';
} else {
$sql="insert into tblappointment(AppointmentNumber,Name,MobileNumber,Email,AppointmentDate,AppointmentTime,Specialization,Doctor,Message)values(:aptnumber,:name,:mobnum,:email,:appdate,:aaptime,:specialization,:doctorlist,:message)";
$query=$dbh->prepare($sql);
$query->bindParam(':aptnumber',$aptnumber,PDO::PARAM_STR);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':mobnum',$mobnum,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':appdate',$appdate,PDO::PARAM_STR);
$query->bindParam(':aaptime',$aaptime,PDO::PARAM_STR);
$query->bindParam(':specialization',$specialization,PDO::PARAM_STR);
$query->bindParam(':doctorlist',$doctorlist,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);

 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Your Appointment Request Has Been Send.We Will Contact You Soon ")</script>';
echo "<script>window.location.href ='bookappointment.php'</script>";



  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
}
  }
?>
<!doctype html>
<html lang="en">
    <head>
	<title>Doctor Appointment </title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <link href="css_app/bootstrap.min1.css" rel="stylesheet">

        
        <link href="css_app/templatemo-medic-care4.css" rel="stylesheet">
		
       
        <script>
function getdoctors(val) {
  //  alert(val);
$.ajax({

type: "POST",
url: "get_doctors.php",
data:'sp_id='+val,
success: function(data){
$("#doctorlist").html(data);
}
});
}
</script>
    </head>
	<body style=" background-color:White; border-radius: 10px;">
		
	            <section class="section-padding" id="booking" >
                <div class="container" >
                    <div class="row" >
                    
                        <div class="col-lg-8 col-12 mx-auto" >
                            <div class="booking-form" >
                                
                                <h3 class="text-center mb-lg-3 mb-2" style="color:#0188df; " >Book an appointment</h3>
                            
                                <form role="form" method="post" style="margin-top:30px;">
                                    <div class="row" style="">
                                        <div class="col-lg-6 col-12" style=" " >
                                            <input type="text" name="name" id="name" class="form-control" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;" placeholder="Full name" required='true'>
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;" class="form-control" placeholder="Email address" required='true'>
                                        </div>
                                   
                                        <div class="col-lg-6 col-12">
                                            <input type="telephone" name="phone" id="phone" class="form-control" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;" placeholder="Enter Phone Number" maxlength="10">
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <input type="date" name="date" id="date" value="" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;" class="form-control">
                                            
                                        </div>

                                            <div class="col-lg-6 col-12">
                                            <input type="time" name="time" id="time" value="" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;" class="form-control">
                                            
                                        </div>

    <div class="col-lg-6 col-12">
<select onChange="getdoctors(this.value);"  name="specialization" id="specialization" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;" class="form-control" required>
<option value="">Select specialization</option>
<!--- Fetching States--->
<?php

$id=$_GET['id'];
	
if($id == NULL)
{
	
$sql="SELECT * FROM tblspecialization";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 
  ?>
<option  value="<?php echo $row['ID'];?>"><?php echo $row['Specialization'];?></option>


<?php 
}
}
elseif($id != NULL)
{
$sql="SELECT * FROM tblspecialization where ID=$id";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 

	?>		
<option   value="<?php echo $row['ID'];?>"><?php echo $row['Specialization']; ?></option>

<?php }
}
else
{
		'<script>alert("Something Went Wrong")</script>';
}

 ?>


</select>
</div>


    <div class="col-lg-6 col-12">
<select name="doctorlist" id="doctorlist" style="font-size:15px; background-color:#EDF4FF; border-radius:8px;" class="form-control">
<option value="">Select Doctor</option>
</select>
</div>



                                        <div class="col-12">
                                            <textarea class="form-control" rows="5" id="message" name="message" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;" placeholder="Additional Message"></textarea 	>
                                        </div>

                                        <div class="col-lg-3 col-md-4 col-6 mx-auto">
                                            <button type="submit" class="button"  name="submit" style="margin-top:50px;">Book Now</button>
											 
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </section>
			 <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/scrollspy.min.js"></script>
        <script src="js/custom.js"></script>


</body>
</html>