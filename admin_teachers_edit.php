<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");

if(!isset($_GET['userId'])){
            ?>
            <script type="text/javascript">
                window.location = "./";
            </script>
            <?
        }
        
if(isset($_POST['name'])){
    
    //change picture
    if(true){
        $name = mb_htmlentities(($_POST['name']));
        $userId = mb_htmlentities(($_GET['userId']));
       
        $sql="update pssec_users set name='$name' where id='$userId'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }else{
            ?>
            <script type="text/javascript">
                window.location = "./admin_teachers.php";
            </script>
            <?
        }
    }
    
    
    
}
else{
    //do nothing
    1;
}

$userId = $_GET['userId'];
$query_departments= "SELECT * FROM `pssec_users` where id='$userId'"; 
$result_departments = $con->query($query_departments); 
if ($result_departments->num_rows > 0)
{ 
    //successfull login
    while($row = $result_departments->fetch_assoc()) 
    { 
        $name = $row['name'];
        
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
              <h6 class="h2 text-white d-inline-block mb-0">Update Information</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item"><a href="./">Users</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update Information</li>
                  
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
                  <h5 class="h3 mb-0">Update Information</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Name" value="<?echo $name?>" required>
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
