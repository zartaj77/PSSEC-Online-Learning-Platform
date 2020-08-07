<?
$filenameLink = basename($_SERVER['PHP_SELF']);


if(isset($_GET['mark-as-read'])){
    $sql="update pssec_notifications set isRead='1' where studentId='$session_id'";
    if(!mysqli_query($con,$sql)){echo "err2";} 
}

$query_notfs = "SELECT * FROM pssec_notifications WHERE studentId='$session_id' AND isRead='0' order by id desc";
$result_notf = $con->query($query_notfs);

?>
<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
          <?if($filenameLink==''||$filenameLink=='index.php'){?>
          <!--
              <div class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                <div class="form-group mb-0">
                  <div class="input-group input-group-alternative input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" id="searchQuery" onkeyup="searchQuery()" placeholder="Search" type="text">
                  </div>
                </div>
                <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              -->
          <?}?>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>
            <?if($session_name!=""){?>
                <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
                <?if($result_notf->num_rows >0){?>
                <span class="badge badge-sm badge-circle badge-floating badge-primary border-white" style="height:1.0rem;width:1.0rem;"><?echo $result_notf->num_rows ?></span>
                <?}?>
              </a>
              <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                
                <!-- List group -->
                <div class="list-group list-group-flush">
                    
                <?
                if ($result_notf->num_rows > 0){
                    while($row = $result_notf->fetch_assoc()) 
                    {
                    ?>
                          <a href="<?echo $row['url']?>" class="list-group-item list-group-item-action">
                            <div class="row align-items-center">
                              <div class="col-auto">
                                <!-- Avatar -->
                                <img alt="Image placeholder" src="https://upload.wikimedia.org/wikipedia/commons/e/e4/Color-blue.JPG" class="avatar rounded-circle">
                              </div>
                              <div class="col ml--2">
                                <p class="text-sm mb-0"><?echo $row['content']?></p>
                              </div>
                            </div>
                          </a>
                  <?
                    }
                }
                  ?>
                  
                </div>
                <!-- View all -->
                <?if ($result_notf->num_rows > 0){?>
                <a href="?mark-as-read=1" class="dropdown-item text-center text-primary font-weight-bold py-3">Mark all as Read</a>
                <?}?>
              </div>
            </li>
            <?}?>
          </ul>
          <?if($session_portion!="" && $logged==0){?>
          <a href="./?switch-experience=1" class="badge badge-primary" style="margin-right:40px;">Switch Experience</a>
          <?}?>
          
          <?if($logged==1){?>
          <span class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" title="Increase your activity to level up. 
          &#10;
          CURRENT POINTS = <?echo $session_score?>">LEVEL <?echo $session_level?></span>
          <?}?>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 " >
              
             
            <?if($session_portion!='' || $logged==1){?> 
          
            <li class="nav-item dropdown">
            <?if($session_name=="")
            {?>
            
                <a class="btn btn-default" href="./login.php">Login</a>
                <a class="btn btn-success" href="./register.php">Register</a>
              
              
              <?}else
              {?>
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="assets/img/theme/user-img.png">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?echo $session_name?></span>
                  </div>
                </div>
              </a>
              <?}?>
              
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <!--
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                -->
                <div class="dropdown-divider"></div>
                <a href="./?logout=1" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
            
            <?}?>
            
            
            
          </ul>
        </div>
      </div>
    </nav>