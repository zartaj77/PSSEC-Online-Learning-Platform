
<?if($session_bot=="" && $logged==1){?>


    <div class="row" style="margin-top:100px;margin-bottom:10px;justify-content: center;">
        
        
        <div class="row">
            <a href="?change-bot=bot1">
                <img style="height:100px;"src="./images/bot1.png" />
            </a>
            <a href="?change-bot=bot2">
                <img style="height:100px;"src="./images/bot2.png" />
            </a>
        </div>
        
        
        
        
    </div>
    <div class="row" style="margin-bottom:30px;justify-content: center;">
            <p>Select your Avatar</p>
        </div>
    
<?}?>


<div class="row">
              <div class="col-md-<?if($logged==1 && $session_role=='student'){echo 9;}else{echo 12;}?>">
              
                <div class="row" id="courses">
                  <script>
                    var courses_lst = [];
                    var courses_id_lst = [];
                    </script>
                  <?
                  if ($result_courses->num_rows > 0)
                    { 
                        $i = 0;
                        while($row = $result_courses->fetch_assoc()) 
                        { 
                  ?>
                  <script>courses_lst[<?echo $i?>] = "<?echo $row['title']?>"</script>
                  <script>courses_id_lst[<?echo $i?>] = "<?echo $row['id']?>"</script>
                <div class="col-xl-4 col-md-4 col-lg-4" id="<?echo $row['id']?>">
                  <div class="card" <?if($logged==1){?>style="cursor: pointer;" onclick="location.href = './courseContent.php?courseId=<?echo $row["id"]?>'" <?}?>>
                    <div class="card-body" style="padding:0px;border-radius:10px;">
                        <img style="width:100%;height:12rem;border-radius:10px;" src="./uploads/<?echo $row['cover']?>" alt="<?echo $row['title']?>" />
                    </div>
                    <div class="card-footer bg-transparent">
                      <div class="row align-items-center" style="padding:10px;">
                          
                         <div class="row">
                            <div class="col-md-10">
                              <h6 class="text-uppercase text-muted ls-1 mb-1">By: <?echo $row['name']?> - <?echo $row['university']?></h6>
                              <h5 class="h3 mb-0"><?echo $row['title']?></h5>
                            </div>
                            <?if($session_role=="student"){?>
                                <?if($row['isEnroll']==''){?>
                                    <div class="col-md-2" style="float:right;right:20px;">
                                        <a href="./courseContent.php?courseId=<?echo $row['id']?>&enroll=yes" class="btn btn-sm btn-primary">Enroll</a>
                                    </div>
                                <?}else{?>
                                    <div class="col-md-2" style="float:right;right:20px;">
                                        <a href="./courseContent.php?courseId=<?echo $row['id']?>" class="btn btn-sm btn-success">View</a>
                                    </div>
                                <?}?>
                            <?}if($logged==0){?>
                                <div class="col-md-2" style="float:right;right:20px;">
                                        <a href="./register.php" class="btn btn-sm btn-primary">Signin</a>
                                    </div>
                            <?}?>
                        </div>
                        
                        <div class="row" >
                            <div class="col-md-12">
                                <p style="color: #808080;font-size: 0.9rem;"><?echo $row['abstract']?></p>
                                </div>
                        </div>      
                      </div>
                    </div>
                  </div>
                </div>
                <?$i +=1;}}?>
    
              </div>
              
              
              </div>
              
              <?if($logged==1 && $session_role=='student'){?>
              <div class="col-md-3">
                  
                  
                  <div class="card">
                    <div class="card-header bg-transparent">
                      <div class="row align-items-center">
                        <div class="col">
                          <input style="margin:0px" type="text" name="topic" class="form-control" id="courseCode" placeholder="Type Course Code" >
                          <br>
                          <button class="btn btn-primary btn-block" onclick="viewCourse()">View</button>
                        </div>
                      </div>
                    </div>
                    <div >
                        
                       
                    </div>
                  </div>
                  
                  
                  <div class="card">
                    <div class="card-header bg-transparent">
                      <div class="row align-items-center">
                        <div class="col">
                          <h5 class="h3 mb-0">Upcoming Quizzes</h5>
                        </div>
                      </div>
                    </div>
                    <div >
                        <div class="table-responsive">
                      <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col" class="sort" data-sort="name">Topic</th>
                            <th scope="col" class="sort" data-sort="name">Deadline</th>
                          </tr>
                        </thead>
                        <tbody class="list">
                            <?
                            if ($result_upcommingQuizes->num_rows > 0)
                            { 
                                //successfull login
                                while($row = $result_upcommingQuizes->fetch_assoc()) 
                                { 
                            ?>
                          <tr>
                            <td scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <span class="name mb-0 text-sm"><?echo $row['title']?></span>
                                </div>
                              </div>
                            </td>
                            <td scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <span class="name mb-0 text-sm"><?echo $row['deadline']?></span>
                                </div>
                              </div>
                            </td>
                            
                            
                          </tr>
                          <?}
                          }?>
                          </tbody>
                      </table>
                    </div>
                       
                    </div>
                  </div>
                  
                  
                  <div class="card">
                    <div class="card-header bg-transparent">
                      <div class="row align-items-center">
                        <div class="col">
                          <h5 class="h3 mb-0">Quiz Feedback</h5>
                        </div>
                      </div>
                    </div>
                    <div >
                        <div class="table-responsive">
                      <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col" class="sort" data-sort="name">Topic</th>
                            <th scope="col" class="sort" data-sort="name">Marks</th>
                          </tr>
                        </thead>
                        <tbody class="list">
                            <?
                            if ($result_quizFeedback->num_rows > 0)
                            { 
                                //successfull login
                                while($row = $result_quizFeedback->fetch_assoc()) 
                                { 
                            ?>
                          <tr>
                            <td scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <span class="name mb-0 text-sm"><?echo $row['title']?></span>
                                </div>
                              </div>
                            </td>
                            <td scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <span class="name mb-0 text-sm"><?echo $row['scorePercent']*100?> %</span>
                                </div>
                              </div>
                            </td>
                            
                            
                          </tr>
                          <?}
                          }?>
                          </tbody>
                      </table>
                    </div>
                       
                    </div>
                  </div>
                  
                  
                  <div class="card">
                    <div class="card-header bg-transparent">
                      <div class="row align-items-center">
                        <div class="col">
                          <h5 class="h3 mb-0">List of Programs offered</h5>
                        </div>
                      </div>
                    </div>
                    <div >
                        <div class="table-responsive">
                      <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col" class="sort" data-sort="name">Topic</th>
                            <th scope="col" class="sort" data-sort="name">View</th>
                          </tr>
                        </thead>
                        <tbody class="list">
                            <?
                            if ($result_notEnrolled->num_rows > 0)
                            { 
                                //successfull login
                                while($row = $result_notEnrolled->fetch_assoc()) 
                                { 
                            ?>
                          <tr>
                            <td scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <span class="name mb-0 text-sm"><?echo $row['title']?></span>
                                </div>
                              </div>
                            </td>
                            <td scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <a href="./courseContent.php?courseId=<?echo $row['id']?>" class="btn btn-sm btn-primary">View</a>
                                </div>
                              </div>
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
              <?}?>
          </div>
          
          <script>
              function viewCourse(){
                  window.location= "courseContent.php?courseId="+$('#courseCode').val()
              }
          </script>