<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");

if(!isset($_GET['uni'])){
            ?>
            <script type="text/javascript">
                window.location = "./";
            </script>
            <?
        }
   $uni = $_GET['uni'];     
if(isset($_POST['grade'])){
    $uni = $_GET['uni'];
     $sql="delete from pssec_gradescale where university = '$uni'";
        if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
        
    $grade = (($_POST['grade']));
    $min = (($_POST['min']));
    $max = (($_POST['max']));
    foreach( $grade as $key => $n ) {
        if($n!=''){
             $sql="INSERT into pssec_gradescale set university='$uni', grade='$grade[$key]', mini='$min[$key]', maxi='$max[$key]'";
             if(!mysqli_query($con,$sql))
        {
            echo "err";
        }
        }
    }
    
    ?>
            <script type="text/javascript">
               // window.location = "./admin_unis.php";
            </script>
            <?
   
}
else{
    //do nothing
    1;
}


$query_gradescales= "SELECT * FROM `pssec_gradescale` where university='$uni'"; 
$result_gradescales = $con->query($query_gradescales); 


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
              <h6 class="h2 text-white d-inline-block mb-0">Update Grade Scale</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item"><a href="./">Universities</a></li>
                  <li class="breadcrumb-item"><a href="./">Update Grade Scale</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?echo $_GET['uni']?></li>
                  
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Save" class="btn btn-md btn-neutral" />
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
                  <h5 class="h3 mb-0">Update Grade Scale</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
                
                <?
                    if ($result_gradescales->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_gradescales->fetch_assoc()) 
                        { 
                            ?>
                            <div class="row" id="myrow">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="text" name="grade[]" class="form-control" id="exampleFormControlInput1" placeholder="Letter Grade (eg. A+)" value="<?echo $row['grade']?>">
                  </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                    <input type="number" name="min[]" class="form-control" id="exampleFormControlInput1" placeholder="Min marks (eg. 90)" value="<?echo $row['mini']?>">
                  </div>
                    </div>
                    
                     <div class="col-md-4">
                        <div class="form-group">
                    <input type="number" name="max[]" class="form-control" id="exampleFormControlInput1" placeholder="Max marks (eg. 100)" value="<?echo $row['maxi']?>">
                  </div>
                    </div>
                 
                </div>
                            <?
                        }
                    }else{
                    
                    for($i=0; $i<10; $i++){?>
                    <p>Single Grade Entry</p>
                    <div class="row" id="myrow">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                        <input type="text" name="grade[]" class="form-control" id="exampleFormControlInput1" placeholder="Letter Grade (eg. A+)" >
                      </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                        <input type="number" name="min[]" class="form-control" id="exampleFormControlInput1" placeholder="Min marks (eg. 90)" >
                      </div>
                        </div>
                        
                         <div class="col-md-4">
                            <div class="form-group">
                        <input type="number" name="max[]" class="form-control" id="exampleFormControlInput1" placeholder="Max marks (eg. 100)" >
                      </div>
                        </div>
                     
                    </div>
                    <?}
                    
                }
                
                ?>
                  
           
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
