<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");

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
            $authorId = $row['instructor_id'];
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


$query_courses= "SELECT u.id, u.name, u.email, u.level, u.university, u.semester, u.studentId, s.topic_id, s.isCorrect, sum(s.isCorrect) / count(u.id) as scorePercent FROM `pssec_quiz_submission` s inner join pssec_users u on s.studentId=u.id where s.topic_id='$topicId' GROUP by u.id "; 
    $result_courses = $con->query($query_courses); 

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
                  
                 
                  <li class="breadcrumb-item"><a href="./">Home</a></li>
                  <li class="breadcrumb-item"><a href="./courseContent_view.php?topicId=<?echo $topicId?>"><?echo $topicTitle?></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quiz Submissions</li>
                  
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
                  <h5 class="h3 mb-0">Quiz Submissions</h5>
                </div>
              </div>
            </div>
            <div>
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Name</th>
                    <th scope="col" class="sort" >Email</th>
                    <th scope="col" class="sort" >Level</th>
                    <th scope="col" class="sort" >University</th>
                    <th scope="col" class="sort" >Semester</th>
                    <th scope="col" class="sort" >StudentID</th>
                    <th scope="col" class="sort" >Action</th>
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
                          <span class="name mb-0 text-sm"><?echo $row['name']?></span>
                        </div>
                      </div>
                    </th>
                    <td>
                        <div class="media align-items-center">
                            <div class="media-body">
                              <span class="name mb-0 text-sm"><?echo $row['email']?>
                              </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="media align-items-center">
                            <div class="media-body">
                              <span class="name mb-0 text-sm"><?echo $row['level']?>
                              </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="media align-items-center">
                            <div class="media-body">
                              <span class="name mb-0 text-sm"><?echo $row['university']?>
                              </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="media align-items-center">
                            <div class="media-body">
                              <span class="name mb-0 text-sm"><?echo $row['semester']?>
                              </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="media align-items-center">
                            <div class="media-body">
                              <span class="name mb-0 text-sm"><?echo $row['studentId']?>
                              </span>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        <?if($row['isCorrect']==''){?>
                        <a class="btn btn-default btn-sm" href="./courseContent_quiz_viewSubmissions_check.php?studentId=<?echo $row['id']?>&topicId=<?echo $row['topic_id']?>">Check</a>
                        <?}else{?>
                        <button class="btn btn-primary btn-sm" disabled><?echo $row['scorePercent']*100?> %</button>
                        <?}?>
                    </td>
                    
                  </tr>
                  <?}
                  }?>
                  </tbody>
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
