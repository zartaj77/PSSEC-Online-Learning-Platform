<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");

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

$query= "select * from pssec_quiz_submission where topic_id = '$topicId' and studentId='$session_id'"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    ?>
    <script type="text/javascript">
        window.location = "./courseContent_view.php?topicId=<?echo $topicId?>";
    </script>
    <?
}
        
if(isset($_POST['question'])){
    $answer = $_POST['answer'];
    $question = $_POST['question'];
    $question_type = $_POST['question_type'];
    $imageI = 0;
    
    for($i=0;$i<count($question);$i++)
    {
        $question_i = mb_htmlentities($question[$i]);
        $answer_i = mb_htmlentities($answer[$i]);
        $question_type_i = mb_htmlentities($question_type[$i]);
        
        if($question_type_i=="Multiple Choice Multi"){
            $msname =  'answer_'.$question_i;
            $mcqs_ans =  ($_POST[$msname]);
            for ($i=0; $i<count($mcqs_ans) ;$i++){
                $myObj->ans[] = mb_htmlentities($mcqs_ans[$i]);
            }
            $myJSON = json_encode($myObj);
            $answer_i = ($myJSON);
        }
        if($question_type_i=="Upload Submissions"){
            
            //upload pics
            if(isset($_FILES['fileToUpload'])){
        
                //upload pic
                if(isset($_FILES["fileToUpload"])){
                        $random = generateRandomString();
                        $target_dir = "./uploads/";
                        $fileName_db = "Anomoz_"."$random".basename($_FILES["fileToUpload"]["name"][$imageI]);
                        $realname =  basename($_FILES["fileToUpload"]["name"]);
                        $target_file = $target_dir . "Anomoz_"."$random".basename($_FILES["fileToUpload"]["name"][$imageI]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        // Check if image file is a actual image or fake image
                        if($_FILES["fileToUpload"]["tmp_name"][$imageI]!="") {
                            
                            $uploadOk = 1;
                        
                            // Check if file already exists
                            if (file_exists($target_file)) {
                                //echo "Sorry, file already exists.";
                                $filename=basename( $_FILES["fileToUpload"]["name"][$imageI]);
                                $uploadOk = 1;
                            }
                            // Check file size
                            if ($_FILES["fileToUpload"]["size"][$imageI] > 500000000000000000000) {
                                echo "Sorry, your file is too large.";
                                $uploadOk = 0;
                            }
                            // Allow certain file formats
                            if(false) {
                                echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
                                $uploadOk = 0;
                            }
                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 0) {
                                echo "Sorry, your file was not uploaded.";
                            // if everything is ok, try to upload file
                            } else {
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$imageI], $target_file)) {
                                    echo "The file ". basename( $_FILES["fileToUpload"]["name"][$imageI]). " has been uploaded.";
                                    $filename=basename( $_FILES["fileToUpload"]["name"][$imageI]);
                                    $uploadOk = 1;
                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                        
                        $imageI = $imageI+1;
                    
                }
                
                if(($filename!="none") && ($uploadOk=='1')){
                    $answer_i = $fileName_db;
                }

            }
                    
        }    
    
    
        
        
        $sql="insert into pssec_quiz_submission (`topic_id`, `studentId`,`questionId`, `answer`) values ('$topicId', '$session_id', '$question_i', '$answer_i')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
        
        
        
    }
    
    
    givePoints($con, "quiz taken $topicId", $session_id, '20');
    
    ?>
    <script type="text/javascript">
        window.location = "./courseContent_view.php?topicId=<?echo $topicId?>";
    </script>
    <?
    
    
}

