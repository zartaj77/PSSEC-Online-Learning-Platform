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
            $instructorId = $row['instructor_id'];
            $hasQuiz = $row['hasQuiz'];
        }
        givePoints($con, "Visited topic ".$topicTitle, $session_id, '10');
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
    $quizSubmitted="yes";
}

$query= "select * from pssec_quizzes where topic_id = '$topicId'"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
        { 
            $deadline = $row['deadline'];
        }
}

$query_resources= "select * from pssec_topic_resources where topicId= '$topicId' "; 
$result_resources = $con->query($query_resources); 

?>
<!DOCTYPE html>
<html>

<head>
  <?include_once("./phpParts/header.php")?>
  <link rel="stylesheet" href="article-editor.min.css" />
  <style>
      img{
          width: 100%;

      }
  </style>
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
                  
                 
                  
                  <li class="breadcrumb-item"><a href="./courseContent.php?courseId=<?echo $courseId?>">Topics</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?echo $topicTitle?></li>
                  
                </ol>
              </nav>
            </div>

                <div class="col-lg-6 col-5 text-right">
                    <?if($hasQuiz=='1' && $session_role=='student'){?>
                            <?if($quizSubmitted=="yes"){?>
                                <button disabled class="btn btn-md btn-default" >Quiz Submitted</button>
                            <?}else{?>
                                <?if((strtotime($deadline)- strtotime(date('Y-m-d', time())))<0){?>
                                    <button disabled class="btn btn-md btn-default" >Deadline Passed</button>
                                <?}else{?>
                                    <a href="./courseContent_quiz.php?topicId=<?echo $topicId?>" class="btn btn-md btn-default" >Take Quiz</a>
                                <?}?>
                            <?}?>
                            
                        <?}?>
                    <?if($hasQuiz=='1' && $session_role!='student'){?>
                            <a href="./courseContent_quiz_viewSubmissions.php?topicId=<?echo $topicId?>" class="btn btn-md btn-default" >View Submissions</a>
                        <?}?>
                        
                    <?if($session_role=="admin" || ($session_role=="teacher" && $instructorId==$session_id)){?>
                        <?if($hasQuiz!='1'){?>
                            <a href="./courseContent_quiz_add.php?topicId=<?echo $topicId?>" class="btn btn-md btn-default" >Add Assignment</a>
                        <?}?>
                        <a href="./courseContent_edit.php?topicId=<?echo $topicId?>" class="btn btn-md btn-neutral" >Edit</a>
                    
                    <?}?>
                </div>
            
          </div>
          <!-- Card stats -->
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-8 col-md-8 col-lg-8">
            <?if(isset($_GET['saved'])){?>
            <div class="alert alert-success" role="alert">
                <strong>Saved</strong> You data was saved successfully.
            </div>
            <?}?>
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                    <!--
                  <h5 class="h3 mb-0">Lecture</h5>
                  -->
                   <a href="#" onclick="toggleAudio()" id="speak" class="btn btn-icon btn-primary btn-sm" >
                    	<span class="btn-inner--icon"><i class="fa fa-volume-up"></i></span>
                    </a>
                </div>
              </div>
            </div>
            <div class="card-body">
                
                <div class="arx-content"><?echo $content?></div>
                
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
        <div class="col-xl-4 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Resources</h5>
                </div>
              </div>
            </div>
                <div class="card-body">
                    <?if ($result_resources->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_resources->fetch_assoc()) 
                        { ?>
                        
                        <a href="./uploads/<?echo $row['url']?>" target="_blank"><?echo $row['resource_title']?></a>
                        <br>
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
  
  
 


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
/**
    $(function(){
  if ('speechSynthesis' in window) {
    

    $('#speak').click(function(){
        <?$content = str_replace('"', "", $content);?>
        <?$content = str_replace("'", "", $content);?>
        <?$content = str_replace(array("\r", "\n"), '', $content);?>
      var text = "<?echo (($content));?>";
      var msg = new SpeechSynthesisUtterance();
      var voices = window.speechSynthesis.getVoices();
      msg.voice = voices[1];
      msg.rate = 11 / 10;
      msg.pitch = 2;
      msg.text = text;

      msg.onend = function(e) {
        //console.log('Finished in ' + event.elapsedTime + ' seconds.');
      };

      speechSynthesis.speak(msg);
    })
  } else {
    $('#modal1').openModal();
  }
});

**/


var isOff = true;
var incvalue=0;
function toggleAudio(){
        console.log("toggleAudio", isOff)
        if(isOff){
                isOff = false;
              var text = "<?echo (($content));?>";
              var msg = new SpeechSynthesisUtterance();
              var voices = window.speechSynthesis.getVoices();
              msg.voice = voices[1];
              msg.rate = 11 / 10;
              msg.pitch = 2;
              msg.text = text;
        
              speechSynthesis.speak(msg);
          
        }else{
            speechSynthesis.cancel()
            isOff = true;
            
        }
        

}


$(window).on("beforeunload", function() {
    speechSynthesis.cancel()
});


</script>
<script src="article-editor.min.js"></script>
<script>
    ArticleEditor('#entry');
    
    document.getElementsByClassName("arx-editor-container")[0].style.pointerEvents = "none"
document.getElementsByClassName("arx-toolbar-container")[0].style.display = "none"
</script>



  
</body>

</html>
