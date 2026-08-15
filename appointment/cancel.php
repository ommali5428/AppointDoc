<?php

//error_reporting(0);

//include('C:\xampp\htdocs\img\AppointDoc\conn.php');
include('C:\xampp\htdocs\img\AppointDoc\header.php');

?>
<!doctype html>
<html lang="en">
    <head>
        <title>Cancel Appointment </title>
<link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <link href="css_app/bootstrap.min1.css" rel="stylesheet">

        <link href="css_app/bootstrap-icons.css" rel="stylesheet">

        <link href="css_app/owl.carousel.min.css" rel="stylesheet">

        <link href="css_app/owl.theme.default.min.css" rel="stylesheet">

        <link href="css_app/templatemo-medic-care4.css" rel="stylesheet">
		
			
	
	<!-- build:css assets/css/app.min.css -->
	
	
	
		
        <script>
function getdoctors(val) {
     alert(val);
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
    
    <body id="top">
    
        <main>

            
          
       
            

            

            <section class="section-padding" id="booking">
                <div class="container">
                    <div class="row">
                    
                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="booking-form">
                                
                                <h3 class="text-center mb-lg-3 mb-2" style="color:#0188df">Cancel Appointment by Appointment Number</h3>
                            
                                <form role="form" method="post">
                                    <div class="row">
                                        <div class="col-lg-6 col-12" style="margin-top:30px;">
                                            <input id="searchdata" type="number" name="searchdata" required="true" class="form-control"  style="font-size:15px;background-color:#EDF4FF; border-radius:8px;" placeholder="Appointment Number">

                                        </div>
											
                                        <div class="col-lg-3 col-md-4 col-6 mx-auto">
                                            <button type="submit" class="button" style="width:250px; margin-top:50px;" name="search" >Check</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <?php
if(isset($_POST['search']))
{ 

$sdata=$_POST['searchdata'];
  ?>
  <h4 align="center" Style="margin-top: 50px; margin-bottom: 50px;">Result For "<?php echo $sdata;?>"  </h4>
                    
                    <div class="widget-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Appointment Number</th>
                                        <th>Patient Name</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>
										<th>Doctor</th>
                                    <th>Status</th>
                                        <th>Remark</th>
										 <th>
										
										 
										 
										 </th>
                                        
                                    </tr>
                                </thead>
                            
                                <tbody>
                  <?php
             
$sql="SELECT * from tblappointment where AppointmentNumber like '$sdata%' || Name like '$sdata%' || MobileNumber like '$sdata%'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php  echo htmlentities($row->AppointmentNumber);?></td>
                                        <td><?php  echo htmlentities($row->Name);?></td>
                                        <td><?php  echo htmlentities($row->MobileNumber);?></td>
										
                                        <td><?php  echo htmlentities($row->Email);?></td>
										<td>
										
										<?php 
											$drn = $row->Doctor ;
											$query="select FullName from tbldoctor where ID = $drn";
											$result =mysqli_query($conn,$query);
			
			while($row1 = mysqli_fetch_array($result))
				{
					echo $row1['FullName'];
				}
										?>
										
										
										</td>
										
                                        <?php if($row->Status==""){ ?>

                     <td><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Status);?>
                  </td>
                  <?php } ?>             
                 
                                        <?php if($row->Remark==""){ ?>

                     <td><?php echo "Not Updated Yet"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Remark);?>
                  </td>
                  <?php } ?>
						<td>
						
						<a href="cancelapp.php?id=<?php echo htmlentities($row->AppointmentNumber); ?>"><input type="submit" class="button" name="submit" value="Cancel"></a>

						</td>
                                        
                                    </tr>
                                
    
                                </tbody>
             
                <?php 
$cnt=$cnt+1;
} } else { ?>
  <tr>
    <td colspan="8"> No record found against this search</td>

  </tr>
  <?php } }?>
                            </table>
                        </div>

                    </div>
                </div>
            </section>
             
        </main>
        
	
	
    </body>
</html>