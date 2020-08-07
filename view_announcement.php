<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminStudentTeacher.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
   $query_departments= "SELECT * FROM `pssec_announcements` where id='$id'"; 
    $result_departments = $con->query($query_departments); 
    if ($result_departments->num_rows > 0)
    { 
        //successfull login
        while($row = $result_departments->fetch_assoc()) 
        { 
            $title = $row['title'];
            $content = $row['content'];
        }
    }
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
              <h6 class="h2 text-white d-inline-block mb-0">Announcement</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item active" aria-current="page">Announcement</li>
                  
                </ol>
              </nav>
            </div>
           
            
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
                  <h5 class="h3 mb-0"><?echo $title?></h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                

                  <div class="form-group">
                    <p>
                        <?echo $content?>
                    </p>
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
