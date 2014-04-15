<?php
 include '../functions/globalClass.php'; 
 
$comment = new commentsClass();
$user = new usersClass();

// Gather information for user upload
    $json = file_get_contents("php://input");
    $jsonData = json_decode($json, true);


    $usersName = cleanInput($jsonData['username']);
    $userEmail = cleanInput($jsonData['email']);
  
    $date = date('Y-m-d H:i:s');
// Set as data for class    
    $dataUser['username'] = "'$usersName'";
    $dataUser['email'] = "'$userEmail'";
    $dataUser['dateCreate'] = "'$date'";
//Create id from the function to run through comment function    
    
    
    $id = $user->checkUsers($dataUser, 'wiit_user');
    
    $user_id = $_SESSION['user_id'];
 
    $comments = cleanInput($jsonData['comment']);
    //just in case, any bad language is cleaned up with a little function cleanText()
    $cleanComment = $comment->cleanText($comments);
    
    $data['comment'] = "'$cleanComment'";
    $data['active'] = "1";
    $data['user_id'] = "'$user_id'";
    $data['dateCreated'] = "'$date'";
    
    $comment->createComment($data,'wiit_comments');
   


    $message = stripcslashes($cleanComment);
    $messages = str_replace('"\"', '', $message);
    $message = $message." #whyisitthatthis";
    //message cleaned up and set to twitter
    //$tweet->post('statuses/update', array('status' => "$message"));


