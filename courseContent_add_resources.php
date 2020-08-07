<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");



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



if(isset($_FILES['fileToUpload'])){
 
    //upload pic
    if(isset($_FILES["fileToUpload"])){
        $target_dir = "./uploads/";
        $fileName_db = "Anomoz_"."$topicId".basename($_FILES["fileToUpload"]["name"]);
        $realname =  basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . "Anomoz_"."$topicId".basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if($_FILES["fileToUpload"]["tmp_name"]!="") {
            
            $uploadOk = 1;
        
        // Check if file already exists
        if (file_exists($target_file)) {
            //echo "Sorry, file already exists.";
            $filename=basename( $_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000000000000000000) {
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
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                $filename=basename( $_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        }
    }
    
    if(($filename!="none") && ($uploadOk=='1')){
        $resource_title = mb_htmlentities(($_POST['resource_title']));
        $author_id = mb_htmlentities($session_id);
        $timeAdded = time();

        $sql="insert into pssec_topic_resources(`topicId`, `filename`, `url`, `timeAdded`, `resource_title`) values ('$topicId', '$realname', '$fileName_db', '$timeAdded', '$resource_title')";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
    }

    
}

$query_resources= "select * from pssec_topic_resources where topicId= '$topicId' "; 
        $result_resources = $con->query($query_resources); 


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
              <h6 class="h2 text-white d-inline-block mb-0"><?echo $topicTitle?></h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  
                  <li class="breadcrumb-item"><a href="./courseContent.php?courseId=<?echo $courseId?>">Topics</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?echo $topicTitle?></li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Upload" class="btn btn-md btn-success" />
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
        <div class="col-xl-8 col-md-8 col-lg-8">
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
                 
                <hr>
                  
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Upload new Resource</label>
                    <input type="text" placeholder="Resource title" style="width:100%" name="resource_title" class="form-control" required/>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFileLang" name="fileToUpload" lang="en">
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
  
</body>

</html>
