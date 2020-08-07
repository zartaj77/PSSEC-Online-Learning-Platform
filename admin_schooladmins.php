<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdmin.php");


if(isset($_GET['uni'])){
    $id = $_GET['uni'];
    $sql="update pssec_users set uniadminHasPermission='yes' where id='$id'";
                if(!mysqli_query($con,$sql)){echo "err2";} 
}


$query_universities= "select * from pssec_users where role='uniadmin' and portion='School/College'"; 
    $result_universities = $con->query($query_universities); 
    
givePoints($con, "University Admins", $session_id, '10');





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
                  
                 
                  <li class="breadcrumb-item"><a href="./">University Admins</a></li>
                  <li class="breadcrumb-item active" aria-current="page">University Admins</li>
                  
                </ol>
              </nav>
            </div>
            <!--
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <a href="./newUniversity.php" class="btn btn-md btn-neutral">Add New University</a>
                </div>
            <?}?>
            -->

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
                  <h6 class="text-uppercase text-muted ls-1 mb-1">University Admins</h6>
                  <h5 class="h3 mb-0">University Admins </h5>
                </div>
              </div>
            </div>
            <div >
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">University</th>
                    <th scope="col" class="sort" data-sort="name">Email</th>
                    <th scope="col" class="sort" style="width:10%;">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                    <?
                    if ($result_universities->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_universities->fetch_assoc()) 
                        { 
                    ?>
                  <tr>
                    <th scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm"><?echo $row['university']?></span>
                        </div>
                      </div>
                    </th>
                   
                    <td scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm"><?echo $row['email']?></span>
                        </div>
                      </div>
                    </td>
                    
                    <td scope="row">
                    <?if($row['uniadminHasPermission']==''){?>
                        
                             <a class="btn btn-success btn-sm" href="?uni=<?echo $row['id']?>">Grant Permission to Grade Scale</a>
                        
                    <?}?>
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
