<?php 
include('C:\xampp\htdocs\img\AppointDoc\conn.php');
session_start();



if(isset($_GET['deleteid']))
{
	$id=$_GET['deleteid'];
		$query="delete from tblspecialization where ID=$id";
		$result = mysqli_query($conn, $query);
		if($result)
		{
			header('location:categories.php');
			
		}
		else
		{
			die(mysqli_error($conn));
		}
}






?>