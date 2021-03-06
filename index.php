<?php include 'functions/globalClass.php'; 
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

<html ng-app="validationApp">
    <head>
        <meta charset="UTF-8">
<!--        <meta http-equiv="refresh" content="45;url=index.php">-->
        <title>Why Is It That...</title>
        <link rel="shortcut icon" type="image/ico" href="./images/favicon.ico" />
        <link href="./css/bootstrap.css" rel="stylesheet"/>
        <link href="./css/stylesheet.css" rel="stylesheet" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
        <script src="./lib/angular/angular.js"></script>
        <script src="./lib/angular/angular-route.js"></script>
        <script src="./js/javascript.js"></script>
        <script src="./js/app.js"></script>
    
    </head>
    <body>
        
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
                    <div class='col-lg-3 col-md-3 col-sm-3 contentRight'>
                        
                        <div class='addComments'>
                            <div id='add'><h2>Add Comment</h2></div>
                            <div class="commentForm">
                                <div class="col-lg-12 col-md-12 col-sm-12" ng-controller="signupController">
                                    
                                    <form name="commentForm"  ng-submit="submitForm();" action="./ajax/addComment.php" method="post" nonvalidate>
                                        <label>Username</label>
                                        <input type="text" class="form-control" id="username" ng-minlength=3 ng-maxlength=15 ng-model="comment.username" name='username' placeholder="Username" required/>
                                        
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
                                        
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email" name='email' ng-model="comment.email" placeholder="Email" required/>
                                        
                                        <div class="error" ng-show="commentForm.email.$dirty && commentForm.email.$invalid">
                                            <small class="error" ng-show="commentForm.email.$error.required">
                                                An email address is required.
                                            </small>
                                            <small class="error" ng-show="commentForm.email.$error.email">
                                                Incorrect email format.
                                            </small>
                                        </div>
                                        
                                        
                                        <label>Why is it that..</label>
                                        <textarea type="text" class="form-control" ng-model="comment.comment" id="comment" name='comment' placeholder="Add a Why is it that. " ng-minlength="15" required></textarea>
                                       
                                        <div class="error" ng-show="commentForm.comment.$dirty && commentForm.comment.$invalid">
                                            <small class="error" ng-show="commentForm.comment.$error.required">
                                                A why is it that, isn't that why we are here? : )
                                            </small>
                                            <small class="error" ng-show="commentForm.comment.$error.minlength">
                                                Your statement is too short.
                                            </small>
                                        </div>
                                        <input type='submit' ng-disabled="commentForm.$invalid" value='Add Comment'  class="btn-primary"/>
                                    </form>
                                    
                                </div>
                            </div>
                            
                        </div>
                        <div class="twitter">
                                <a href="https://twitter.com/whyisitthatthis" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @whyisitthatthis</a>
                            </div>
                        <div>
                            <div class="fb-like" data-href="http://www.whyisitthat.net/" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
                        </div>
                    </div>
                    <div class='col-lg-8 col-md-8 col-sm-8 contentLeft'>
                   
                       <?php $comment->displayComments()?>
                            
                       
                    </div>
                    
                </div>
            </div>
            <footer></footer>
            
        </div>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    </body>
</html>
