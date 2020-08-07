<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");


$filename = "none";
if(isset($_GET['topicId'])){
    $topicId = $_GET['topicId'];
    
    //get weightage
    $query= "select sum(quiz_weight) as 'currweight' from (SELECT (q.quiz_weight) FROM `pssec_quizzes` q INNER join pssec_topics t on q.topic_id=t.id  where t.courseId=(select tp.courseId from pssec_topics tp where tp.id='$topicId') GROUP by q.topic_id) a"; 
    $result = $con->query($query); 
    if ($result->num_rows > 0)
    { 
        //successfull login
        while($row = $result->fetch_assoc()) 
        { 
            $currweight = $row['currweight'];
        }
    }
    
    
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


if($session_role=='admin' || $authorId==$session_id){
    1;
}else{
    ?>
    <script type="text/javascript">
        window.location = "./?error-occured=1";
    </script>
    <?
}

if(isset($_POST['weight'])){
    $weight = $_POST['weight'];
    $_SESSION['weight'] = $weight;
    
    $quiz_category = $_POST['quiz_category'];
    $_SESSION['quiz_category'] = $quiz_category;
    
    $deadline = $_POST['deadline'];
    $_SESSION['deadline'] = $deadline;
    
    
}


if(isset($_POST['question'])){
    
     $question = mb_htmlentities(($_POST['question']));
     $type = mb_htmlentities(($_POST['type']));
     $timeAdded = time();
     
     $html = "";
     if($type=="Multiple Choice"){
         $optionA = mb_htmlentities(($_POST['optionA']));
         $optionB = mb_htmlentities(($_POST['optionB']));
         $optionC = mb_htmlentities(($_POST['optionC']));
         $optionCorrect = mb_htmlentities(($_POST['optionCorrect']));
         
         $myObj->A = $optionA;
         $myObj->B = $optionB;
         $myObj->C = $optionC;
         $myObj->Correct = $optionCorrect;
         
         $myJSON = json_encode($myObj);
         
         $html = ($myJSON);

     }else if($type=="Multiple Choice Multi"){
         
         $myObj->A = mb_htmlentities(($_POST['optionA_multi']));
         $myObj->B = mb_htmlentities(($_POST['optionB_multi']));
         $myObj->C = mb_htmlentities(($_POST['optionC_multi']));
         $myObj->D = mb_htmlentities(($_POST['optionD_multi']));

         $myJSON = json_encode($myObj);
         $html = ($myJSON);

     }

    if($_POST['submit']=="Add"){
        
       $weight =  $_SESSION['weight'];
       $quiz_category =  $_SESSION['quiz_category'];
       $deadline = $_SESSION['deadline'];
       
     $sql="insert into pssec_quizzes(`topic_id`, `question`, `type`, `html`, `instructor_id`, `timeAdded`, `quiz_weight`, `quiz_category`, `deadline`) values ('$topicId', '$question', '$type', '$html', '$session_id', '$timeAdded', '$weight', '$quiz_category', '$deadline')";
        if(!mysqli_query($con,$sql))
        {
            echo "err1";
        }
        
         $sql="update pssec_topics set hasQuiz=1 where id='$topicId'";
        if(!mysqli_query($con,$sql))
        {
            echo "err2";
        }
        
        
    }
    if($_POST['submit']=="Publish"){
        $_SESSION['weight'] = '';
        $_SESSION['quiz_category'] = '';
        ?>
        <script type="text/javascript">
            window.location = "./courseContent_view.php?topicId=<?echo $topicId;?>";
        </script>
        <?
    }

}
else{
    //do nothing
    1;
}

$query_quizQuestions= "select * from pssec_quizzes where topic_id='$topicId' order by id desc "; 
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
              <h6 class="h2 text-white d-inline-block mb-0">Create Assignment</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item"><a href="./courseContent_view.php?topicId=<?echo $topicId?>"><?echo $topicTitle?></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Create Assignment</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || ($session_role=="teacher" && $authorId==$session_id)){?>
                <div class="col-lg-6 col-5 text-right">
                    <?if($_SESSION['weight']!=''){?>
                  <input type="submit" name="submit" value="Publish" class="btn btn-md btn-success" />
                  <?}?>
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
            
            <?if($_SESSION['weight']==''){?>
            <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Add Question</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
               
                  <div class="row">

                          <div class="col-md-4">
                              <label for="exampleFormControlInput1">Quiz Weightage (Less than <?echo 100-$currweight?>)</label>
                            <input type="number" max="<?echo 100-$currweight?>" min="0" name="weight" class="form-control" id="exampleFormControlInput1" placeholder="Quiz Weightage">
                          </div>
                          <div class="col-md-3">
                              <label for="exampleFormControlInput1">Assignment Category</label>
                            <select class="form-control" id="type" name="quiz_category">
                                  <option value="Quiz">Quiz</option>
                                  <option value="Assignment">Assignment</option>
                                  <option value="Midterm">Midterm</option>
                                  <option value="Exam">Exam</option>
                                  <option value="Mock Exam">Mock Exam</option>
                                  <option value="Homework">Homework</option>
                                  <option value="Classwork">Classwork</option>
                                  <option value="Test">Test</option>
                                  <option value="Project">Project</option>
                                </select>
                          </div>
                          <div class="col-md-3">
                              <label for="exampleFormControlInput1">Set Deadline</label>
                            <input required type="date" name="deadline" class="form-control" placeholder="Set Deadline">
                          </div>
                          
                        
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label for="exampleFormControlSelect1">Proceed</label><br>
                                  <input type="submit" name="submit" value="Proceed" class="btn btn-md btn-primary" />
                              </div>
                          </div>
                      </div>
            </div>
          </div>
          <?}?>
          
          
          <?if($_SESSION['weight']!=''){?>
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Add Question</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
               
                  <div class="row">

                          <div class="col-md-8">
                              <label for="exampleFormControlInput1">Question</label>
                            <input type="text" name="question" class="form-control" id="exampleFormControlInput1" placeholder="Question">
                          </div>
                          
                          <div class="col-md-3">
                              
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Type</label>
                                <select class="form-control" id="type" name="type">
                                  <option value="Free Text">Short Answers</option>
                                  <option value="Multiple Choice">Multiple Choice (Single Select)</option>
                                  <option value="Multiple Choice Multi">Multiple Choice (Multi Select)</option>
                                  <option value="Upload Submissions">Upload Submissions</option>
                                </select>
                              </div>
                          </div>
                          
                          <div class="col-md-1">
                              <div class="form-group">
                                  <label for="exampleFormControlSelect1">Add</label>
                                  <input type="submit" name="submit" value="Add" class="btn btn-md btn-primary" />
                              </div>
                              
                            
                          </div>
                          
                      </div>
                      
                      
                      
                      <div id="demo_mcqs" style="display:none">
                          <hr>
                          <div class="row">

                          <div class="col-md-3">
                              <label for="exampleFormControlInput1">Option A</label>
                            <input type="text" name="optionA" class="form-control" id="exampleFormControlInput1" placeholder="Option A: Type something" >
                          </div>
                          <div class="col-md-3">
                              <label for="exampleFormControlInput1">Option B</label>
                            <input type="text" name="optionB" class="form-control" id="exampleFormControlInput1" placeholder="Option B: Type something" >
                          </div>
                          <div class="col-md-3">
                              <label for="exampleFormControlInput1">Option C</label>
                            <input type="text" name="optionC" class="form-control" id="exampleFormControlInput1" placeholder="Option C: Type something" >
                          </div>
                          
                          <div class="col-md-3">
                              
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Choose Correct Option</label>
                                <select class="form-control" id="optionCorrect" name="optionCorrect">
                                  <option value="A">A</option>
                                  <option value="B">B</option>
                                  <option value="C">C</option>
                                </select>
                              </div>
                          </div>
                          
                      </div>
                          
                          
                      </div>
                      
                      <div id="demo_mcqs_multiple" style="display:none">
                          <hr>
                          <div class="row">

                          <div class="col-md-3">
                              <label for="exampleFormControlInput1">Option A</label>
                            <input type="text" name="optionA_multi" class="form-control" id="exampleFormControlInput1" placeholder="Option A: Type something" >
                          </div>
                          <div class="col-md-3">
                              <label for="exampleFormControlInput1">Option B</label>
                            <input type="text" name="optionB_multi" class="form-control" id="exampleFormControlInput1" placeholder="Option B: Type something" >
                          </div>
                          <div class="col-md-3">
                              <label for="exampleFormControlInput1">Option C</label>
                            <input type="text" name="optionC_multi" class="form-control" id="exampleFormControlInput1" placeholder="Option C: Type something" >
                          </div>
                           <div class="col-md-3">
                              <label for="exampleFormControlInput1">Option D</label>
                            <input type="text" name="optionD_multi" class="form-control" id="exampleFormControlInput1" placeholder="Option D: Type something" >
                          </div>
                        
                          
                      </div>
                          
                          
                      </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Added Questions</h5>
                </div>
              </div>
            </div>
            <div>
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" >Question</th>
                    <th scope="col" class="sort" >Type</th>
                  </tr>
                </thead>
                <tbody class="list">
                    <?
                    if ($result_quizQuestions->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_quizQuestions->fetch_assoc()) 
                        { 
                    ?>
                  <tr>
                    
                    <td>
                        <div class="media align-items-center">
                            <div class="media-body">
                              <span class="name mb-0 text-sm"><?echo $row['question']?>
                              </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="media align-items-center">
                            <div class="media-body">
                              <span class="name mb-0 text-sm"><?echo $row['type']?>
                              </span>
                            </div>
                        </div>
                    </td>
                    
                    <!--
                    <td>
                        <a class="btn btn-primary" href="./courseContent.php?courseId=<?echo $row['id']?>">View</a>
                    </td>
                    -->
                  </tr>
                  <?}
                  }?>
                  </tbody>
              </table>
            </div>
               
            </div>
          </div>
          <?}?>
        </div>
      </div>
      <!-- Footer -->
      <?include_once("./phpParts/footer.php")?>
    </div>
    </form>
  </div>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
  <script>
      $('#type').on('change', function() {
          
          if(this.value=="Multiple Choice"){
              $("#demo_mcqs").show()
          }else{
              $("#demo_mcqs").hide();
          }
          
          if(this.value=="Multiple Choice Multi"){
              $("#demo_mcqs_multiple").show()
          }else{
              $("#demo_mcqs_multiple").hide();
          }
        });
  </script>
  
</body>

</html>
