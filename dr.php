	<!DOCTYPE html>
<html lang="en">

<head>
		<style>
			.backbtn{
				
					margin-left: 30px;
					background: transperant;
					border: solid 0px gray;
					height: 2.5rem;
					
					
				}
			.backspan{
				font-size: 15px;
				margin-left: 12px;
				margin-right: 12px;
				
				color: gray;
				
			}
			.back{
				
					
					
			}
			
		</style>
	</head>

<?php
	include('C:\xampp\htdocs\img\AppointDoc\header.php');
	//include('C:\xampp\htdocs\img\AppointDoc\conn.php');
	
			
	$id=$_GET['id'];
	$query="select * from tblspecialization where ID=$id";
			$result =mysqli_query($conn,$query);
			
			
			while($row = mysqli_fetch_array($result))
				
				{

?>

 
                <form method="post" action="" >
<body>


<section id="blog" class="blog">


				<h1 class="heading"><?php echo $row[1]; }?></h1>
        

	
	<div class="box-container" style="margin-top: 100px;">
        
            <!--                                 DR1 start here        -->
			
            

                <!-- images  -->
			<?php
			
			$query="select * from tbldoctor where Specialization=$id";
			$result =mysqli_query($conn,$query);
			
			
			while($row = mysqli_fetch_array($result))
				
				{

			?>
						<!-- image -->
		<div class="box" style="margin-left: 50px; padding-bottom: 20px;">	
						
				<img src="/./img/AppointDoc/appointment/dr_pannel/images/<?php echo $row[10];?>"  alt=" "/>
			
            <div class="content">
						<!-- name-->
				
                    <h2 style="margin-bottom:10px; margin-top:3px;"><a href="drinfo.php?id=<?php echo $row['ID']; ?>">
						<?php echo $row[1];?>
											</a>	</h2>				
		
                
					<hr/ style="margin-bottom:16px; border-top: 2	px solid #ccc; ">
                     <!-- button  -->
				 
          
					<center> <a href="drinfo.php?id=<?php echo $row['ID']; ?>"  class="button" style=" padding-bottom: 5px; padding-top: 5px; padding-left: 35px; padding-right: 35px; ">
						About
					 </a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					 <a href="appointment/specific_book_appointment.php?id=<?php echo $row['ID']; ?>&spid=<?php echo $row['Specialization'];?>" class="button"   style=" padding-bottom: 5px; padding-top: 5px; padding-left:37px; padding-right: 35px;">
						Book &nbsp;
					 </a></center>
					 
			</div>
		</div>

            
            <!--                            DR1 end here         -->
			

			<?php 
			
				}
				
			?>
 
           
				</div>	
    </section>


	</form>	
</html>

   