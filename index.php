<?include_once("./global.php");

if(isset($_GET['logout'])){
    session_destroy();
    $logged=0;
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

$query_courses= "select c.id, c.title, c.cover, u.name, e.id as 'isEnroll' from pssec_courses c inner join pssec_users u on c.instructor_id=u.id left outer join pssec_enrollment e on e.courseID=c.id and e.studentId='$session_id'"; 
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
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Courses</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item active"><a href="#"><i class="fas fa-home"></i></a></li>
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
      <div class="row" id="courses">
          <script>
            var courses_lst = [];
            var courses_id_lst = [];
            </script>
          <?
          if ($result_courses->num_rows > 0)
            { 
                $i = 0;
                while($row = $result_courses->fetch_assoc()) 
                { 
          ?>
          <script>courses_lst[<?echo $i?>] = "<?echo $row['title']?>"</script>
          <script>courses_id_lst[<?echo $i?>] = "<?echo $row['id']?>"</script>
        <div class="col-xl-4 col-md-4 col-lg-4" id="<?echo $row['id']?>">
          <div class="card">
            <div class="card-body" style="padding:0px;border-radius:10px;">
                <img style="width:100%;height:100%;border-radius:10px;" src="./uploads/<?echo $row['cover']?>" alt="<?echo $row['title']?>" />
            </div>
            <div class="card-footer bg-transparent">
              <div class="row align-items-center">
                <div class="col-md-10">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">By: <?echo $row['name']?></h6>
                  <h5 class="h3 mb-0"><?echo $row['title']?></h5>
                  
                </div>
                <?if($session_role=="student"){?>
                    <?if($row['isEnroll']==''){?>
                        <div class="col-md-2" style="float:right;right:20px;">
                            <a href="./courseContent.php?courseId=<?echo $row['id']?>&enroll=yes" class="btn btn-sm btn-primary">Enroll</a>
                        </div>
                    <?}else{?>
                        <div class="col-md-2" style="float:right;right:20px;">
                            <a href="./courseContent.php?courseId=<?echo $row['id']?>" class="btn btn-sm btn-success">View</a>
                        </div>
                    <?}?>
                <?}if($logged==0){?>
                    <div class="col-md-2" style="float:right;right:20px;">
                            <a href="./register.php" class="btn btn-sm btn-primary">Signin</a>
                        </div>
                <?}?>
              </div>
            </div>
          </div>
        </div>
        <?$i +=1;}}?>
      </div>
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
</body>

</html>
