<?include_once("global.php");?>
    <?
if(isset($_POST['email'])&&isset($_POST['password'])){
    
    $errMsg="none";
    $name = mb_htmlentities(($_POST['name']));
    $lname = mb_htmlentities(($_POST['lname']));
    $email = mb_htmlentities(($_POST['email']));
    $university = mb_htmlentities(strtoupper($_POST['university']));
    $role = mb_htmlentities(($_POST['role']));
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
            $_SESSION['university'] = ($row['university']);
            ?>
            <script type="text/javascript">
                window.location = "./";
            </script>
            <?
        }
    }
    else{
        
        // is email being used
        $query_selectedPost= "select * from pssec_users where email= '$email'"; 
        $result_selectedPost = $con->query($query_selectedPost); 
        if ($result_selectedPost->num_rows > 0)
        { 
            //problem diagnosed: email correct, incorrect pass
            $errMsg = "Incorrect password.";
        }else{
            //emaail not taken. create new account
            
            $dateTime = time();
            $userId = intval((strval(1)).(strval(mt_rand(111111111, 999999999))));
            
            //check if uni exist
            $query= "select * from pssec_users where university= '$university'"; 
            $result = $con->query($query); 
            if ($result->num_rows == 0)
            { 
                //send notf
                $timeAdded = time();
                $msg = 'New university '. $university.' added.';
                $sql="insert into pssec_notifications(`studentId`, `content`, `timeAdded`, `url`) values ('1', '$msg', '$timeAdded', '#')";
                if(!mysqli_query($con,$sql)){echo "notf err2";} 
                
            }
            
            
            
            
            
            $sql="insert into pssec_users (`name`, `lname`,`email`, `password`, `role`, `university`, `portion`) values ('$name','$lname', '$email', '$password', '$role', '$university', '$session_portion')";
            if(!mysqli_query($con,$sql))
            {
                echo "err".mysqli_error($con);
            }
            else{
                 $_SESSION['email'] = $email;
                 $_SESSION['password'] = $password;
                ?>
                <script type="text/javascript">
                    window.location = "./";
                </script>
                <?
            }

        }
    }
}
else{
    //do nothing
    1;
}


$query_university= "SELECT university FROM `pssec_universities` where portion='$session_portion' and university!='' group by university"; 
$result_university = $con->query($query_university); 

            

?>
<!DOCTYPE html>
<html>

<head>
  <?include_once("./phpParts/header.php")?>
</head>

<body class="bg-default">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="./">
        <h3 style="font-size: 30px;color: white;"><img src="assets/img/uni_logo.png" style="max-height: 60px;padding:1px;" class="navbar-brand-img" alt="Logo"></h3>
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
         
         
         
        </ul>
        <hr class="d-lg-none" />
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9" style="padding-bottom:5rem!important;padding-top:8rem!important;">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Create an account</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
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
                      <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                    </div>
                    <input class="form-control" placeholder="First Name" type="text" required name="name">
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                    </div>
                    <input class="form-control" placeholder="Last Name" type="text" required name="lname">
                  </div>
                </div>
                
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
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-spaceship"></i></span>
                    </div>
                    <select name="role" class="form-control" id="exampleFormControlSelect1">
                      <option value="student">I am a Student</option>
                      <option value="teacher">I am a <?if($session_portion=="University"){echo "Professor";}else{echo "Teacher";}?></option>
                      <option value="uniadmin">I am an Admin</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-building"></i></span>
                    </div>
                    
                    
                     <input required placeholder="<?echo $session_portion?>" class="form-control" type="text" name="university" list="cityname">
                        <datalist id="cityname" >
                        <?if ($result_university->num_rows > 0)
                            { 
                                //successfull login
                                while($row = $result_university->fetch_assoc()) 
                                { ?>    
                                    <option value="<?echo $row['university']?>">
                             <?}
                             }
                             ?>
                        </datalist>
                        
                        
                    <!--
                    <select required placeholder="<?echo $session_portion?>" class="form-control" type="text" name="university">
                        <option value="">Select</option>
                        <?if ($result_university->num_rows > 0)
                            { 
                                //successfull login
                                while($row = $result_university->fetch_assoc()) 
                                { ?>    
                                    <option value="<?echo $row['university']?>"><?echo $row['university']?></option>
                             <?}
                             }
                             ?>
                    </select>
                    -->
                   
                  </div>
                </div>
                <p style="font-size:10px;font-style: italic;">If you can't find your institution listed, please type the name in the box and we will add it to our list.</p>
                
                <!--
                <div class="row my-4">
                  <div class="col-12">
                    <div class="custom-control custom-control-alternative custom-checkbox">
                      <input class="custom-control-input" id="customCheckRegister" type="checkbox" required>
                      <label class="custom-control-label" for="customCheckRegister">
                        <span class="text-muted">I agree with the <a href="#!">Privacy Policy</a></span>
                      </label>
                    </div>
                  </div>
                </div>
                -->
                
               
                
                <div class="text-center">
                  <input type="submit" class="btn btn-primary mt-4" value="Create account">
                </div>
                 <div class="text-center">
                    <br>
                    <a href="./login.php">Login</a> 
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