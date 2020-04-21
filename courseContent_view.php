<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");

$filename = "none";
if(isset($_GET['topicId'])){
    $topicId = $_GET['topicId'];
    $query= "select * from pssec_topics where id = '$topicId' "; 
    $result = $con->query($query); 
    if ($result->num_rows > 0)
    { 
        //successfull login
        while($row = $result->fetch_assoc()) 
        { 
            $topicTitle = $row['title'];
            $content = $row['content'];
            $courseId = $row['courseId'];
            $lectureVideo = $row['lectureVideo'];
        }
    }
    else{
        ?>
        <script type="text/javascript">
            window.location = "./?error-occured=1";
        </script>
        <?
    }
}
else{
    ?>
    <script type="text/javascript">
        window.location = "./?error-occured=1";
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
              <h6 class="h2 text-white d-inline-block mb-0"><?echo $topicTitle?></h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item active"><a href="./"><i class="fas fa-home"></i></a></li>
                 
                  <li class="breadcrumb-item"><a href="./">Courses</a></li>
                  <li class="breadcrumb-item"><a href="./courseContent.php?courseId=<?echo $courseId?>">Topics</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?echo $topicTitle?></li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                    <a href="./courseContent_edit.php?topicId=<?echo $topicId?>" class="btn btn-md btn-neutral" >Edit</a>
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
                  <h5 class="h3 mb-0">Lecture</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
               
               <?echo nl2br(htmlspecialchars($content))?>
               <br>
               <?if($lectureVideo!=""){?>
                   <video controls style="display:grid;;width:75%;justify-content:center;margin: 70px auto;border-radius:10px;">
                      <source src="./uploads/<?echo $lectureVideo?>" type="video/mp4">
                      Your browser does not support HTML5 video.
                    </video>
                <?}?>
           
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
