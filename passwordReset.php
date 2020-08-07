<?include_once("global.php");?>
<?

//https://projects.anomoz.com/pssec/passwordReset.php?token=HKI01KMD8YIXBUR171QW
if(isset($_GET['token'])){
    $token = $_GET['token'];
    $query = "SELECT * FROM pssec_users WHERE changePasswordToken='$token'";
    $result = $con->query($query);
    if ($result->num_rows > 0){
        //
    }else{
        ?>
            <script type="text/javascript">
                window.location = "./";
            </script>
        <?
    }

}else{
    ?>
        <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}


if(isset($_POST['password'])){

    $password = ( md5(md5(sha1( $_POST['password'])).'Anomoz'));
    $sql="update pssec_users set password='$password' where changePasswordToken='$token'";
    if(!mysqli_query($con,$sql))
    {
        echo "err";
    }else{
    
        ?>
        <script type="text/javascript">
            window.location = "./";
        </script>
    <?
        
    }
    
}
?>
<!DOCTYPE html>
<html>

<head>
  <?include_once("./phpParts/header.php"); ?>
  
  <style>
  
        .bg-default{
            background:url("./assets/img/<?if($session_portion=="University"){echo "uni";}else{echo "school";}?>_login.jpg") no-repeat fixed !important;
            background-size: 100% 100% !important;
    background-repeat: no-repeat !important;
    background-position: left top !important;
            
        }
        
      .bg-gradient-primary{
          background: #f0f8ff00 !important;
      }
  </style>
  
</head>

<body class="bg-default">
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9" style="padding-bottom:5rem!important;padding-top:8rem!important;">
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary border-0">
            <div class="card-body px-lg-5 py-lg-5">
                
            
             
                
              <form role="form" method="post" action="">
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" type="password" required name="password">
                  </div>
                </div>
                
                
                <div class="row my-4">
                    
                  <div class="col-6">
                    <div class="custom-control custom-control-alternative custom-checkbox">
                      
                      
                    </div>
                  </div>
                  <div class="col-6">
                     <input type="submit" class="btn btn-primary mt-4" value="Change Password" style="margin-top: 0px !important;float: right;">
                  </div>
                </div>
                
              
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <?include_once("./phpParts/footer-login-signup.php")?>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
</body>

</html>