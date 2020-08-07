<?include_once("./global.php");


if(isset($_GET['switch-experience'])){
    givePoints($con, "switch-experience", $session_id, '10');
    session_destroy();
    $logged=0;
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

if(isset($_GET['logout'])){
    givePoints($con, "logout", $session_id, '10');
    session_destroy();
    $logged=0;
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

if(isset($_GET['change-bot'])){
    $bot = $_GET['change-bot'];
    $sql="update pssec_users set bot='$bot' where id='$session_id'";
                if(!mysqli_query($con,$sql)){echo "notf err2";}else{
                    $session_bot = $bot;
                }
    
    
}


if(isset($_GET['experience'])){
    $_SESSION['portion'] = $_GET['experience'];
    ?>
    <script type="text/javascript">
            window.location = "./login.php";
        </script>
    <?
}

//$_SESSION['portion'] = '';


givePoints($con, "Visited Homepage", $session_id, '10');

if(isset($_GET['department']) || $_SESSION['departmentExplore']!=''){
    $_SESSION['explored'] = "yes";
    $depId = $_GET['department'];
    $_SESSION['departmentExplore'] = $depId;
    $depId = $_SESSION['departmentExplore'];
    
    $query_courses= "select c.abstract, c.university, c.id, c.title, c.cover, u.name, e.id as 'isEnroll' from pssec_courses c inner join pssec_users u on c.instructor_id=u.id left outer join pssec_enrollment e on e.courseID=c.id left outer join pssec_courseDepartments cd on cd.courseId=c.id where c.isHidden!=1 and e.studentId='$session_id' and cd.depId='$depId' order by c.timeAdded desc"; 
}else{
    if($session_role=='student'){
        $query_courses= "select c.abstract, c.university, c.id, c.title, c.cover, u.name, e.id as 'isEnroll' from pssec_courses c inner join pssec_users u on c.instructor_id=u.id left outer join pssec_enrollment e on e.courseID=c.id where c.isHidden!=1 and e.id!='' and e.studentId='$session_id' order by c.timeAdded desc"; 
    }else{
        $query_courses= "select c.abstract, c.university, c.id, c.title, c.cover, u.name, e.id as 'isEnroll' from pssec_courses c inner join pssec_users u on c.instructor_id=u.id left outer join pssec_enrollment e on e.courseID=c.id where c.isHidden!=1 and c.instructor_id='$session_id' group by c.id  order by c.timeAdded desc"; 
    }
        
}
$result_courses = $con->query($query_courses); 

if($session_portion=="University"){
    $query_departments= "SELECT * FROM `pssec_departments` where portion='$session_portion'"; 
}else{
    $query_departments= "SELECT * FROM `pssec_courses` where portion='$session_portion'";    
}
$result_departments = $con->query($query_departments); 

$askToExplore = 1;
if(($logged==1 || $_SESSION['explored']=="yes")){
    $askToExplore = 0;
}


$todayDate = date("Y-m-d");
//upcomming quizes
$query_upcommingQuizes = "SELECT t.id, t.title, q.quiz_category, q.deadline, e.studentId FROM `pssec_quizzes` q 
INNER join pssec_topics t on q.topic_id=t.id INNER join pssec_courses c on c.id=t.courseId inner join pssec_enrollment e 
on e.courseId=c.id where  e.studentId='$session_id' and q.deadline!='' and TIMESTAMPDIFF(SECOND, q.deadline, '$todayDate')<0 group by q.topic_id";
$result_upcommingQuizes = $con->query($query_upcommingQuizes); 

//quiz feedback
$query_quizFeedback = "SELECT q.quiz_weight, q.quiz_category ,s.topic_id, u.id, s.isCorrect, t.title, sum(s.isCorrect) / count(u.id) as scorePercent 
FROM `pssec_quiz_submission` s inner join pssec_users u on s.studentId=u.id inner join pssec_topics t on t.id=s.topic_id inner 
join pssec_quizzes q on q.topic_id=s.topic_id where u.id='$session_id' GROUP by s.topic_id";
$result_quizFeedback = $con->query($query_quizFeedback); 

//not enrolled courses
$query_notEnrolled= "select c.abstract, c.university, c.id, c.title, c.cover, u.name, e.id as 'isEnroll' from pssec_courses c inner join pssec_users u on c.instructor_id=u.id left outer join pssec_enrollment e on e.courseID=c.id and e.studentId='$session_id' where c.portion='$session_portion' and c.isHidden!=1 and e.id is null order by c.timeAdded desc"; 
$result_notEnrolled = $con->query($query_notEnrolled); 



?>
<!DOCTYPE html>
<html>

<head>
  <?include_once("./phpParts/header.php")?>
  
</head>

<body>
  <!-- Sidenav -->
  <?
  if($logged==1){
  include_once("./phpParts/sidenav.php");
  }
  
  ?>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <?include_once("./phpParts/topnav.php")?>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
              
            <div class="col-lg-6 col-7">
                
                <?if(($askToExplore==1 && $session_portion!='') || ($session_role=="uniadmin") || ($session_portion=='')){?>
                
                
              <h6 class="h2 text-white d-inline-block mb-0">
                  <?if($askToExplore==1 && $session_portion!=''){echo "What would you like to Explore?";}else if($session_role=="uniadmin"){echo"Kindly, contact Admin for getting Admin Access to the Grade Scale Panel";}else if($session_portion==''){echo "Choose Your Experience";}?>
                  
                  </h6>
                  
                  <?}?>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <a href="./newCourse.php" class="btn btn-md btn-neutral">Add New Course</a>
                </div>
            <?}?>
            
          </div>
          
          <?if($askToExplore==1 && $session_portion!=''){
          ?>
                    <div class="col-xl-12 col-md-12">
                        <input type="text" id="searchQuery_dep" onkeyup="searchQuery_dep()" name="department" class="form-control form-control-alternative" placeholder="Search your department">
                    </div>
          <?}?>
          
          <?if($session_studentId=='' && $session_semester=='' && $session_role=='student'){?>
          <a href="./complete_profile.php">
              <div class="alert alert-warning" role="alert">
                <strong>Your profile is not complete.</strong> Complete your profile now by clicking this alert.
            </div>
          </a>
            <?}?>
            
            
          <!-- Card stats -->
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        
        
    <?if($session_role!='uniadmin')
    {?>    
          <?if($askToExplore==0){?>
          
            <?
            include("./phpParts/home_not_explore.php")?>
            
          <?}else if($askToExplore==1 && $session_portion!=''){?>
          
            <?include("./phpParts/home_explore.php")?>
            
          <?}else if($session_portion==''){?>
          
            <?include("./phpParts/home_choose_portion.php")?>
          <?}?>
          
      <?}?>
      <!-- Footer -->
      <?include_once("./phpParts/footer.php")?>
    </div>
  </div>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
  <script>
      function searchQuery(){
          var search = document.getElementById("searchQuery").value;
          console.log("srch", search)
          
          
          found = 0;
          for (var j = 0; j < courses_id_lst.length; j++) {
                    $('#'+courses_id_lst[j]).show();
                    
                }
          for (var i = 0; i < courses_lst.length; i++) {
            if(courses_lst[i].toLowerCase().indexOf(search.toLowerCase()) != -1)
            {
                for (var j = 0; j < courses_id_lst.length; j++) {
                    if(courses_id_lst[j]!=courses_id_lst[i]){
                        $('#'+courses_id_lst[j]).hide();
                    }
                }
                found = 1;
            }
        }
        if(found==0){
            for (var j = 0; j < courses_id_lst.length; j++) {
                    $('#'+courses_id_lst[j]).show();
                    
                }
        }
        if(search==''){
            for (var j = 0; j < courses_id_lst.length; j++) {
                    $('#'+courses_id_lst[j]).show();
                    
                }
        }
                
                
      }
  </script>
  
  
  <script>
      function searchQuery_dep(){
          var search = document.getElementById("searchQuery_dep").value;
          //console.log("srch", search)
          
          
          //show all
          found = 0;
          for (var j = 0; j < departments_id_lst.length; j++) {
                    $('#'+departments_id_lst[j]).show();
                    
                }
        
        if(search!=""){
             for (var j = 0; j < departments_id_lst.length; j++) {
                    $('#'+departments_id_lst[j]).hide();
                    
                }
        }
        //hide all
          for (var i = 0; i < departments_lst.length; i++) {
            if(departments_lst[i].toLowerCase().indexOf(search.toLowerCase()) != -1)
            {
                $('#'+departments_id_lst[i]).show();
                /**
                for (var j = 0; j < departments_id_lst.length; j++) {
                    if(departments_id_lst[j]!=departments_id_lst[i]){
                        $('#'+departments_id_lst[j]).hide();
                    }
                }
                found = 1;
                **/
            }
        }
        /**
        if(found==0){
            for (var j = 0; j < departments_id_lst.length; j++) {
                    $('#'+departments_id_lst[j]).show();
                    
                }
        }
        if(search==''){
            for (var j = 0; j < departments_id_lst.length; j++) {
                    $('#'+departments_id_lst[j]).show();
                    
                }
        }
        **/
                
                
      }
  </script>
  
  
  <script>
    $("#myModal").modal()
    $(".container").hide();
   
   document.getElementById('myVideo').addEventListener('ended', closeModal, false);


    function closeModal() {
        $(".container").show();
        $('#myModal').modal('hide');
    }
    </script>
 
</body>

</html>
