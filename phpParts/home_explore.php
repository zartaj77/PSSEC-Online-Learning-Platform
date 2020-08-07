<div class="row">
  <div class="col-md-12">
      
      <div class="card" style="margin-top:50px;">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0"><?if($session_portion=="University"){echo "Departments";}else{echo "Courses";}?></h3>
        </div>
        <!--
        <div class="col text-right">
          <a href="#!" class="btn btn-sm btn-primary">See all</a>
        </div>
        -->
      </div>
    </div>
    <div class="table-responsive">
      <!-- Projects table -->
      <table class="table align-items-center table-flush">
        <thead class="thead-light">
          <tr>
            <th scope="col"><?if($session_portion=="University"){echo "Departments";}else{echo "Courses";}?></th>
            <th scope="col" style="width:10px;">Explore</th>
          </tr>
        </thead>
        <tbody>
            <script>
    var departments_lst = [];
    var departments_id_lst = [];
    </script>
            <?if ($result_departments->num_rows > 0)
                    { 
                        //successfull login
                        $i = 0;
                        while($row = $result_departments->fetch_assoc()) 
                        { ?> 
                         <script>departments_lst[<?echo $i?>] = "<?if($session_portion=="University"){echo $row['depName'];}else{echo $row['title'];}?>"</script>
                         <script>departments_id_lst[<?echo $i?>] = "<?echo $row['id']?>"</script>
          <tr id="<?echo $row['id']?>">
             
            <th scope="row">
                <?if($session_portion=="University"){echo $row['depName'];}else{echo $row['title'];}?>
            </th>
            <td>
                 <a href="./?department=<?echo $row['id']?>"class="btn btn-primary btn-sm" >Explore</a>
            </td>
           
          </tr> 
          
          <?$i +=1;}}?>
        </tbody>
      </table>
    </div>
  </div>
  
  </div>
</div>
