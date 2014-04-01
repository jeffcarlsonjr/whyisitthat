<?php

include '../functions/globalClass.php';

$id = $_GET['id'];
$date = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];

$clearQuery = "SELECT like_id, active FROM wiit_likes WHERE ipAddress = '".$ip."' AND comment_id = '".$id."' ";
$result = mysql_query($clearQuery);
$row = mysql_fetch_assoc($result);

if($row['like_id'] === $row['like_id'] && $row['active'] === 'no') {
    
    
    mysql_query("UPDATE wiit_likes SET active = 'yes' WHERE like_id = '".$row['like_id']."'") ;
 
   
    $query = mysql_query('SELECT * FROM wiit_likes WHERE comment_id = "'.$id.'" && active = "yes" ');
        $i = 0;
        while($row = mysql_fetch_assoc($query)){$i++;
        if(!empty($row['like_id'])){
            
            $result = $i;
            
            }
        }
       
        echo json_encode(array(
            'count' => $result
        ));
}

elseif(empty($row['like_id']))
{
    mysql_query("INSERT INTO wiit_likes (comment_id,ipAddress, dateLiked,active) VALUES ('".$id."','".$ip."','".$date."','yes')");
   
   $query = mysql_query('SELECT * FROM wiit_likes WHERE comment_id = "'.$id.'" &&  active = "yes" ');
        $i = 0;
        while($row = mysql_fetch_assoc($query)){$i++;
        if(!empty($row['like_id'])){
            
            $result = $i;
            
            }
        }
       
        echo json_encode(array(
            'count' => $result
        ));
}


else{
    
}




