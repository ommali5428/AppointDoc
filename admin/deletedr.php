<?php 
include('C:\xampp\htdocs\img\AppointDoc\conn.php');
session_start();



if(isset($_GET['deleteid']))
{
	$id=$_GET['deleteid'];
		$query="delete from tbldoctor where ID=$id";
		$result = mysqli_query($conn, $query);
		if($result)
		{
			header('location:doctorprofile.php');
			
		}
		else
		{
			die(mysqli_error($conn));
		}
}






?>