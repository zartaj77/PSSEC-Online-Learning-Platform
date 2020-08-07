<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");

if(isset($_POST['title'])&&isset($_POST['abstract'])){
    
    
    
    //image handeling
    $courseId = generateRandomString(6);
    
    $filename = "none";
    $target_dir = "./uploads/";
    $fileName_db = "Anomoz_"."$courseId".basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . "Anomoz_"."$courseId".basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if($_FILES["fileToUpload"]["tmp_name"]!="") {
        
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    
    // Check if file already exists
    if (file_exists($target_file)) {
        //echo "Sorry, file already exists.";
        $filename=basename( $_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 50000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            $filename=basename( $_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    }

    
    //change picture
    if(($filename!="none") && ($uploadOk=='1')){
        $title = mb_htmlentities(($_POST['title']));
        $abstract = mb_htmlentities(($_POST['abstract']));
        $author_id = mb_htmlentities($session_id);
        $degree = mb_htmlentities($_POST['degree']);
        $departments = ($_POST['departments']);
        $timeAdded = time();
        
        $query_notf_recp= "select * from pssec_users"; 
        $result_notf_recp = $con->query($query_notf_recp); 
        if ($result_notf_recp->num_rows > 0)
        { 
            //successfull login
            while($row = $result_notf_recp->fetch_assoc()) 
            { 
                $temp_student = $row['id'];
                $sql="insert into pssec_notifications(`studentId`, `content`, `timeAdded`, `url`) values ('$temp_student', 'New course $title added by $session_name', '$timeAdded', './')";
                if(!mysqli_query($con,$sql)){echo "err2";} 
            }
        }
        
        givePoints($con, "New course $title", $session_id, '30');
     
        foreach ($_POST['departments'] as $selectedOption){
            $sql="insert into pssec_courseDepartments (`courseId`, `depId`, `timeAdded`) values ('$courseId', '$selectedOption', '$timeAdded')";
            if(!mysqli_query($con,$sql))
            {
                echo "err";
            }
        }
    
        
        
        
        
        $sql="insert into pssec_courses (`id`, `title`,`abstract`, `cover`, `timeAdded`, `instructor_id`, `university`, `degree`, `portion`) values ('$courseId', '$title', '$abstract', '$fileName_db', '$timeAdded', '$author_id', '$session_university', '$degree', '$session_portion')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }else{
            ?>
            <script type="text/javascript">
                window.location = "./courseContent.php?courseId=<?echo $courseId?>&courseCreated=1";
            </script>
            <?
        }
        
        
        
        
    }
}
else{
    //do nothing
    1;
}


$query_departments= "SELECT * FROM `pssec_departments` where university='$session_university'"; 
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
              <h6 class="h2 text-white d-inline-block mb-0">New Course</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item active" aria-current="page">New Course</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Add Content" class="btn btn-md btn-neutral" />
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
                  <h6 class="text-uppercase text-muted ls-1 mb-1">New Course</h6>
                  <h5 class="h3 mb-0">Add Basic Course Info</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                

                  <div class="form-group">
                    <label for="exampleFormControlInput1">Title</label>
                    <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="Course Title" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Abstract</label>
                    <textarea name="abstract" class="form-control" id="exampleFormControlTextarea1" rows="3" required maxlength="500"></textarea>
                  </div>
                  
                  
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Course Cover Photo</label>
                    <div class="custom-file">
                        <input required type="file" class="custom-file-input" id="customFileLang" name="fileToUpload" lang="en">
                    </div>
                  </div>
                  
                  
                  <?if($session_portion=="University"){?>
                      <div class="form-group row">
                        
                        <div class="col-md-6">
                            
                        <label for="exampleFormControlInput1">Select all applicable departments (<a href="./add_department.php">Add new</a>)</label>
                        <select multiple class="form-control" id="exampleFormControlSelect2" name="departments[]" required>
                            <?if ($result_departments->num_rows > 0)
                                { 
                                    //successfull login
                                    while($row = $result_departments->fetch_assoc()) 
                                    { ?> 
                          <option value="<?echo $row['id']?>"><?echo $row['depName']?></option>
                          <?}}?>
                        </select>
                            </div>
                            
                            <div class="col-md-6">
                            
                            
                        <label for="exampleFormControlInput1">Select Degree</label>
                        <select class="form-control" id="exampleFormControlSelect2" name="degree" required>
                            
                          <option value="BS">BS</option>
                          <option value="MS">MS</option>
                          <option value="BE">BE</option>
                          <option value="M.Phil">M.Phil</option>
                          <option value="PHD">PHD</option>
                        </select>
                            </div>
                            
                            
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
