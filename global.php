<?
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);
ini_set('session.save_path', '/tmp');

session_start();
include_once("database.php");

//
$session_portion = $_SESSION['portion'];


if (isset($_SESSION['email'])&&isset($_SESSION['password']))
{
        $session_password = $_SESSION['password'];
        $session_email =  $_SESSION['email'];
        $query = "SELECT *  FROM pssec_users WHERE email='$session_email' AND password='$session_password'";
}
$result = $con->query($query);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) 
    {
    $logged=1;
    $session_role = $row['role'];
    $session_id = $row['id'];
    $session_name = $row['name'];
    $session_email = $row['email'];
    $session_level = $row['level'];
    $session_score = $row['score'];
    $session_university = $row['university'];
    $session_semester = $row['semester'];
    $session_studentId = $row['studentId'];
    $session_portion = $row['portion'];
    $session_uniadminHasPermission = $row['uniadminHasPermission'];
    $session_bot = $row['bot'];
    
    
    $_SESSION['score'] = $session_score;
    }
}
else
{
        $logged=0;
}

function mb_htmlentities($string, $hex = true, $encoding = 'UTF-8') {
    global $con;
    return mysqli_real_escape_string($con, $string);
    /**
    return preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) use ($hex) {
        return (sprintf($hex ? '&#x%X;' : '&#%d;', mb_ord($match[0])));
    }, $string);
    **/

}


function generateRandomString($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function givePoints($con, $task, $studentId, $score){
    $timeAdded = time();
    $task .= "-".$studentId;
    $sql="insert into pssec_scores(`title`, `studentId`, `points`, `timeAdded`) values ('$task', '$studentId', '$score', '$timeAdded')";
    if(!mysqli_query($con,$sql))
    {
        //echo "err1";
    }else{
        $sql="update pssec_users set score=score+'$score' where id='$studentId'";
        if(!mysqli_query($con,$sql))
        {
            echo "err2";
        } 
    }   
    
    $level  = 1;
    $session_score = $_SESSION['score'];
    $level = floor($session_score/100);
    
    $sql="update pssec_users set level='$level' where id='$studentId'";
    if(!mysqli_query($con,$sql))
    {
        echo "err2";
    } 
        
}

if($logged==1){
    givePoints($con, "log ".date("d-m-y-h-a"), $session_id, '10');
}


        
        
?>