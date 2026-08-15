<!DOCTYPE html>
<html lang="en">



<?php
	
	//		include('C:\xampp\htdocs\img\website\conn.php');

	include('header.php');
	
		if(isset($_POST['submit']))
	{
		$name=$_POST['name'];
		$email=$_POST['email'];
		$feedback=$_POST['feedback'];
		
		
		$query=mysqli_query($conn,"insert into feedback values('','$name','$email','$feedback')");
		if($query)
		{
				echo "<script>alert('Thank you. Your Feedback is submitted.')</script>";
				echo "<script>window.location.href='feedback.php'</script>";
		}
		else
		{
				echo "<script>alert('Somthing Went Wrong.Please try again.!')</script>";
		}
		
}
		
	
	
	

?>
	

<body>

    
  <form method="post">
  <!-- contact section start  -->

    <section id="contact" style="background-color: #fff;" class="contact">

        <h1 class="heading">Feedback</h1>
        <h3 class="title">Share your experience with us,</h3>

        <div class="row">

            <!-- form images  -->
            <div class="images">
                <img src="./drimages/feedback.webp" alt="">
            </div>

            <div class="form-container">    

            <input type="text" placeholder="full name" name="name" required="true" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;">
            <input type="email" placeholder="enter your email" name="email" required="true" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;">

            
            <textarea name="feedback" cols="30" rows="10" placeholder="Feedback" maxlength="130" required="true" style="font-size:15px;background-color:#EDF4FF; border-radius:8px;"></textarea>
			<input type="submit" name="submit" value="Submit">
			            </div>


           				 
						
        </div>
			



    </section>



    <!-- contact section end  -->
	
	</html>