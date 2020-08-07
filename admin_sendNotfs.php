<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdmin.php");

if(isset($_POST['notf'])){

    
    //change picture
    if(true){
        $notf = mb_htmlentities(($_POST['notf']));
       
        $query_notf_recp= "select * from pssec_users"; 
        $result_notf_recp = $con->query($query_notf_recp); 
        if ($result_notf_recp->num_rows > 0)
        { 
            //successfull login
            while($row = $result_notf_recp->fetch_assoc()) 
            { 
                $temp_student = $row['id'];
                $sql="insert into pssec_notifications(`studentId`, `content`, `timeAdded`, `url`) values ('$temp_student', '$notf', '$timeAdded', '#')";
                if(!mysqli_query($con,$sql)){echo "err2";} 
            }
        }
        
        givePoints($con, "Send Notification $notf", $session_id, '30');
     
        
        
        ?>
            <script type="text/javascript">
                window.location = "./";
            </script>
            <?
        
        
        
        
    }
}
else{
    //do nothing
    1;
}


$query_departments= "SELECT * FROM `pssec_departments`"; 
$result_departments = $con->query($query_departments); 


?>
<!DOCTYPE html>
<html>

<head>
  <?include_once("./phpParts/header.php")?>
</head>

<body>
   
  <!-- Sidenav -->
  <?include_once("./phpParts/sidenav.php")?>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <?include_once("./phpParts/topnav.php")?>
    <!-- Header -->
    <!-- Header -->
    <form method="post" action="" enctype="multipart/form-data">
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Send Notification</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item active" aria-current="page">Send Notification</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Send" class="btn btn-md btn-neutral" />
                </div>
            <?}?>
            
          </div>
          <!-- Card stats -->
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-12 col-md-21 col-lg-12">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Send Notification</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                

                  <div class="form-group">
                    <label for="exampleFormControlInput1">Notification Text</label>
                    <input type="text" name="notf" class="form-control" id="exampleFormControlInput1" placeholder="Notification Text" required>
                  </div>
           
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?include_once("./phpParts/footer.php")?>
    </div>
    </form>
  </div>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
  
</body>

</html>
