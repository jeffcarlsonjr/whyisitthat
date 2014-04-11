<?php 
include "./functions/globalClass.php";
$items_per_group = 6;


$results = mysql_query("SELECT COUNT(id) as t_records FROM wiit_comments");
$total_records = mysql_fetch_assoc($results);
$total_groups = ceil($total_records['t_records']/$items_per_group);
$_SESSION['IP'] = filter_input(INPUT_SERVER,'REMOTE_ADDR');

$comment = new commentsClass();
$user = new usersClass();



if(isset($_POST['addComment'])){
    $usersName = cleanInput($_POST['username']);
    $userEmail = cleanInput($_POST['email']);
    $date = date('Y-m-d H:i:s');
    
    $dataUser['username'] = "'$usersName'";
    $dataUser['email'] = "'$userEmail'";
    $dataUser['dateCreate'] = "'$date'";
    
    $id = $user->createUsers($dataUser,'wiit_user');
    $user_id = $_SESSION['user_id'];
    
    $comments = cleanInput($_POST['comment']);
    $data['comment'] = "'$comments'";
    $data['active'] = "1";
    $data['user_id'] = "'$user_id'";
    $data['dateCreated'] = "'$date'";
    $comment->createComment($data,'wiit_comments');
}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html ng-app="validationApp">
    <head>
        <meta charset="UTF-8">
        <title>Scrolling</title>
        <link href="./css/bootstrap.css" rel="stylesheet"/>
        <link href="./css/stylesheet.css" rel="stylesheet" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
        <script src="./lib/angular/angular.js"></script>
        <script src="./lib/angular/angular-route.js"></script>
        <script src="./js/javascript.js"></script>
        <script src="./js/app.js"></script>
        
    </head>
    <body>
<script>
            $(document).ready(function() {
                
                var track_load = 0; //total loaded record group(s)
                var loading  = false; //to prevents multipal ajax loads
                var total_groups = <?php echo $total_groups?>; //total record group(s)

                $('#comments1').load("./ajax/pageScroll.php", {'group_no':track_load}, function() {track_load++;}); //load first group

                $(window).scroll(function() { //detect page scroll

                    if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
                    {

                        if(track_load < total_groups && loading==false) //there's more data to load
                        {
//                            loading = true; //prevent further ajax loading
//                            $('.animation_image').show(); //show loading image

                            //load data from the server using a HTTP POST request
                            $.post('./ajax/pageScroll.php',{'group_no': track_load}, function(data){

                                $("#comments1").append(data); //append received data into the element

                                //hide loading image
                                $('.animation_image').hide(); //hide loading image once data is received

                                track_load++; //loaded group increment
                                loading = false; 

                            }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

                                alert(thrownError); //alert with HTTP error
                                $('.animation_image').hide(); //hide loading image
                                loading = false;

                            });

                        }
                    }
                });
            });
        </script>
        <div class="container">
            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <header>
                        <div id="header"></div>
                        <div class="col-lg-8 col-md-8 col-sm-8 headerText">
                            <p>What is a wiit? Well have you ever had one of those experiences like looking in the mirror and right at eye level is a smudge and for that quick second you think you are going blind. Or why is it that when you need what is being sent to you via the Post Office right away it gets lost? That is what I would like to hear from you. Please leave me a comment below of your experiences with this. Your comments will be posted right to Twitter now <a href="https://twitter.com/whyisitthatthis" target="_blank">@whyisitthat</a> and <a href="https://www.facebook.com/whyisitthatwhen" target="_blank">Facebook!</a></p>
                        </div>
                    </header>
                </div>
            </div>
            
            
            <div class='row container-row grid-row'>
                
                <div class="col-lg-12 col-md-12 col-sm-12 commentText">
                    
                    <div class='col-lg-4 col-md-4 col-sm-4 contentRight'>
                        
                        <div class='addComments'>
                            <h3>How many Wiits are there?</h3>
                            <?php $comment->fullCommentCount() ?>
                            <h3>Most Kudos?</h3>
                            <?php $comment->mostLikes() ?>
                        </div>
<!--                        <div class="twitter">
                                <a href="https://twitter.com/whyisitthatthis" class="follow-button" data-show-count="true" data-lang="en"></a>
                            </div>
                        <div class="facebook">
                            <div class="follow" data-href="https://www.facebook.com/whyisitthatwhen" data-colorscheme="light" data-layout="button" data-show-faces="false"></div>
                        </div>-->
                    </div>
                    <div class='col-lg-7 col-md-7 col-sm-7 contentLeft'>
                        <div class="row submitWiit">
                            <div class="col-lg-12 col-md-12 col-sm-12" ng-controller="signupController">
                                
                                <form name="commentForm"  ng-submit="submitForm();" method="post" nonvalidate>
                                    <textarea type="text" class="form-control" ng-model="comment.comment" id="addComment" name='comment' ng-minlength="20" placeholder="Share your Why is it that..." required></textarea>
                                        
                                    <div id="usernameOpen" >
                                    
                                    <input type="text" class="form-control user" id="username" ng-minlength=3 ng-maxlength=15 ng-model="comment.username" name='username' placeholder="Your Name" required/>
                                    <input type="email" class="form-control user" id="email" name='email' ng-model="comment.email" placeholder="Your Email" required/>
                                        
                                          
                                    <input type='submit' ng-disabled="commentForm.$invalid" value='Add Wiit'  class="btn-primary custBtn"/>
                                    
                                     <div class="error" ng-show="commentForm.username.$dirty && commentForm.username.$invalid">
                                            <small class="error" ng-show="commentForm.username.$error.required">
                                                A username is required.
                                            </small>
                                            <small class="error" ng-show="commentForm.username.$error.minlength">
                                                Minimum characters is 5.
                                            </small>
                                            <small class="error" ng-show="commentForm.username.$error.maxlength">
                                                Maximum characters is 15.
                                            </small>
                                        </div>
                                        <div class="error" ng-show="commentForm.comment.$dirty && commentForm.comment.$invalid">
                                            <small class="error" ng-show="commentForm.comment.$error.required">
                                                A why is it that, isn't that why we are here? : )
                                            </small>
                                            <small class="error" ng-show="commentForm.comment.$error.minlength">
                                                Your statement is too short.
                                            </small>
                                        </div>
                                        <div class="error" ng-show="commentForm.email.$dirty && commentForm.email.$invalid">
                                            <small class="error" ng-show="commentForm.email.$error.required">
                                                An email address is required.
                                            </small>
                                            <small class="error" ng-show="commentForm.email.$error.email">
                                                Incorrect email format.
                                            </small>
                                        </div> 
                                    </div>


                                </form> 
                            </div>
                        </div>
                        
                        <div id="PreSyn" class="commentsRow"> 
                            
                            <div class='col-lg-12 col-md-12 col-sm-12'>
                            <div class='col-lg-2 col-md-2 col-sm-2' logo>
                                <img src='./images/smWiitLogo.png'/>
                            </div>
                            <div class='col-lg-10 col-md-10 col-sm-10 commentbox' >
                            <div class='userName' id="userNamePreSyn"></div>
                            <div class='comment' id='commentPreSyn'></div>
                            <div id='likeBox' class='likeBox' data-like-id=''>Kudos</div>
                            <div class='likeCount' id='likeCount' data-like-count=''></div>
                            </div>
                            </div>
                           
                        </div>
                        <div id="comments1"> </div>
                        <div class="animation_image" style="display:none" align="center"><img src="./images/ajax-loader.gif"></div>
                    </div>
                </div>
            </div>
            <footer></footer>
            
        </div>
        
    </body>
</html>
