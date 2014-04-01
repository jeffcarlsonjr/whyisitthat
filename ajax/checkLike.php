<?php

include '../functions/globalClass.php';


$IP =  $_SESSION['IP'];
$id = $_GET['id'];

$query = 'SELECT like_id, active FROM wiit_likes WHERE comment_id = "'.$id.'" AND ipAddress = "'.$IP.'"  ';

$result = mysql_query($query);
$row = mysql_fetch_assoc($result);

if(!empty($row['like_id']) && $row['active'] === 'yes')
{
    $response = array('data' => 'yes');
   
}
else
{
    $response = array('data' => 'no');
 
}

  echo json_encode($response);