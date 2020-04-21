<?
$filenameLink = basename($_SERVER['PHP_SELF']);
?>
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?if($filenameLink==''||$filenameLink=='index.php'){echo 'active';}?>" href="./">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Courses</span>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link <?if($filenameLink=='myCourses.php'){echo 'active';}?>" href="./myCourses.php">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">My Courses</span>
              </a>
            </li>
            
          </ul>
          <!-- Divider -->
          
          <?if ($session_role=="admin"){?>
              <hr class="my-3">
              <!-- Heading -->
              <h6 class="navbar-heading p-0 text-muted">
                <span class="docs-normal">Admin Control</span>
              </h6>
              <!-- Navigation -->
              <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                  <a class="nav-link" href="./admin_students.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">Students</span>
                  </a>
                </li>
              </ul>
          <?}?>
          
          
        </div>
      </div>
    </div>
  </nav>