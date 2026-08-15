<?php

include('C:\xampp\htdocs\img\AppointDoc\conn.php');

session_start();

if(isset($_POST['submit'])){

   //$name = mysqli_real_escape_string($conn,$_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   //$cpass = md5($_POST['cpassword']);
   //$user_type = $_POST['user_type'];

   $query = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $results = mysqli_query($conn, $query);

   if(mysqli_num_rows($results) > 0){

      $row = mysqli_fetch_array($results);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:/./img/AppointDoc/admin/dashboard.php');
		  $_SESSION['admin']= $row['id'];
		   $_SESSION['aem']= $row['email'];
		 

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         header('location:/./img/AppointDoc/index.php');
		$_SESSION['uid']= $row['id'];
	  $_SESSION['em']= $row['email'];
      }
	  
     
   }else{
      $error[] = 'incorrect email or password!';
   }
     $app=" SELECT * FROM  tblappointment WHERE  Email = '$email' group by ID DESC";
	  $res=mysqli_query($conn, $app);
	if(mysqli_num_rows($res) > 0){
		$row2 = mysqli_fetch_array($res);
		$_SESSION['appid']= $row2['ID'];
	}
	  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body class="form-container" style="background-image: url('/./img/AppointDoc/drimages/top-view-internet-communication-network.jpg');  background-size: 100%;">
   
<div >


		

   <form action="" method="post" style="background: #BCC6CC; ">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
	  <input type="submit" name="submit" value="login now" target="" class="form-btn">
	  
	  
       
      <p>don't have an account? <a href="register_form.php">register now</a></p>
   </form>
	<center><a href="/./img/AppointDoc/index.php" ><p style="margin-top:8px; color:black; border: solid 1px #BCC6CC; ">Back To Home</p></a></center>
</div>

</body>
</html>