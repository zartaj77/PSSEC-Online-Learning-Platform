<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");



$filename = "none";
if(isset($_GET['id'])){
    $courseId = $_GET['id'];
    $query= "select * from pssec_courses where id = '$courseId' "; 
    $result = $con->query($query); 
    if ($result->num_rows > 0)
    { 
        //successfull login
        while($row = $result->fetch_assoc()) 
        { 
            $intro = $row['intro'];
            $preview = $row['preview'];
            $curri = $row['curri'];
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
        window.location = "./?error-occured=2";
    </script>
    <?
}


if($session_role=='admin' || $authorId==$session_id){
    1;
}else{
    ?>
    <script type="text/javascript">
        window.location = "./?error-occured=3";
    </script>
    <?
}



if(isset($_POST['intro'])){
 

    //change picture
    if(true){
        $intro = $_POST['intro'];
        $preview = $_POST['preview'];
        $curri = $_POST['curri'];
        
        $intro = mysqli_real_escape_string($con, $intro);
        $preview = mysqli_real_escape_string($con, $preview);
        $curri = mysqli_real_escape_string($con, $curri);
        
        $sql="update pssec_courses set intro='$intro', preview='$preview', curri='$curri' where id='$courseId'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
            echo mysqli_error($con);
        }else{
            
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
                  
                 
                  
                  <li class="breadcrumb-item active" aria-current="page">Details</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
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
        <div class="col-xl-12 col-md-12 col-lg-12">
            
            
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Intro</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
               
                  <div class="form-group">
                    <textarea style="width:100%" name="intro" class="form-control" id="entry"><?echo $intro?></textarea>
                  </div>
            </div>
          </div>
          
          
          
           <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Preview</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
               
                  <div class="form-group">
                    <textarea style="width:100%" name="preview" class="form-control" id="entry2"><?echo $preview?></textarea>
                  </div>
            </div>
          </div>
          
          
          
          
           <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Curriculum Map</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
               
                  <div class="form-group">
                    <textarea style="width:100%" name="curri" class="form-control" id="entry3"><?echo $curri?></textarea>
                  </div>
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
            
            
            ArticleEditor('#entry2',
            {
                image: {
                    upload: './image-upload.php'
                }
            });
            
            
            ArticleEditor('#entry3',
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
