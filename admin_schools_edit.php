<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");

if(!isset($_GET['uni'])){
            ?>
            <script type="text/javascript">
                window.location = "./";
            </script>
            <?
        }
        
if(isset($_POST['address'])){
    
    //change picture
    if(true){
        $address = mb_htmlentities(($_POST['address']));
        $phone = mb_htmlentities(($_POST['phone']));
        $email = mb_htmlentities(($_POST['email']));
        $website = mb_htmlentities(($_POST['website']));
        $fb = mb_htmlentities(($_POST['fb']));
       
        
        givePoints($con, "Updated School/College Info $title", $session_id, '30');
     
        $uni = $_GET['uni'];
        
        $sql="Delete from pssec_universities where university='$uni'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
        
        
        $sql="INSERT into pssec_universities set university='$uni', address='$address', phone='$phone', email='$email', website='$website', fb='$fb', portion='School/College'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }else{
            ?>
            <script type="text/javascript">
                window.location = "./admin_schools.php";
            </script>
            <?
        }
    }
    
    
    
}
else{
    //do nothing
    1;
}

$uni = $_GET['uni'];
$query_departments= "SELECT * FROM `pssec_universities` where university='$uni'"; 
$result_departments = $con->query($query_departments); 
if ($result_departments->num_rows > 0)
{ 
    //successfull login
    while($row = $result_departments->fetch_assoc()) 
    { 
        $address = $row['address'];
        $phone = $row['phone'];
        $email = $row['email'];
        $website = $row['website'];
        $fb = $row['fb'];
    }
}else{
    ?>
    <script type="text/javascript">
        window.location = "./";
    </script>
    <?
}

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
              <h6 class="h2 text-white d-inline-block mb-0">Update School/College Info</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item"><a href="./">Colleges/Schools</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update School/College Info</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Save" class="btn btn-md btn-neutral" />
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
                  <h5 class="h3 mb-0">Update School/College Info</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="dept" class="form-control" id="exampleFormControlInput1" placeholder="School/College name" required readonly value="<?echo $_GET['uni']?>">
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="Address" value="<?echo $address?>" required>
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="phone" class="form-control" id="exampleFormControlInput1" placeholder="Phone" value="<?echo $phone?>" required>
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" value="<?echo $email?>" required>
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="website" class="form-control" id="exampleFormControlInput1" placeholder="Website" value="<?echo $website?>" required>
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="fb" class="form-control" id="exampleFormControlInput1" placeholder="Facebook" value="<?echo $fb?>" required>
                  </div>
                    </div>
                    
                    
                    
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
