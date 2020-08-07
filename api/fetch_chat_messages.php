<?
require "./../database.php";
$toUser = $_GET['toUser'];
$fromUser = $_GET['fromUser'];

$query_posts= "select * from pssec_messages m  where m.toUser in ('$toUser', '$fromUser') and m.fromUser in ('$toUser', '$fromUser') order by m.id asc"; 
$result_posts = $con->query($query_posts); 


$posts_arr = array();
if ($result_posts->num_rows > 0)
{ 
    //add 
    while($row = $result_posts->fetch_assoc()) 
    { 
        $post_item = array(
        'message' => $row['message'],
        'status' => $row['status'],
        'message' => $row['message'],
        'senderId' => $row['fromUser'],
      );

      // Push to "data"
      array_push($posts_arr, $post_item);
    }
}

echo json_encode($posts_arr);



?>