<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");

if(isset($_POST['dept'])){

    
    //change picture
    if(true){
        $dept = mb_htmlentities(($_POST['dept']));
        if($session_role=="admin"){
            $university = mb_htmlentities(($_POST['university']));
        }else{
            $university = mb_htmlentities($session_university);
        }
       
        $query_notf_recp= "select * from pssec_users"; 
        $result_notf_recp = $con->query($query_notf_recp); 
        if ($result_notf_recp->num_rows > 0)
        { 
            //successfull login
            while($row = $result_notf_recp->fetch_assoc()) 
            { 
                $temp_student = $row['id'];
                $sql="insert into pssec_notifications(`studentId`, `content`, `timeAdded`, `url`) values ('$temp_student', 'New Department Added', '$timeAdded', './')";
                if(!mysqli_query($con,$sql)){echo "err2";} 
            }
        }
        
        givePoints($con, "New Department $title", $session_id, '30');
     
        
        
        $sql="insert into pssec_departments (`depName`, `university`) values ('$dept', '$university')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }else{
            ?>
            <script type="text/javascript">
                window.location = "./newCourse.php";
            </script>
            <?
        }
        
        
        
        
    }
}
else{
    //do nothing
    1;
}


$query_departments= "SELECT * FROM `pssec_users` where university!='' group by university  "; 
$result_departments = $con->query($query_departments); 


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
              <h6 class="h2 text-white d-inline-block mb-0">New Department</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item active" aria-current="page">New Department</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Add Department" class="btn btn-md btn-neutral" />
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
                  <h5 class="h3 mb-0">New Department</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                

                  <div class="form-group">
                    <label for="exampleFormControlInput1">Department name</label>
                    <input type="text" name="dept" class="form-control" id="exampleFormControlInput1" placeholder="Department name" required>
                  </div>
                  <?if($session_role=="admin"){?>
                  <div class="form-group">
                    <label for="exampleFormControlInput1">University</label>
                    <select class="form-control" id="exampleFormControlSelect2" name="university" required>
                        <?if ($result_departments->num_rows > 0)
                            { 
                                //successfull login
                                while($row = $result_departments->fetch_assoc()) 
                                { ?> 
                      <option value="<?echo $row['university']?>"><?echo $row['university']?></option>
                      <?}}?>
                      
                    </select>
                  </div>
                  <?}?>
           
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
