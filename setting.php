<?php

include('C:\xampp\htdocs\img\AppointDoc\header.php');


error_reporting(0);


if (strlen($_SESSION['uid']==0)) {
  header('location:logout.php');
  
  } 
  else{
if(isset($_POST['submit']))
{
$eid=$_SESSION['uid'];
$cpassword=md5($_POST['currentpassword']);
$newpassword=md5($_POST['newpassword']);
$sql ="SELECT id FROM user_form WHERE id=:eid and password=:cpassword";
$query= $dbh -> prepare($sql);
$query-> bindParam(':eid', $eid, PDO::PARAM_STR);
$query-> bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);

if($query -> rowCount() > 0)
{
$conn="update user_form set password=:newpassword where id=:eid";
$chngpwd1 = $dbh->prepare($conn);
$chngpwd1-> bindParam(':eid', $eid, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();

echo '<script>alert("Your password successully changed")</script>';
} else {
echo '<script>alert("Your current password is wrong")</script>';

}
}



  

  
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <title>Change Password</title>
  
  <link rel="stylesheet" href="/./img/AppointDoc/css/user.css"> 
    <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
  <!-- endbuild -->
  <script>
    Breakpoints();
  </script>
  <script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
}   

</script>
</head>
  
<body style="background-color: white;">
<!--============= start main area -->
<form class="form-horizontal" onsubmit="return checkpass();" name="changepassword" method="post" style="margin-left: 15%;">


<!-- APP MAIN ==========-->
<main >
  <div class="wrap" >
  <section class="app-content" >
    <div class="row"  style="margin-top: 120px; ">
     
     
        
          <h1 align="center" style="padding-bottom: 10px; margin-right: 300px ">Change Password</h1>
			   <hr/>
          
          

              <div class="form-group">
                <label for="exampleTextInput1" class="col-sm-3 control-label">Current Password:</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="currentpassword" id="currentpassword"required='true' style="width: 50%;">
                </div>
              </div>
              <div class="form-group">
                <label for="email2" class="col-sm-3 control-label">New Password:</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="newpassword"  class="form-control" required="true" style="width: 50%;">
                </div>
              </div>
              <div class="form-group">
                <label for="email2" class="col-sm-3 control-label">Confirm Password:</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control"  name="confirmpassword" id="confirmpassword"  required='true' style="width: 50%;" >
                </div>
              </div>
               
            
              <div class="row">
                <div class="col-sm-9 col-sm-offset-3">
                  <input type="submit" class="button" value="Change" name="submit">
                </div>
              </div>
            
         
       
     

    </div><!-- .row -->
  </section><!-- #dash-content -->
</div><!-- .wrap -->
  
</main>
<!--========== END app main -->

 

  <!-- build:js assets/js/core.min.js -->
  <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/jquery/dist/jquery.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel//./img/AppointDoc/appointment/dr_pannel/libs/bower/jquery-ui/jquery-ui.min.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/PACE/pace.min.js"></script>
  <!-- endbuild -->

  <!-- build:js assets/js/app.min.js -->
  <script src="/./img/AppointDoc/appointment/dr_pannel/assets/js/library.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/assets/js/plugins.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/assets/js/app.js"></script>
  <!-- endbuild -->
  <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/moment/moment.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
  <script src="/./img/AppointDoc/appointment/dr_pannel/assets/js/fullcalendar.js"></script>
  
   </form>
</body>
</html>
  <?php  } ?>