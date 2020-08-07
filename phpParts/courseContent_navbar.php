<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main" style="z-index:1;" >
    <div class="scrollbar-inner" style="padding-left: 50px !important;">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="./" style="color: #5e72e4;font-weight: bold;font-size: 250%;top: -11px;position: relative;">
            
          <img src="assets/img/uni_logo.png" style="max-height: 60px;background-color: #d4daff;border-radius: 1000px;padding:10px;" class="navbar-brand-img" alt="Logo">
          
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link"  href="./courseContent.php?courseId=<?echo $_GET['courseId']?>">
                <i class="ni ni-world text-primary"></i>
                <span class="nav-link-text">Course</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="./courseContent_announcements.php?courseId=<?echo $_GET['courseId']?>">
                <i class="ni ni-bell-55 text-primary"></i>
                <span class="nav-link-text">Announcements</span>
              </a>
            </li>
            <?if($session_role=="student"){?>
                <li class="nav-item">
                  <a class="nav-link"  href="./courseContent_grades.php?courseId=<?echo $_GET['courseId']?>">
                    <i class="ni ni-chart-bar-32 text-primary"></i>
                    <span class="nav-link-text">Grades</span>
                  </a>
                </li>
            <?}?>
            <li class="nav-item">
              <a class="nav-link"  href="./courseContent_resources.php?courseId=<?echo $_GET['courseId']?>">
                <i class="ni ni-archive-2 text-primary"></i>
                <span class="nav-link-text">Resources</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="./courseContent_assessments.php?courseId=<?echo $_GET['courseId']?>">
                <i class="ni ni-check-bold text-primary"></i>
                <span class="nav-link-text">Assessments</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="./courseContent_roster.php?courseId=<?echo $_GET['courseId']?>">
                <i class="ni ni-single-02 text-primary"></i>
                <span class="nav-link-text">Roster</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="./courseContent_chatbot_responses.php?courseId=<?echo $_GET['courseId']?>">
                <i class="ni ni-send text-primary"></i>
                <span class="nav-link-text">Chatbot</span>
              </a>
            </li>
            
          </ul>
          
        </div>
      </div>
    </div>
  </nav>