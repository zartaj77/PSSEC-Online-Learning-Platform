<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");

if(isset($_POST['university'])){

    
    //change picture
    if(true){
        $university = mb_htmlentities(strtoupper($_POST['university']));
        
        givePoints($con, "New University $title", $session_id, '30');

        $s = generateRandomString(10);
        $sql="insert into pssec_users (`name`,`email`, `password`, `role`, `university`, `portion`) values ('','$s', '$s', 'none', '$university', 'School/College')";
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
              <h6 class="h2 text-white d-inline-block mb-0">New School</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item active" aria-current="page">New School/College</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Add School/College" class="btn btn-md btn-neutral" />
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
                  <h5 class="h3 mb-0">New School/College</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                

                  <div class="form-group">
                    <label for="exampleFormControlInput1">School/College name</label>
                    <input type="text" name="university" class="form-control" id="exampleFormControlInput1" placeholder="School/College name" required>
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
