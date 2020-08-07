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
        
        $query_resources= "select * from pssec_topic_resources where topicId= '$topicId' "; 
        $result_resources = $con->query($query_resources); 
        
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



if(isset($_POST['content'])){
 

    //change picture
    if(true){
        $content = (($_POST['content']));
        
        $query_notf_recp= "select p.studentId as id from pssec_enrollment p where p.courseId='$courseId'"; 
        $result_notf_recp = $con->query($query_notf_recp); 
        if ($result_notf_recp->num_rows > 0)
        { 
            //successfull login
            while($row = $result_notf_recp->fetch_assoc()) 
            { 
                $temp_student = $row['id'];
                $sql="insert into pssec_notifications(`studentId`, `content`, `timeAdded`, `url`) values ('$temp_student', 'Topic $topicTitle updated', '$timeAdded', './courseContent_view.php?topicId=$topicId')";
                if(!mysqli_query($con,$sql)){echo "err2";} 
            }
        }
        
        $content = mysqli_real_escape_string($con, $content);
        $sql="update pssec_topics set content='$content' where id='$topicId'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
            echo mysqli_error($con);
        }else{
            if(($_FILES["fileToUpload"]["name"])==""){
                ?>
                <script type="text/javascript">
                    window.location = "./courseContent_view.php?topicId=<?echo $topicId?>&saved=1";
                </script>
                <?
            }
        }
    }
    
    
    
    //upload pic
    if(isset($_FILES["fileToUpload"])){
        $target_dir = "./uploads/";
        $fileName_db = "Anomoz_"."$topicId".basename($_FILES["fileToUpload"]["name"]);
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
        $title = mb_htmlentities(($_POST['title']));
        $abstract = mb_htmlentities(($_POST['abstract']));
        $video_title = mb_htmlentities(($_POST['video_title']));
        $author_id = mb_htmlentities($session_id);
        $timeAdded = time();

        $sql="update pssec_topics set lectureVideo='$fileName_db', video_title='$video_title' where id='$topicId'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }else{
            ?>
            <script type="text/javascript">
                window.location = "./courseContent_view.php?topicId=<?echo $topicId?>&saved=1";
            </script>
            <?
        }
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
  
  <link rel="stylesheet" href="article-editor.min.css" />
  
  <!--
  <script type="text/javascript" src="scripts/wysiwyg.js"></script>
        <script type="text/javascript" src="scripts/wysiwyg-settings.js"></script>
        -->
        <script type="text/javascript">
        /**
            // Use it to attach the editor to all textareas with full featured setup
            //WYSIWYG.attach('all', full);
            
            // Use it to attach the editor directly to a defined textarea
            WYSIWYG.attach('textarea2', full); // full featured setup
            
            // Use it to display an iframes instead of a textareas
            //WYSIWYG.display('all', full);  
            **/
        </script>
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
    <div id="show">
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
                    <a href="./courseContent_view.php?topicId=<?echo $topicId?>" class="btn btn-md btn-warning" >Cancel</a>
                  <input type="submit" value="Save" class="btn btn-md btn-success" />
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
                  <h5 class="h3 mb-0">Topic Content</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
               
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Lecture Content</label>
                    <textarea style="width:100%" name="content" class="form-control" id="entry"><?echo $content?></textarea>
                  </div>
                  
                  
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Upload Lecture Video</label>
                    <input type="text" placeholder="Video title" style="width:100%" name="video_title" class="form-control"/>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFileLang" name="fileToUpload" lang="en">
                    </div>
                  </div>
                  
           
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
                <div class="card-footer">
                    <a onclick="window.open('./courseContent_add_resources.php?topicId=<?echo $topicId?>','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=1350');" style="color:white;" class="btn btn-md btn-primary full">Add Resource</a>
                </div>
            </div>
        </div>
      </div>
      <!-- Footer -->
      <?include_once("./phpParts/footer.php")?>
      <script src="article-editor.min.js"></script>
        <script>
            ArticleEditor('#entry',
{
    image: {
        upload: './image-upload.php'
    }
});
        </script>
    </div>
    
    </form>
  </div>
  <!-- Scripts -->
  
  <script>
  </script>
</body>

</html>
