<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminTeacherStudent.php");

$userId = $_GET['id'];
$query = "SELECT * FROM pssec_users WHERE id='$userId'";
$result = $con->query($query);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) 
    {
   
    $name = $row['name'];
    
    }
}

$userId = $_GET["id"];
$testI = 0;
if(isset($_POST["new_message"]))
{
    $new_message = $_POST["new_message"];
    $userId = $_POST["userId"];
    $new_message = htmlspecialchars($new_message);
    $timeAdded = time();
    $testI  = $testI + 1;
    
    $sql="insert into pssec_messages set toUser='$userId', fromUser='$session_id', timeAdded='$timeAdded', message='$new_message'";
    if(!mysqli_query($con,$sql))
    {
        echo "err1";
    }else{
         $sql="insert into pssec_notifications(`studentId`, `content`, `timeAdded`, `url`) values ('$userId', 'Message: $new_message', '$timeAdded', './message.php?id=$userId')";
                if(!mysqli_query($con,$sql)){echo "err2";} 
    }
            
}




$query_posts= "select * from pssec_messages m  where m.toUser in ('$userId', '$session_id') and m.fromUser in ('$userId', '$session_id') order by m.id asc"; 
$result_posts = $con->query($query_posts); 


?>
<!DOCTYPE html>
<html>

<head>
  <?include_once("./phpParts/header.php")?>
</head>

<body onload="getLiveUpdates()">
   
  <!-- Sidenav -->
  <?include_once("./phpParts/sidenav.php")?>
  <!-- Main content -->
  <div class="main-content" id="panel" >
    <!-- Topnav -->
    <?include_once("./phpParts/topnav.php")?>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0"><?echo $courseTitle?></h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item"><a href="./">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Inbox</li>
                  
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
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Inbox</h6>
                  <h5 class="h3 mb-0"><?echo $name?></h5>
                </div>
              </div>
            </div>
            <div >
                <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">User</th>
                  </tr>
                </thead>
                <tbody class="list" id="my_messages">
                    <?
                    if ($result_posts->num_rows > 0)
                    { 
                        //successfull login
                        while($row = $result_posts->fetch_assoc()) 
                        { 
                    ?>
                  <tr>
                    <td scope="row">
                      <div class="media align-items-center">
                        <div class="media-body">
                          <span class="name mb-0 text-sm" style="<?if($row['fromUser']==$session_id){echo "float:right; font-weight:bold;";}?>"><?echo $row['message'];?></span>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?}
                  }?>
                  
              </table>
              
              <form method="get" id="message_box" class="message-input" enctype="multipart/form-data" style="margin:10px;">
						
								<div class="form-group is-empty">
									<textarea name="new_message" required class="form-control" placeholder="Write your message here..." id="comment"></textarea>
									<input name="userId" value="<?echo $_GET['id']?>" hidden>
								<span class="material-input"></span></div>
						
								<div class="add-options-message" style="padding:10px;">
									
									<button type="submit" class="btn btn-primary btn-lg">Send Message</button>
								</div>
						
							</form>
              
              
            </div>
               
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?include_once("./phpParts/footer.php")?>
    </div>
  </div>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
  
  
  
      
<script>
      $(function () {
        $('form').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: 'message.php',
            data: $('form').serialize(),
            success: function () {
                //$('#comment').val('');
            }
          });
        var a=$("#comment").val();
        if (a!=''){
            
			var txt1 = '<tr><td scope="row"><div class="media align-items-center"><div class="media-body"><span class="name mb-0 text-sm" style="float:right; font-weight:bold;">'+a+'</span></div></div></td></tr>';
            $("#my_messages").append(txt1);     // Append new elements
            $('#my_messages').scrollTop($('#my_messages')[0].scrollHeight);

        }
          $('#comment').val('');
          
        });
      });
</script>
      
      
      
<script>

function getLiveUpdates() {
      setInterval(function(){ getFromServer(); }, 5000);
    }
    
    var pData;
    
    function getFromServer(){
        var InitiateGetTransactions = function(textIdInp, callback) // How can I use this callback?
         {
             var request = new XMLHttpRequest();
             request.onreadystatechange = function()
             {
                 if (request.readyState == 4 && request.status == 200)
                 {
                     callback(request.responseText); // Another callback here
                 }
                 if (request.readyState == 4 && request.status == 0)
                 {
                     console.log("no response for ") // Another callback here
                 }
             }; 
             request.open("POST", "./api/fetch_chat_messages.php?toUser=<?echo $userId ?>&fromUser=<?echo $session_id?>");
             request.send();
         }
         
         var _this = this;
         var frameTransactions = function mycallback(data) {
           var dataParsed
           dataParsed = JSON.parse(data);
           if(dataParsed.message=="none"){
             console.log("no transactions")
           }
           else{
             var sampleTrans = dataParsed
               //console.log(sampleTrans)
              if(JSON.stringify(pData)!=JSON.stringify(sampleTrans)){
                  //add to local storage
                  pData = sampleTrans
                  setupTable(sampleTrans)
                console.log(" storage updated", sampleTrans)
              }
              
           }
         }
         InitiateGetTransactions(1, frameTransactions); //passing mycallback as a method 
      }
      
      function setupTable(pData){
          //var a=$("#new_comment").val();
          $("#my_messages").empty()
            if (true){
                for (var i=0; i<pData.length; i++){
                    var timeAdded = pData[i].timeAdded;
                    var message = pData[i].message;
                    var senderId = pData[i].senderId;
                    var messageId = pData[i].messageId;
                    
                    var delCode = ""
                    if(senderId=="<?echo $session_id?>"){
                        var delCode = 'float:right; font-weight:bold;';
                    }
                    
                    
                    var txt1 = '<tr><td scope="row"><div class="media align-items-center"><div class="media-body"><span class="name mb-0 text-sm" style="'+delCode+'">'+message+'</span></div></div></td></tr>';
                    $("#my_messages").append(txt1);     // Append new elements
                }
            }
      }
</script>
                    
                    
                    
</body>

</html>
