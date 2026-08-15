<?php
include('C:\xampp\htdocs\img\AppointDoc\conn.php');


$apid=$_GET['id'];
$query="update tblappointment set Status='Cancelled' where AppointmentNumber=$apid";
			$result =mysqli_query($conn,$query);
			
			echo "<script>window.location.href ='cancel.php'</script>";
			










?>