<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");


if(isset($_GET['hide'])){
    $id = $_GET['hide'];
    $sql="update pssec_courses set isHidden=1 where id='$id'";
                if(!mysqli_query($con,$sql)){echo "err2";} 
}

if(isset($_GET['show'])){
    $id = $_GET['show'];
    $sql="update pssec_courses set isHidden=0 where id='$id'";
                if(!mysqli_query($con,$sql)){echo "err2";} 
}



if($session_role == "student"){
    $query_courses= "select c.title, c.id from pssec_courses c inner join pssec_enrollment e on c.id=e.courseId where e.studentId='$session_id' "; 
    $result_courses = $con->query($query_courses); 
}
if($session_role == "admin" || $session_role == "teacher"){
    $query_courses= "select * from pssec_courses c where c.instructor_id='$session_id' "; 
    $result_courses = $con->query($query_courses); 
}

givePoints($con, "My Courses", $session_id, '10');





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
              <h6 class="h2 text-white d-inline-block mb-0"><?echo $courseTitle?></h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item active" aria-current="page">My Courses</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <a href="./newCourse.php" class="btn btn-md btn-neutral">Add New Course</a>
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
                  <h6 class="text-uppercase text-muted ls-1 mb-1">My Courses</h6>
                  <h5 class="h3 mb-0">My Courses</h5>
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
    </form>
  </div>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
  
</body>

</html>
