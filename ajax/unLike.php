<?php
include '../functions/globalClass.php';

$id = $_GET['id'];
$ip = $_SERVER['REMOTE_ADDR'];

$query = mysql_query("SELECT like_id FROM wiit_likes WHERE comment_id = '".$id."' AND ipAddress = '".$ip."' " );

$row = mysql_fetch_assoc($query);

mysql_query('UPDATE wiit_likes SET active = "no" WHERE like_id = "'.$row['like_id'].'"');


$query1 = mysql_query('SELECT * FROM wiit_likes WHERE comment_id = "'.$id.'"  AND active = "yes" ');
        $i = 0;
        while($row = mysql_fetch_assoc($query1)){$i++;
        if(!empty($row['like_id'])){
            
            $result = $i;
            
            }
        }
       
        echo json_encode(array(
            'count' => $result
        ));