<?php

$host='localhost';
$username='moinengi_pssec';
$user_pass='rWg#M$vFYk]+';
$database_in_use='moinengi_pssec';

$con = mysqli_connect($host,$username,$user_pass,$database_in_use);
if (!$con)
{
    echo"not connected";
}
if (!mysqli_select_db($con,$database_in_use))
{
    echo"database not selected";
}
?>