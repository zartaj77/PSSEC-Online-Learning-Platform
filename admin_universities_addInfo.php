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
       
        
        givePoints($con, "Updated University Info $title", $session_id, '30');
     
        $uni = $_GET['uni'];
        
        $sql="INSERT into pssec_universities set university='$uni', address='$address', phone='$phone', email='$email', website='$website', fb='$fb'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }else{
            ?>
            <script type="text/javascript">
                window.location = "./admin_unis.php";
            </script>
            <?
        }
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
              <h6 class="h2 text-white d-inline-block mb-0">Update University Info</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item"><a href="./">Universities</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update University Info</li>
                  
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
                  <h5 class="h3 mb-0">Update University Info</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="dept" class="form-control" id="exampleFormControlInput1" placeholder="University name" required readonly value="<?echo $_GET['uni']?>">
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="address" class="form-control" id="exampleFormControlInput1" placeholder="Address" required>
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="phone" class="form-control" id="exampleFormControlInput1" placeholder="Phone" required>
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" required>
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="website" class="form-control" id="exampleFormControlInput1" placeholder="Website" required>
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="fb" class="form-control" id="exampleFormControlInput1" placeholder="Facebook" required>
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
