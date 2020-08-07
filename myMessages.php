<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");


$query_courses= "select m.message, u.id as userId, u.name, fromUser from pssec_messages m INNER join pssec_users u on m.fromUser=u.id where m.toUser='$session_id' GROUP by fromUser order by m.timeAdded desc "; 

 $result_courses = $con->query($query_courses); 


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
              <h6 class="h2 text-white d-inline-block mb-0"><?echo $courseTitle?></h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item"><a href="./">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">My Messages</li>
                  
                </ol>
              </nav>
            </div>
            
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
                  <h6 class="text-uppercase text-muted ls-1 mb-1">My Messages</h6>
                  <h5 class="h3 mb-0">My Messages</h5>
                </div>
              </div>
            </div>
            <div >
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">User</th>
                    <th scope="col" class="sort" style="width:<?if($session_role=="student"){echo "10";}else{echo "20";}?>%;">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                    <?
                    if ($result_courses->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_courses->fetch_assoc()) 
                        { 
                    ?>
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm"><?echo $row['name']?></span>
                        </div>
                      </div>
                    </th>
                    <td>
                        <a class="btn btn-primary" href="./message.php?id=<?echo $row['fromUser']?>">View</a>
                        
                    </td>
                  </tr>
                  <?}
                  }?>
                  
              </table>
            </div>
               
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
