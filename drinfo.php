<!DOCTYPE html>


<?php

	include('C:\xampp\htdocs\img\AppointDoc\header.php');
	
	
	//include('C:\xampp\htdocs\img\AppointDoc\conn.php');
			$id=$_GET['id'];
			$query="select * from tbldoctor where ID=$id";
			$result =mysqli_query($conn,$query);
			
			while($row = mysqli_fetch_array($result))
				{
	?>


<html lang="en">


	
 <!-- header navbar section start  -->


    <!-- header navbar section end  -->
	<body>
	<form method="post" action="">
	  <section id="home" class="home">
													<center>	<table  border="2px solid black" style="height:500px; width:950px;">
									
									<th colspan="3" style="color:#003265; background: #cc23; ">
										<?php 
					echo '<font size="5"><strong>'.$row[1].'<font><strong>';
				?>
									</th>
									
									
									
									
									<tr style="height: 100px;">
										<td ><font size="3">Qualification:</font></td>
								     	<!--<td class="text-left td_head" ><font size="3">Qualification:</font></td>-->
										<?php 
					echo '<td><font size="3"><strong>'.nl2br($row[6]).'<font><strong></td>';
					
				?>
				
										<td rowspan="4">				
										<img src="/./img/AppointDoc/appointment/dr_pannel/images/<?php echo $row[10];?>" style="height:300px; margin-left: 50px; margin-right: 15px;"  alt=" "/>
							</td>
									</tr>
									
									<tr>
										<td ><font size="3">Experience:</font></td>
										<?php 
					echo '<td><font size="3"><strong>'.$row[7].'<font><strong></td>';
				?>
									</tr>
									
									<tr style="height: 100px;">
										<td ><font size="3">Hospitaal_Details:</font></td>
										<?php 
					echo '<td><font size="3"><strong>'.nl2br($row[8]).'<font><strong></td>';
				?>
									</tr>
									
									<tr style="height: 100px;">
										<td ><font size="3">Timing:</font></td>
										<?php 
					echo '<td><font size="3"><strong>'.nl2br($row[9]).'<font><strong></td>';
				?>
									</tr>
									
									
									
									
				<?php } ?>	
								
								</table></center>
								</section>
								</body>
								</html>
																