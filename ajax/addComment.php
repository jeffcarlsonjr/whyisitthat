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
    $cleanComment = $comment->cleanText($comments);
    
    $data['comment'] = "'$cleanComment'";
    $data['active'] = "1";
    $data['user_id'] = "'$user_id'";
    $data['dateCreated'] = "'$date'";
    
    $comment->createComment($data,'wiit_comments');
    

//    $message = stripcslashes($cleanComment);
//    $messages = str_replace('"\"', '', $message);
//    $tweet->post('statuses/update', array('status' => "$message"));
    
    echo "<meta http-equiv='refresh' content='0;url=../index.php'>";

    
 
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

