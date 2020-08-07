<?
$filenameLink = basename($_SERVER['PHP_SELF']);

if($filenameLink=="courseContent.php" || $filenameLink=="courseContent_announcements.php" || $filenameLink=="courseContent_grades.php" || $filenameLink=="courseContent_resources.php" || $filenameLink=="courseContent_assessments.php" || $filenameLink=="courseContent_roster.php" || $filenameLink=="courseContent_chatbot_responses.php")
$showSmallMenu = true;
?>
<style>
.nav-link-text{
    white-space: nowrap;
    }
</style>
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main" <?if($showSmallMenu){?>style="width: 55px;"<?}?>>
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="./" style="color: #5e72e4;font-weight: bold;font-size: 250%;top: -11px;position: relative;">
            
          <img src="assets/img/uni_logo.png" style="max-height: 60px;max-width: 60px;background-color: #d4daff;border-radius: 1000px;padding:10px;" class="navbar-brand-img" alt="Logo">
          
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            
            <?if($session_role!='uniadmin'){?>
            <li class="nav-item">
              <a class="nav-link <?if($filenameLink==''||$filenameLink=='index.php'){echo 'active';}?>" href="./">
                <i class="ni ni-diamond text-primary"></i>
                <span class="nav-link-text">Home</span>
              </a>
            </li>
            <?}?>
            
            <?if($logged==1){?>
            
                <?if($session_role=='uniadmin' && $session_uniadminHasPermission=="yes"){?>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='uniadmin_gradescale.php'){echo 'active';}?>" href="./uniadmin_gradescale.php?uni=<?echo $session_university?>">
                    <i class="ni ni-tv-2 text-primary"></i>
                    <span class="nav-link-text">Grade Scale</span>
                  </a>
                </li>
                <?}?>
                
                
                
                
                
                 <?if($session_role!='uniadmin'){?>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='myCourses.php'){echo 'active';}?>" href="./myCourses.php">
                    <i class="ni ni-basket text-primary"></i>
                    <span class="nav-link-text">My Courses</span>
                  </a>
                </li>
                <?}?>
                
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='myMessages.php'){echo 'active';}?>" href="./myMessages.php">
                    <i class="ni ni-archive-2 text-primary"></i>
                    <span class="nav-link-text">My Messages</span>
                  </a>
                </li>
                
                <?if($session_role=='student'){?>
                    <li class="nav-item">
                      <a class="nav-link <?if($filenameLink=='myQuizzes.php'){echo 'active';}?>" href="./myQuizzes.php">
                        <i class="ni ni-chart-pie-35 text-primary"></i>
                        <span class="nav-link-text">My Quizzes</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link <?if($filenameLink=='calendar.php'){echo 'active';}?>" href="./calendar.php">
                        <i class="ni ni-calendar-grid-58 text-primary"></i>
                        <span class="nav-link-text">Calendar</span>
                      </a>
                    </li>
                <?}?>
                <?if($session_role=='teacheraaa'){?>
                    <li class="nav-item">
                      <a class="nav-link <?if($filenameLink=='myQuizzes_teacher.php'){echo 'active';}?>" href="./myQuizzes_teacher.php">
                        <i class="ni ni-chart-pie-35 text-primary"></i>
                        <span class="nav-link-text">My Quizzes</span>
                      </a>
                    </li>
                <?}?>
            <?}?>
            <!--
            <li class="nav-item">
              <a class="nav-link <?if($filenameLink=='settings.php'){echo 'active';}?>" href="./settings.php">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Settings</span>
              </a>
            </li>
            -->
            
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
                  <a class="nav-link <?if($filenameLink=='admin_students.php'){echo 'active';}?>" href="./admin_students.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">Students</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='admin_teachers.php'){echo 'active';}?>" href="./admin_teachers.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">Teachers</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='admin_courses.php'){echo 'active';}?>" href="./admin_courses.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">Courses</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='admin_unis.php'){echo 'active';}?>" href="./admin_unis.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">Universities</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='admin_schools.php'){echo 'active';}?>" href="./admin_schools.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">Schools</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='admin_uniadmins.php'){echo 'active';}?>" href="./admin_uniadmins.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">University Admins</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='admin_schooladmins.php'){echo 'active';}?>" href="./admin_schooladmins.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">School Admins</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='admin_sendNotfs.php'){echo 'active';}?>" href="./admin_sendNotfs.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">Send Notifications</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?if($filenameLink=='chatbot_responses.php'){echo 'active';}?>" href="./chatbot_responses.php">
                    <i class="ni ni-spaceship"></i>
                    <span class="nav-link-text">Chat bot Responses</span>
                  </a>
                </li>
              </ul>
          <?}?>
          
          
        </div>
      </div>
    </div>
  </nav>