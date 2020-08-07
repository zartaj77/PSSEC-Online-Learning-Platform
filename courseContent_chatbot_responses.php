<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");

if(isset($_GET['courseId'])){
    $courseId = $_GET['courseId'];
    $query= "select * from pssec_courses c inner join pssec_users u on u.id=c.instructor_id where c.id = '$courseId'"; 
    $result = $con->query($query); 
    if ($result->num_rows > 0)
    { 
        //successfull login
        while($row = $result->fetch_assoc()) 
        { 
            $courseTitle = $row['title'];
            $instructorName = $row['name'];
            $instructorId = $row['instructor_id'];
            $abstract = $row['abstract'];
        }
        
        givePoints($con, "Visited Course ".$courseTitle, $session_id, '10');
        
        $query_topics= "select * from pssec_topics t where t.courseId = '$courseId' order by t.timeAdded asc "; 
        $result_topics = $con->query($query_topics); 
        
        $query_assessments= "SELECT t.title, q.topic_id, q.quiz_weight, q.quiz_category from pssec_quizzes q INNER join pssec_topics t on t.id=q.topic_id where t.courseId='$courseId' GROUP by q.topic_id"; 
        $result_assemssments = $con->query($query_assessments); 
        
        
        $query_quiz_scores= "SELECT * from pssec_enrollment e inner join pssec_users u on e.studentId=u.id where e.courseId='$courseId' "; 
        $result_quiz_scores = $con->query($query_quiz_scores); 
        
        $query_total_score= "SELECT sum(a.quiz_weight*a.scorePercent) as gradePoints from (SELECT q.quiz_weight, q.quiz_category ,s.topic_id, u.id, s.isCorrect, t.title, sum(s.isCorrect) / count(u.id) as scorePercent FROM `pssec_quiz_submission` s inner join pssec_users u on s.studentId=u.id inner join pssec_topics t on t.id=s.topic_id inner join pssec_quizzes q on q.topic_id=s.topic_id where u.id='$session_id' and t.courseId='$courseId'  GROUP by s.topic_id) a"; 
        $result_total_score = $con->query($query_total_score); 
        $gradeScore = "NA";
        if ($result_total_score->num_rows > 0)
        { 
            //successfull login
            while($row = $result_total_score->fetch_assoc()) 
            { 
                $gradeScore = $row['gradePoints'];  
                
                $grade = "NA";
                $query_getGrade= "select * from pssec_gradescale where university='$session_university'"; 
                $result_getGrade = $con->query($query_getGrade); 
                if ($result_getGrade->num_rows > 0)
                { 
                    //successfull login
                    while($rowa = $result_getGrade->fetch_assoc()) 
                    { 
                        if(($gradeScore> $rowa['mini'])&& ($gradeScore< $rowa['maxi'])){
                            $grade  = $rowa['grade'];
                        }
                    }
                }
                
                
                
            }
        }
        
        
        
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
        
        
        $showContent = 0;
        $query_checkEnrollment= "select * from pssec_enrollment where courseId = '$courseId' AND studentId='$session_id' "; 
            $result_checkEnrollment = $con->query($query_checkEnrollment); 
            if ($result_checkEnrollment->num_rows > 0)
            { 
                $showContent = 1;
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
        
        $query_notf_recp= "select p.studentId as id from pssec_enrollment p where p.courseId='$courseId'"; 
        $result_notf_recp = $con->query($query_notf_recp); 
        if ($result_notf_recp->num_rows > 0)
        { 
            //successfull login
            while($row = $result_notf_recp->fetch_assoc()) 
            { 
                $temp_student = $row['id'];
                $sql="insert into pssec_notifications(`studentId`, `content`, `timeAdded`, `url`) values ('$temp_student', 'New Topic added to $courseTitle on $topic', '$timeAdded', './courseContent_view.php?topicId=$topicId')";
                if(!mysqli_query($con,$sql)){echo "err2";} 
            }
        }
        

        $sql="insert into pssec_topics (`id`,`courseId` , `title`, `timeAdded`, `instructor_id`) values ('$topicId', '$courseId', '$topic', '$timeAdded', '$author_id')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }else{
            ?>
            <script type="text/javascript">
                window.location = "./courseContent_edit.php?topicId=<?echo $topicId?>";
            </script>
            <?
        }
    }


    
    
    
}
else{
    //do nothing
    1;
}

$query_announcments = "select * from pssec_announcements where courseId='$courseId'"; 
$result_announcments = $con->query($query_announcments); 


$query_resources= "select * from pssec_course_resources where courseId= '$courseId' "; 
$result_resources = $con->query($query_resources); 



if(isset($_GET['del'])){

    $response = $_GET['del'];

    //change picture
    $sql="delete from pssec_bot_responses where id='$response'";
                if(!mysqli_query($con,$sql)){echo "err2";} 
                
}



if(isset($_POST['response'])){

    $response = $_POST['response'];
    $question = $_POST['question'];
    $timeAdded = time();
    
    //change picture
    $sql="insert into pssec_bot_responses(`question`, `answer`, `timeAdded`, `userId`, `courseId`) values ('$question', '$response','$timeAdded', '$session_id', '$courseId')";
                if(!mysqli_query($con,$sql)){echo "err2";} 
                
}


$query_topics= "select * from pssec_bot_responses t where t.userId='$session_id' and courseId='$courseId' order by t.timeAdded desc "; 
        $result_topics = $con->query($query_topics); 
        
        
        
        
        

?>
<!DOCTYPE html>
<html>

<head>
  <?include_once("./phpParts/header.php")?>
</head>

<body>
   
  <!-- Sidenav -->
  <?include_once("./phpParts/sidenav.php");?>

    <?include_once("./phpParts/courseContent_navbar.php");?>

  <!-- Main content -->
  <div class="main-content" id="panel" <?if($filenameLink=="courseContent.php"){?>style="margin-left: 255px;"<?}?>>
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
              <h6 class="h2 text-white d-inline-block mb-0">Chatbot Responses</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item active" aria-current="page">Chatbot Responses</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
            <div class="col-lg-12 text-right">
                  
                
                <div class="row">
                    <div class="col-md-4">
                        <input style="margin:0px 15px;" type="text" name="question" class="form-control" id="exampleFormControlInput1" placeholder="Add new Question" required>
                    </div>
                    <div class="col-md-4">
                        <input style="margin:0px 15px;" type="text" name="response" class="form-control" id="exampleFormControlInput1" placeholder="Add Response" required>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" value="Add new Response" class="btn btn-md btn-neutral" />
                    </div>
                </div>
                </div>
                
                  
            <?}?>
            
          </div>
          <!-- Card stats -->
        </div>
      </div>
    </div>
    </form>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-12 col-md-21 col-lg-12">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Possible Responses</h6>
                  <h5 class="h3 mb-0">Responses</h5>
                </div>
              </div>
            </div>
            <div >
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Question</th>
                    <th scope="col" class="sort" data-sort="name">Response</th>
                    <th scope="col" class="sort" data-sort="name">Action</th>
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
                      <td scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm"><?echo $row['question']?></span>
                        </div>
                      </div>
                    </td>
                    <td scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm"><?echo $row['answer']?></span>
                        </div>
                      </div>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="?del=<?echo $row['id']?>">Delete</a>
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
    
  </div>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
  
</body>

</html>
