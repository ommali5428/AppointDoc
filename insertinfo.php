<?php

	include('C:\xampp\htdocs\img\website\conn.php');
	
?>
<html>
<body>

	<form method="post" action="" enctype="multipart/form-data">
	
	<table border="1px solid black" align="center">
		
		
		
		<tr>
			<td>Name</td>
			<td><input type="text" name="name"></td>
		</tr>

		
		
		<tr>
			<td>Qualification</td>
			<td><input type="text" name="qf"></td>
		</tr>
		
		<tr>
			<td>Experience</td>
			<td><input type="text" name="ex">
				
			</td>
		</tr>
		
		<tr>
			<td>Hospital_detail</td>
			<td><input type="text" name="hd">
				
			</td>
		</tr>
		
		<tr>
			<td>Timing</td>
			<td><input type="text" name="time">
				
			</td>
		</tr>
		
		<tr>
			<td><label class="">Image</label></td>
			<td><input type="file" name="images" id="images" value=""></td>
		</tr>
		
		
		
		<tr>
			<td colspan="2" align="center">
				<input type="submit" name="insert" value="Insert">
				
			</td>
		</tr>
		
		</table>
	</form>
	
	<?php
		
		if(isset($_POST['insert']))
		{
			
			$name = $_POST["name"];
			$qf= $_POST["qf"];
			$ex= $_POST["ex"];
			$hd= $_POST["hd"];
			$time= $_POST["time"];
			//featured Image
			$pic = $_FILES["images"]["name"];
			$extension = substr($pic,strlen($pic)-4,strlen($pic));
			
			//allowed extension_loaded
			$allowed_extension = array(".jpg","jpeg",".png",".gif");
			
			//validation for allowed extension .in_array() search an array for specific value
			if(!in_array($extension,$allowed_extension))
			{
				echo "<script>alert('featured image has invalid format. Only jpg/jpeg/png/gif format allowed');
						</script>";
			}
			
			else
			{
				$pic = md5($pic).time().$extension;
				move_uploaded_file($_FILES["images"]["tmp_name"],"childimg/".$pic);
				$query=mysqli_query($conn,"insert into  values('','$name','$qf','$ex','$hd','$time','$pic')");
				if($query)
				{
					echo "<script>alert('Photo details has been submitted.');</script>";
					echo "<script>window.location.href='insertinfo.php'</script>";
				}
				else
				{
					echo "<script>alert('Somthing went wrong.Please try again');</script>";
				}
			}
		}
		
	?>
	
	
		
					
	
		
	

	
	
</body>	
</html>
