
<?php

	include('header.php');
	
?>
<!DOCTYPE html>


<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Add font awesome icons -->

<style>
.footer{
  background: var(--black);
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  padding: 2rem 0;
 }

 .footer .box{
  width: 25rem;
  margin: 2rem;
  text-align: center;
 }

 .footer .box:nth-child(1){
  text-align: left;
 }



.footer .box .logo{
  padding: 2rem 0;
  font-size: 3rem;
  color: var(--wight);
}


.footer .box .logo span{
  color: var(--blue);
}

.footer .box p{
  font-size: 1.5rem;
  color: var(--wight);
}

.footer .box a{
  color: var(--wight);
  font-size: 2rem;
  display: block;
  padding: .2rem 0;
}

.footer .box a:hover{
  text-decoration: underline;
}


.footer .credit{
  width: 85%;
  padding-top: 1rem;
  font-size: 2rem;
  color: var(--wight);
  text-align: center;
  border-top: .2rem solid var(--wight);
}

.footer .credit span{
  color: var(--blue);
  text-decoration: underline;
  letter-spacing: .5rem;
}

</style>
</head>
	

<body>
   
	
		
		
	

   
    <!-- home section start  -->

    <section id="home" class="home"  >
	
		
	
	
        <div class="row">

            <!-- home images  -->
            <div class="images">
                <img src="./drimages/home2.jpg" alt="">
            </div>

            <!-- home heading  -->
            <div class="content">
			<p>
				<?php if(isset($_SESSION['user_name'])){
   
?>
				welcome &nbsp;&nbsp;<?php echo $_SESSION['user_name'] ?>
				
				
				<?php }
				else
				{
					
				}
				?>
				</p>
			
			
			
                <h1><span>Stay</span> Safe, <span>Stay</span> Healthy.</h1>
                <p>Balance Is The Key To Everything.What we Do, Think, Say, Eat, Feel, They All Require Awareness, And Through This Awareness, We Can Grow.</p>
                
            </div>
        </div>
    </section>
    <!-- home section end  -->
	
	<!-- Categories of Doctor section start -->
	
	<h1 class="heading1" style="color:#0188df">Speacialist</h1>
	<section id="doctor" class="card" >
	
		


	<div class="box-container">
	<?php
	  $query="select * from tblspecialization";
			$result =mysqli_query($conn,$query);
			
			
			while($row = mysqli_fetch_array($result))
				
				{?>
			<!-- start here  -->
                <div class="box"> <a href="dr.php?id=<?php echo $row['ID'];?>">
                    <img src="./drimages/<?php echo $row[2]; ?>" alt=""></a>              
                    
                    <div class="content">
                         <a href="dr.php?id=<?php echo $row['ID'];?>">
									<h2><?php echo $row[1];?></h2>
                        </a>
                        

                        
                    </div>
                </div>
				<?php  } ?>
				
				
		
			</div>
			
				
	</section>
	<!-- Categories of Doctor section end -->
	
	
	
	
	 <!-- Emergency appointment start  -->
		<section id="review" class="review">

        <h1 class="heading">Emergency appointment Book</h1>
       

       <div class="box-container" >

            
            <div class="box">

                <div class="images">
                    <img src="./drimages/emergency.jpeg" alt="">

                    <div class="info">
                       <a href="#"><h3>Emergency appointment</h3></a>
					   
                    </div>
				
                </div>
				<p style="color: green;">*Under Construct*</p>	
            </div>
			
			</div>
			
			</section>
    
    
  
	<!-- Emergency appointment End  -->
	
    <!-- review section start  -->

    <section id="review" class="review">

        <h1 class="heading">our patient review</h1>
        <h3 class="title">what patient says about us</h3>

        <div class="box-container">

            <!-- start here  -->
			<?php $query="select * from feedback order by id desc limit 3";
					$result=mysqli_query($conn,$query);
			
			while($row = mysqli_fetch_array($result))
				
				{
					
					
			?>
			
			
			
			
            <div class="box">
                <i class="fas fa-quote-left"></i>
                <p><?php echo $row[3];?></p>

                
                   
                    <div class="info" >
					<hr/>
					<h3 >
						
						<?php echo $row[1];?></h3>
                        
                    </div>
                
            </div>
				<?php 
				} 
				?>
            <!-- end here  -->

            
            

            
           
        </div>
    </section>
    <!-- review section end  -->
 
    

  

    <!-- footer section start  -->

     <section class="footer" style=" background-image: url('/./img/AppointDoc/drimages/25757.jpg');  background-size: 100%; " >

		

        <div class="box">
            <h2 class="logo">Speacialist</h2>
 <?php
$sql="SELECT * FROM tblspecialization";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 
  ?>
					<a href="/./img/AppointDoc/dr.php?id=<?php echo $row['ID'];?>"><option value="" ><?php echo $row['Specialization'];?></option></a>
<?php }?>
            
			
        </div>

        <div class="box">
            <h2 class="logo">Links</h2>

            <a href="/./img/AppointDoc/index.php">Home</a>
            <a href="/./img/AppointDoc/about.php">About</a>
            <a href="/./img/AppointDoc/appointment/bookappointment.php">Book Appointment</a>
            <a href="/./img/AppointDoc/appointment/check-appointment.php">Check Appointment</a>
            <a href="/./img/AppointDoc/appointment/cancel.php">Cancel Appointment</a>
            <a href="/./img/AppointDoc/feedback.php">Feedback</a>
        </div>

        



        
		
		
			
		
		<h1 class="credit" >created by <span>OM And MAYUR</span> all right reserved.
		</h1>
    </section>


    <!-- footer section end  -->
    


    
	
	
</body>

</html>
