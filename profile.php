<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");



if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query_courses= "select * from pssec_users c where c.id='$id' "; 
    $result_courses = $con->query($query_courses); 
    if ($result_courses->num_rows > 0)
    { 
        while($row = $result_courses->fetch_assoc()) 
        { 
            $name = $row['name'];
            $email = $row['email'];
            $level = $row['level'];
            $university = $row['university'];
        }
    }
    
    //get courses
    $query_courses= "select * from pssec_courses c where c.instructor_id='$id' "; 
    $result_courses = $con->query($query_courses); 
    
    
    
    
    
}


givePoints($con, "Viewed instructor profile".$id, $session_id, '10');





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
    <div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url(https://demos.creative-tim.com/argon-dashboard/assets/img/theme/img-1-1000x600.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-12 col-md-10">
            <h1 class="display-2 text-white"><?echo $name?></h1>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-4 order-xl-2">
          <div class="card card-profile">
            <img src="https://demos.creative-tim.com/argon-dashboard/assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                      <!--
                    <img src="https://demos.creative-tim.com/argon-dashboard/assets/img/theme/img-1-1000x600.jpg" class="rounded-circle">
                    -->
                  </a>
                </div>
              </div>
            </div>
           
            <div class="card-body pt-0">
                <br>
              <div class="text-center">
                <h5 class="h3">
                  <?echo $name?>
                </h5>
                <div class="h5 font-weight-300">
                  <i class="ni location_pin mr-2"></i><?echo $email?>
                </div>
                
                <div>
                  <i class="ni education_hat mr-2"></i><?echo $university?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Courses Offered</h6>
                  <h5 class="h3 mb-0">Courses Offered</h5>
                </div>
              </div>
            </div>
            <div >
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Course</th>
                    <th scope="col" class="sort" style="width:<?if($session_role=="student"){echo "10";}else{echo "20";}?>%;">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                    <?
                    if ($result_courses->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_courses->fetch_assoc()) 
                        { 
                    ?>
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm"><?echo $row['title']?></span>
                        </div>
                      </div>
                    </th>
                    <td>
                        <a class="btn btn-primary" href="./courseContent.php?courseId=<?echo $row['id']?>">View</a>
                        <?if($session_role!="student"){?>
                            <?if($row['isHidden']==1){?>
                            <a class="btn btn-success" href="./admin_courses.php?show=<?echo $row['id']?>">Show</a>
                            <?}else{?>
                            <a class="btn btn-warning" href="./admin_courses.php?hide=<?echo $row['id']?>">Hide</a>
                            <?}?>
                    <?}?>
                        
                    </td>
                  </tr>
                  <?}
                  }?>
                  
              </table>
            </div>
               
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?include_once("./phpParts/footer.php")?>
    </div>
  </div>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
  
</body>

</html>
