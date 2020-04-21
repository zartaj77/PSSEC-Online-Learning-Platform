<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");

if(isset($_GET['courseId'])){
    $courseId = $_GET['courseId'];
    $query= "select * from pssec_courses c inner join pssec_users u on u.id=c.instructor_id where c.id = '$courseId' "; 
    $result = $con->query($query); 
    if ($result->num_rows > 0)
    { 
        //successfull login
        while($row = $result->fetch_assoc()) 
        { 
            $courseTitle = $row['title'];
            $instructorName = $row['name'];
            $abstract = $row['abstract'];
        }
        
        $query_topics= "select * from pssec_topics t where t.courseId = '$courseId' "; 
        $result_topics = $con->query($query_topics); 
        
        if(isset($_GET['enroll'])){
            $query_checkEnrollment= "select * from pssec_enrollment where courseId = '$courseId' AND studentId='$session_id' "; 
            $result_checkEnrollment = $con->query($query_checkEnrollment); 
            if ($result_checkEnrollment->num_rows == 0)
            { 
                $timeAdded = time();
                $sql="insert into pssec_enrollment (`courseId`, `studentId`, `timeAdded` ) values ('$courseId', '$session_id', '$timeAdded')";
                if(!mysqli_query($con,$sql))
                {
                    echo "err";
                }else{
                    $enrolledSuccess = "yes";
                }
            }
        
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



if(isset($_POST['topic'])){
    
    //image handeling
    $topicId = generateRandomString(10);

    //change picture
    if(true){
        $topic = mb_htmlentities(($_POST['topic']));
        $author_id = mb_htmlentities($session_id);
        $timeAdded = time();

        $sql="insert into pssec_topics (`id`,`courseId` , `title`, `timeAdded`, `instructor_id`) values ('$topicId', '$courseId', '$topic', '$timeAdded', '$author_id')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }else{
            ?>
            <script type="text/javascript">
                window.location = "./addCourseContent.php?courseId=<?echo $courseId?>";
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
              <h6 class="h2 text-white d-inline-block mb-0"><?echo $courseTitle?></h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item active"><a href="./"><i class="fas fa-home"></i></a></li>
                 
                  <li class="breadcrumb-item"><a href="./">Courses</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?echo $courseTitle?></li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Add new Topic" class="btn btn-md btn-neutral" />
                </div>
                <input style="margin:0px 15px;" type="text" name="topic" class="form-control" id="exampleFormControlInput1" placeholder="Add new Topic" required>
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
            
            <?if($enrolledSuccess=="yes"){?>
                <div class="alert alert-success" role="alert">
                    <strong>You have been successfully enrolled in the course!</strong> We'll now keep you updated on the course content.
                </div>
            <?}?>


          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Course Outline</h6>
                  <h5 class="h3 mb-0">Topics</h5>
                </div>
              </div>
            </div>
            <div >
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Topics</th>
                    <th scope="col" class="sort" style="width:20%;">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                    <?
                    if ($result_topics->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_topics->fetch_assoc()) 
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
                        <a class="btn btn-primary" href="./courseContent_view.php?topicId=<?echo $row['id']?>">View</a>
                        <?if($session_role=="admin" || $session_role=="teacher"){?>
                            <a class="btn btn-warning" href="./courseContent_edit.php?topicId=<?echo $row['id']?>">Edit</a>
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