$query_quiz= "select * from pssec_quizzes q WHERE q.topic_id='$topicId' order by rand() desc"; 
$result_quiz = $con->query($query_quiz);


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
              <h6 class="h2 text-white d-inline-block mb-0">Complete Profile</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                  <li class="breadcrumb-item"><a href="./courseContent_view.php?topicId=<?echo $topicId?>"><?echo $topicTitle?></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Quiz</li>
                  
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
                  <input type="submit" class="btn btn-md btn-neutral" value="Submit"/>
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
                  <h5 class="h3 mb-0">Quiz</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                
                  <div class="">
                      <?
                        if ($result_quiz->num_rows > 0)
                        { 
                            //successfull login
                            while($row = $result_quiz->fetch_assoc()) 
                            { 
                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <input type="text" name="question[]" hidden value="<?echo $row['id']?>">
                                    <input type="text" name="question_type[]" hidden value="<?echo $row['type']?>">
                                    
                                    
                                     <?if($row['type']=="Free Text"){?>
                                      Question: <?echo $row['question']?>
                                      
                                      <input style="margin-top:5px;" type="text" name="answer[]" required class="form-control" id="exampleFormControlInput1" placeholder="Your answer">
                                      
                                      <?}?>
                                      
                                      <?if($row['type']=="Upload Submissions"){?>
                                      Question: <?echo $row['question']?>
                                      
                                      <input style="margin-top:5px;" type="file" name="fileToUpload[]" required class="form-control" id="exampleFormControlInput1" placeholder="Your answer">
                                      
                                      <?}?>
                                      
                                      
                                      <?if($row['type']=="Multiple Choice"){?>
                                      Question: <?echo $row['question']?>
                                        
                                        <?
                                        $html = json_decode($row['html'], true);
                                        ?>

                                        <div style="margin-left:10px;margin-top:5px;">
                                            <div class="custom-control custom-radio ">
                                          <input type="radio" id="customRadio1" name="answer[]" value="<?echo $html['A']?>" class="custom-control-input">
                                          <label class="custom-control-label" for="customRadio1"><?echo $html['A']?></label>
                                          
                                        </div>
                                        <div class="custom-control custom-radio">
                                          <input type="radio" id="customRadio2" name="answer[]" value="<?echo $html['B']?>" class="custom-control-input">
                                          <label class="custom-control-label" for="customRadio2"><?echo $html['B']?></label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                          <input type="radio" id="customRadio3" name="answer[]" value="<?echo $html['C']?>" class="custom-control-input">
                                          <label class="custom-control-label" for="customRadio3"><?echo $html['C']?></label>
                                        </div>
                                        </div>
                                        
                                      <?}?>
                                      <?if($row['type']=="Multiple Choice Multi"){?>
                                      Question: <?echo $row['question']?>
                                        
                                        <?
                                        $html = json_decode($row['html'], true);
                                        ?>

                                        <div style="margin-left:10px;margin-top:5px;">
                                            <div class="custom-control custom-radio ">
                                          <input type="checkbox" id="customRadio1" name="answer_<?echo $row['id']?>[]" value="<?echo $html['A']?>" class="custom-control-input">
                                          <label class="custom-control-label" for="customRadio1"><?echo $html['A']?></label>
                                          
                                        </div>
                                        <div class="custom-control custom-radio">
                                          <input type="checkbox" id="customRadio2" name="answer_<?echo $row['id']?>[]" value="<?echo $html['B']?>" class="custom-control-input">
                                          <label class="custom-control-label" for="customRadio2"><?echo $html['B']?></label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                          <input type="checkbox" id="customRadio3" name="answer_<?echo $row['id']?>[]" value="<?echo $html['C']?>" class="custom-control-input">
                                          <label class="custom-control-label" for="customRadio3"><?echo $html['C']?></label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                          <input type="checkbox" id="customRadio4" name="answer_<?echo $row['id']?>[]" value="<?echo $html['D']?>" class="custom-control-input">
                                          <label class="custom-control-label" for="customRadio4"><?echo $html['D']?></label>
                                        </div>
                                        </div>
                                        
                                      <?}?>
                                      <div style="margin-top:20px"></div>
                                </div>
                          </div>
                      <?}
                      }
                      ?>

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
