<?php

session_start();

include 'connect.php';
include 'crudClass.php';
include 'usersClass.php';
include 'commentsClass.php';
include 'twitter/twitteroauth.php';

$connect = new connect('localhost', 'root', 'root', 'whyisitthat');

//$connect = new connect('68.178.216.148', 'wiit', 'Date03212014%', 'wiit');
$connect->myconnect();


$consumerKey ="Z8oclwbMju2hhGZljkL9gg";
$consumerSecret="dmKuxIPu8U7KJyIKJRON4d4TBqx5FLwjLXTVRRYBfw";

$OAuthToken ="2401358827-oQNqh3fEFDIjrSX4YWp0P1mIaS3hYChDvXfCflP";
$OAuthSecret="aShCBEka1Mc5RvkK0Wp3UxpFqwBKycBuoJeatYNurlmQX";

$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $OAuthToken, $OAuthSecret);