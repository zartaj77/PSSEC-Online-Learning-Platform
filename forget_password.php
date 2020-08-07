<?include_once("global.php");

if(isset($_POST['email'])){
    $email = $_POST['email'];
    
    $token = generateRandomString(20);
    $sql="update pssec_users set changePasswordToken='$token' where email='$email'";
    if(!mysqli_query($con,$sql))
    {
        echo "err";
    }else{
        
        
        
        $passwordLink  = "https://projects.anomoz.com/pssec/passwordReset.php?token=".$token;
    
    
    
    
    
        error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
        
        set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/php" . PATH_SEPARATOR . get_include_path());
        require_once "Mail.php";
        
        $host = "mail.anomoz.com";
        $username = "dev.email.sender@anomoz.com";
        $password = "V?#ib7g*.zU";
        $port = "587";
        $to = $email;
        
        $email_from = "QRiosity - Forget Password<givawoop.forget.password@anomoz.com>";
        $email_address = "dev.email.sender@anomoz.com";
        
        $headers = array (
        'From' => $email_from,
        'To' => $to, 'Subject' => "QRiosity - Forget Password", 
        'Reply-To' => $email_address
        );
        $email_body = "Your password reset link is $passwordLink
        ";
        $smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
        $mail = $smtp->send($to, $headers, $email_body);
        
        
        if (PEAR::isError($mail)) {
        echo("<p>" . $mail->getMessage() . "</p>");
        } else {
        echo("<p>Message successfully sent!</p>");
        }
        
        
        
        
        
        ?>
        <script type="text/javascript">
            //window.location = "?email-sent=1";
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
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="email" required name="email">
                  </div>
                </div>
                
                
                <div class="row my-4">
                    
                  <div class="col-6">
                    <div class="custom-control custom-control-alternative custom-checkbox">
                      
                      
                    </div>
                  </div>
                  <div class="col-6">
                     <input type="submit" class="btn btn-primary mt-4" value="Send Verification Email" style="margin-top: 0px !important;float: right;">
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