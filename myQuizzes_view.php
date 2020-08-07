<?
include_once("./global.php");
include_once("./phpParts/auth/allowStudent.php");



$filename = "none";
if(isset($_GET['topicId'])){
    $studentId = $session_id;
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


$query_quizQuestions= "SELECT s.id, isCorrect, question,type, answer FROM `pssec_quiz_submission` s INNER join pssec_quizzes q on s.questionId=q.id where s.topic_id='$topicId' and s.studentId='$session_id' "; 
$result_quizQuestions = $con->query($query_quizQuestions); 

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
              <h6 class="h2 text-white d-inline-block mb-0">Check Quiz</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item"><a href="./courseContent_view.php?topicId=<?echo $topicId?>"><?echo $topicTitle?></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Check Quiz</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || ($session_role=="teacher" && $authorId==$session_id)){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" name="submit" value="Mark as Checked" class="btn btn-md btn-success" />
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
                  <h5 class="h3 mb-0">Quiz Responses</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
               
                <?if ($result_quizQuestions->num_rows > 0)
                { 
                    //successfull login
                    while($row = $result_quizQuestions->fetch_assoc()) 
                    { ?>
                  <div class="row" style="margin-bottom:5px;">
                          <div class="col-md-10">
                              <label for="exampleFormControlInput1"><b>Question: <?echo $row['question']?></b></label>
                             <br>
                            <?if($row['type']=="Multiple Choice Multi"){
                             
                             $msans = json_decode($row['answer'], true)['ans'];
                             
                             $selectedOptions = "";
                             for($i=0;$i<count($msans);$i++)
                            {
                                $selectedOptions = $selectedOptions.$msans[$i].", ";
                            }
                             ?>
                            <label for="exampleFormControlInput1">Ans: <?echo $selectedOptions?></label>
                            <?}if($row['type']=="Upload Submissions"){?>
                            <img src="./uploads/<?echo $row['answer']?>" width="700"/>
                            <?}else{?>
                            <label for="exampleFormControlInput1">Ans: <?echo $row['answer']?></label>
                            <?}?>
                          </div>
                          <div class="col-md-2">
                              <?if($row['isCorrect']=='1'){?>
                              <a class="btn btn-success btn-sm" style="color:white;">Correct</a>
                              <?}else{?>
                              <a class="btn btn-danger btn-sm" style="color:white;">Wrong</a>
                              <?}?>
                          </div>
                      </div>
                      <?}
                      }?>
                      
                      
                      
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
