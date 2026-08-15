 
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/conn.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Doctor</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="/./img/AppointDoc/css/style.css">
	 <link rel="stylesheet" href="/./img/AppointDoc/css/navbar.css">
	 
	 <link rel="stylesheet" href="/./img/AppointDoc/css/profilelogo2.css">
		
	
	
	<!-- jquery cdn link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- custom js file link  -->
    <script src="/./img/AppointDoc/js/main.js"></script>
	<script src="/./img/AppointDoc/js/java.js"></script>
	 
	 <style>
	 
	 header{
			
			width: 100%;
			top: 0rem;
			
		 
	 }
	 </style>
	 
	 
	 

	
	
		
	</head>
	
 <!-- header navbar section start  -->
<body>
    <header style="box-shadow: .1rem .3rem rgba(0, 0, 0, .3);">

        <!-- logo name  -->
        <a href="#" class="logo"><span>A</span>ppoint <span>D</span>oc.</a>

        <!-- navbar link  -->
        <nav class="navbar">
            <ul>
                <li><a href="/./img/AppointDoc/index.php">home</a></li>
                <li><a href="/./img/AppointDoc/about.php">about Us</a></li>
				
				
				
				
				
				
				
				
				
               
				
				<li>	
					<div class="dropdown">
					  <button onclick="myFunction()" class="dropbtn">Dr. Specialist</button>
					 
					  <div id="myDropdown" class="dropdown-content">
					  
					  <?php
$sql="SELECT * FROM tblspecialization";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 
  ?>
					<a href="/./img/AppointDoc/dr.php?id=<?php echo $row['ID'];?>"><option value="" ><?php echo $row['Specialization'];?></option></a>
<?php }?>
	

		
				
					  </div>
					</div>
				
				</li>
				
				<li><a href="/./img/AppointDoc/appointment/check-appointment.php">Check Appointment</a></li>	
				<li><a href="/./img/AppointDoc/appointment/bookappointment.php">Book Appointment</a></li>
                
                <li><a href="/./img/AppointDoc/feedback.php">Feedback</a></li>
				
				<li><a href="/./img/AppointDoc/appointment/dr_pannel/login.php">Dr pannel</a></li>
				
				
				<li>
				<?php
				
				if(!isset($_SESSION['user_name'])){
					
					
					
				?>
				
						
					<nav style="">
					
					<img src="/./img/AppointDoc/drimages/profile.png"  class="user-pic" onclick="toggleMenu()">
					<div class="sub-menu-wrap" id="subMenu">
						<div class="sub-menu">
							<div class="user-info">		
								
								<h2>Login or Signup </h2>
															</div>
							<hr/>
							
							<a href="/./img/AppointDoc/login/login_form.php" class="sub-menu-link">
								<img src="/./img/AppointDoc/drimages/profile.png" >
								<p style="font-size: 16px;">Pofile</p>
								<span>></span>
							</a>
							
							<a href="/./img/AppointDoc/login/login_form.php" class="sub-menu-link">
								<img src="/./img/AppointDoc/drimages/setting.png" >
								<p style="font-size: 16px;">Settings</p>
								<span>></span>
							</a>
							
							
							<a href="/./img/AppointDoc/login/login_form.php" class="sub-menu-link">
								<img src="/./img/AppointDoc/drimages/login1.png" >
								<p style="font-size: 16px;" >Login</p>
								<span>></span>
							</a>
						</div>
					</div>

					</nav>
					
				
				<?php
				}
				else
				{
						if(isset($_SESSION['uid']))
	{		
$did=$_SESSION['uid'];
$query="select * from user_form where id=$did";
$result=mysqli_query($conn,$query);
			
			
			while($row = mysqli_fetch_array($result))
				
				{
				?>
				
						
					<nav style="">
					
					<img src="/./img/AppointDoc/drimages/profile.png"  class="user-pic" onclick="toggleMenu()">
					<div class="sub-menu-wrap" id="subMenu">
						<div class="sub-menu">
							<div class="user-info">		
								
								<h2 style="font-size: 15px;"><?php echo $row[1]; 
				}
	}
								?></h2>
							
							</div>
							<hr/>
							
							<a href="/./img/AppointDoc/user.php" class="sub-menu-link">
								<img src="/./img/AppointDoc/drimages/profile.png" >
								<p style="font-size: 16px;">Pofile</p>
								<span>></span>
							</a>
							
							<a href="/./img/AppointDoc/setting.php" class="sub-menu-link">
								<img src="/./img/AppointDoc/drimages/setting.png" >
								<p style="font-size: 16px;">Settings</p>
								<span>></span>
							</a>
							
							
							<a href="/./img/AppointDoc/login/logout.php" class="sub-menu-link">
								<img src="/./img/AppointDoc/drimages/logout.png" >
								<p style="font-size: 16px;" >Logout</p>
								<span>></span>
							</a>
						</div>
					</div>

					</nav>

									
						   
							
					<?php
									}?>	   
					
					</li>				

				</ul>
			</nav>

        <div class="fas fa-bars"></div>
    </header>
    <!-- header navbar section end  -->
	
	<script src="/./img/AppointDoc/js/profile.js"></script>
	
</body>
</html>