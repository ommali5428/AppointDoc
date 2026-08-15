<aside id="menubar" class="menubar light">
  <div class="app-user"  >
    <div class="media">
						 <div class="media-left">
        <div class="avatar avatar-md avatar-circle">
          <img class="img-responsive" src="images/images.png" alt="avatar"/>
        </div><!-- .avatar -->
      </div>
     
      <div class="media-body">
        <div class="foldable">
          <?php
$eid=$_SESSION['admin'];
$sql="SELECT name,email from  user_form where id=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

foreach($results as $row)
{    
$email=$row->email;   
$fname=$row->name;     
}   ?>
          <h5><a href="javascript:void(0)" class="username"><?php  echo $fname ;?></a></h5>
          <ul>
            <li class="dropdown">
              <a href="javascript:void(0)" class="dropdown-toggle usertitle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <small><?php  echo $email;?></small>
                
              </a>
              
            </li>
          </ul>
        </div>
      </div><!-- .media-body -->
    </div><!-- .media -->
  </div><!-- .app-user -->

  <div class="menubar-scroll">
    <div class="menubar-scroll-inner">
      <ul class="app-menu">
	  
		        <li >
          <a href="profile.php">
		 
             <i  class="fa fa-user"></i>
            <span class="menu-text" style="margin-left: 9px;">Profile</span>
            
          </a>
       
        </li>
        <li>
          <a href="dashboard.php">
            <i class=" zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
            <span class="menu-text" style="margin-left: 7px;">Dashboard</span>
            
          </a>
       
        </li>

       <li class="has-submenu">
          <a href="javascript:void(0)" class="submenu-toggle">
            <i class=" zmdi zmdi-pages zmdi-hc-lg"></i>
            <span class="menu-text" style="margin-left: 7px;">Appointment</span>
            <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
          </a>
          <ul class="submenu">
          
            <li><a href="approved-appointment.php"><span class="menu-text">Approved Appointment</span></a></li>
            <li><a href="cancelled-appointment.php"><span class="menu-text">Cancelled Appointment</span></a></li>
            <li><a href="all-appointment.php"><span class="menu-text">All Appointment</span></a></li>
           
          </ul>
        </li>
        
        <li>
          <a href="categories.php">
            <i class=" zmdi zmdi-search zmdi-hc-lg"></i>
            <span class="menu-text" style="margin-left: 7px;">Categories</span>
          </a>
        </li>
        <li>
          <a href="addprofile.php">
            <i class=" zmdi zmdi-layers zmdi-hc-lg"></i>
            <span class="menu-text" style="margin-left: 7px;">New Doctor</span>
          </a>
        </li>
		
		 <li>
          <a href="doctorprofile.php">
            <i class=" zmdi zmdi-layers zmdi-hc-lg"></i>
            <span class="menu-text" style="margin-left: 7px;">Doctor Profile</span>
          </a>
        </li>
		
		<li >
          <a href="change-password.php">
             <i class="fa fa-gear"></i>
            <span class="menu-text" style="margin-left: 9px;">Settings</span>
            
          </a>
		</li>
		
		 <li >
          <a href="/./img/AppointDoc/login/logout.php">
             <i class="fa fa-power-off"></i>
            <span class="menu-text" style="margin-left: 9px;">Logout</span>
            
          </a>
       
        </li>
		
      </ul><!-- .app-menu -->
    </div><!-- .menubar-scroll-inner -->
  </div><!-- .menubar-scroll -->
</aside>