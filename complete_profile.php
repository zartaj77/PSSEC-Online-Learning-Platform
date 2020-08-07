<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");

if($session_studentId != ''){
    ?>
    <script type="text/javascript">
        window.location = "./";
    </script>
    <?
}
if(isset($_POST['studentId'])&&isset($_POST['semester'])){
    
        $studentId = mb_htmlentities(($_POST['studentId']));
        $semester = mb_htmlentities(($_POST['semester']));
        
        $vehicle1 = mb_htmlentities(($_POST['vehicle1']));
        $vehicle2 = mb_htmlentities(($_POST['vehicle2']));
        $vehicle3 = mb_htmlentities(($_POST['vehicle3']));
        
        $timeAdded = time();

        $sql="insert into pssec_student_devices (`user_id`, `device`, `timeAdded`) values ('$session_id', '$vehicle1', '$timeAdded')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
        $sql="insert into pssec_student_devices (`user_id`, `device`, `timeAdded`) values ('$session_id', '$vehicle2', '$timeAdded')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
        $sql="insert into pssec_student_devices (`user_id`, `device`, `timeAdded`) values ('$session_id', '$vehicle3', '$timeAdded')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
        
        $sql="update pssec_users set semester='$semester', studentId='$studentId' where id='$session_id'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
        else{
            givePoints($con, "Completed Profile", $session_id, '10');
            ?>
            <script type="text/javascript">
                window.location = "./";
            </script>
            <?
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
              <h6 class="h2 text-white d-inline-block mb-0">Complete Profile</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item active" aria-current="page">Complete Profile</li>
                  
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
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Your Info</h6>
                  <h5 class="h3 mb-0">Add your Basic Information</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                
                  <div class="">
                      <div class="row">
                          <div class="col-md-6">
                              
                            <div class="form-group">
                                <label for="exampleFormControlSelect1"><?if($session_portion=="University"){echo "Semester";}else{echo "Class";}?></label>
                                <select class="form-control" id="exampleFormControlSelect1" name="semester">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="6">6</option>
                                  <option value="7">7</option>
                                  <option value="8">8</option>
                                </select>
                              </div>
                          </div>
                          
                          <div class="col-md-6">
                              <label for="exampleFormControlInput1">Valid Student ID issued by your <?if($session_portion=="University"){echo "University";}else{echo "School/College";}?></label>
                            <input type="text" name="studentId" class="form-control" id="exampleFormControlInput1" placeholder="Student ID" required>
                          </div>
                          
                      </div>
                      
                     <br>
                     <label for="exampleFormControlInput1">Do you own any of the following? (Select all that apply)</label>
                    <div class="">
                        <div class="form-group ">
                          
                          <input type="checkbox" id="vehicle1" name="vehicle1" value="Laptop">
                          <label for="vehicle1">Laptop</label><br>
                          <input type="checkbox" id="vehicle2" name="vehicle2" value="Smartphone">
                          <label for="vehicle2">Smartphone</label><br>
                          <input type="checkbox" id="vehicle3" name="vehicle3" value="Desktop Computer">
                          <label for="vehicle3">Desktop Computer</label><br><br>
                          
                        </div>
                    </div>
                        


                    
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
