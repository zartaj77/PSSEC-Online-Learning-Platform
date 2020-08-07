<?include_once("global.php");?>
    <?
if(isset($_POST['email'])&&isset($_POST['password'])){
    $errMsg="none";
    $email = mb_htmlentities(($_POST['email']));
    $password = mb_htmlentities( md5(md5(sha1( $_POST['password'])).'Anomoz'));
    $query_selectedPost= "select * from pssec_users where email= '$email' and password='$password'"; 
    $result_selectedPost = $con->query($query_selectedPost); 
    if ($result_selectedPost->num_rows > 0)
    { 
        //successfull login
        while($row = $result_selectedPost->fetch_assoc()) 
        { 
            $logged=1;
            $_SESSION['email'] = $email;
            $_SESSION['userId'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['password'] = $row['password'];
            ?>
            <script type="text/javascript">
                window.location = "./";
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
  <?include_once("./phpParts/header.php"); ?>
  
  <style>
  
        .bg-default{
            /**
            background:url("./assets/img/<?if($session_portion=="University"){echo "uni";}else{echo "school";}?>_login.jpg") no-repeat fixed !important;
            background-size: 100% 100% !important;
    background-repeat: no-repeat !important;
    background-position: left top !important;
    
    **/
    background-color: red;
background-image: url("./assets/img/<?if($session_portion=="University"){echo "uni";}else{echo "school";}?>_login.jpg");
background-size: cover;
background-attachment: fixed;
height: 100vh;

            
        }
        
      .bg-gradient-primary{
          background: #f0f8ff00 !important;
      }
  </style>
  
</head>

<body class="bg-default">
  <!-- Navbar 
  <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="./">
        <h3 style="font-size: 30px;color: white;"><img src="assets/img/uni_logo.png" style="max-height: 60px;background-color: #d4daff;border-radius: 1000px;padding:1px;" class="navbar-brand-img" alt="Logo"></h3>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="./">
                <img src="./assets/img/brand/blue.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="./" class="nav-link">
              <span class="nav-link-inner--text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="login.php" class="nav-link">
              <span class="nav-link-inner--text">Login</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="register.php" class="nav-link">
              <span class="nav-link-inner--text">Register</span>
            </a>
          </li>
        </ul>
        <hr class="d-lg-none" />
      </div>
    </div>
  </nav>
  -->
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9" style="padding-bottom:5rem!important;padding-top:8rem!important;">
        <!--
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Login to your Account</h1>
              <p class="text-lead text-white">Login to your account and get access of hundereds of free courses.</p>
            </div>
          </div>
        </div>
      </div>
      -->
      <!--
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
      -->
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary border-0">
            <div class="card-body px-lg-5 py-lg-5">
                
            
                
                <img src="assets/img/uni_logo.png" style="margin: 10px;max-height: 50px;padding:1px;margin: 10px auto;justify-content: center;display: grid;" class="navbar-brand-img" alt="Logo">
                
              <form role="form" method="post" action="">
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="email" required name="email">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" type="password" required name="password">
                  </div>
                </div>
                
                
                <div class="row my-4">
                    
                  <div class="col-6">
                    <div class="custom-control custom-control-alternative custom-checkbox">
                      <input class="custom-control-input" id="customCheckRegister" type="checkbox" >
                      <label class="custom-control-label" for="customCheckRegister">
                        <span class="text-muted">Stay signed in</span>
                      </label>
                      <br>
                      <a href="./forget_password.php">Forgot Password?</a>
                    </div>
                  </div>
                  <div class="col-6">
                     <input type="submit" class="btn btn-primary mt-4" value="Login" style="margin-top: 0px !important;float: right;">
                  </div>
                </div>
                
               
                <div class="text-center">
                    <br>
                    <a href="./register.php">Signup</a> | <a href="./?guest">Welcome Tour</a>
                </div>
                
                <a href="https://www.pssecm2m.com/" style="justify-content: center;display: grid;">
                <img src="https://pssecm2m.com/wp-content/uploads/2020/04/PSSEC-LOGO.png" style="margin: 10px;max-height: 50px;border-radius: 1000px;padding:1px;" class="navbar-brand-img text-center" alt="Logo">
                </a>
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