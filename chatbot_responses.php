<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacher.php");


if(isset($_GET['del'])){

    $response = $_GET['del'];

    //change picture
    $sql="delete from pssec_bot_responses where id='$response'";
                if(!mysqli_query($con,$sql)){echo "err2";} 
                
}



if(isset($_POST['response'])){

    $response = $_POST['response'];
    $question = $_POST['question'];
    $timeAdded = time();
    
    //change picture
    $sql="insert into pssec_bot_responses(`question`, `answer`, `timeAdded`, `userId`) values ('$question', '$response','$timeAdded', '$session_id')";
                if(!mysqli_query($con,$sql)){echo "err2";} 
                
}


$query_topics= "select * from pssec_bot_responses t where t.userId='$session_id' order by t.timeAdded desc "; 
        $result_topics = $con->query($query_topics); 
        
        
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
    <form method="post" action="">
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Chatbot Responses</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item active" aria-current="page">Chatbot Responses</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
            <div class="col-lg-12 text-right">
                  
                
                <div class="row">
                    <div class="col-md-4">
                        <input style="margin:0px 15px;" type="text" name="question" class="form-control" id="exampleFormControlInput1" placeholder="Add new Question" required>
                    </div>
                    <div class="col-md-4">
                        <input style="margin:0px 15px;" type="text" name="response" class="form-control" id="exampleFormControlInput1" placeholder="Add Response" required>
                    </div>
                    <div class="col-md-4">
                        <input type="submit" value="Add new Response" class="btn btn-md btn-neutral" />
                    </div>
                </div>
                </div>
                
                  
            <?}?>
            
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
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Possible Responses</h6>
                  <h5 class="h3 mb-0">Responses</h5>
                </div>
              </div>
            </div>
            <div >
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Question</th>
                    <th scope="col" class="sort" data-sort="name">Response</th>
                    <th scope="col" class="sort" data-sort="name">Action</th>
                  </tr>
                </thead>
                <tbody class="list">
                    <?
                    
                    if ($result_topics->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_topics->fetch_assoc()) 
                        { 
                    ?>
                  <tr>
                      <td scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm"><?echo $row['question']?></span>
                        </div>
                      </div>
                    </td>
                    <td scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm"><?echo $row['answer']?></span>
                        </div>
                      </div>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="?del=<?echo $row['id']?>">Delete</a>
                    </td>
                  </tr>
                  <?}
                  }?>
                  </tbody>
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
