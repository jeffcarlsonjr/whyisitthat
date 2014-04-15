<?php

include '../functions/globalClass.php';

$users = new usersClass();
$comment = new commentsClass();
$items_per_group = 7;
//sanitize post value
$group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

//throw HTTP error if group number is not valid
//if(!is_numeric($group_number)){
//    header('HTTP/1.1 500 Invalid number!');
//    exit();
//}

//get current starting point of records
$position = ($group_number * $items_per_group);

//Limit our results within a specified range. 
$results = mysql_query( "SELECT id, comment, user_id FROM wiit_comments ORDER BY id DESC LIMIT $position, $items_per_group");

//echo $results;

if ($results) { 
    //output results from database
    
    while($obj = mysql_fetch_assoc($results))
    {
        $comments = stripslashes($obj['comment']);
            
            echo "<div class='commentsRow'>";
            echo "<div class='col-lg-12 col-md-12 col-sm-12'> ";
            echo "<div class='col-lg-2 col-md-2 col-sm-2' logo>";
            echo "<img src='./images/smWiitLogo.png'/>";
            echo "</div>";
            echo "<div class='col-lg-10 col-md-10 col-sm-10 commentbox'>";
            echo "<div class='userName'>".$users->displayUsersName($obj['user_id'])." had to say:</div>";
            echo "<div class='comment'>".$comments."</div>";
            echo "<div id='likeBox' class='likeBox' data-like-id='".$obj['id']."'>Kudos</div>";
            echo "<div class='likeCount' id='likeCount' data-like-count='".$obj['id']."'>".$comment->commmentCount($obj['id'])."</div>" ;
            echo "<script>likes(".$obj['id'].")</script>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
    }

}
unset($obj);



