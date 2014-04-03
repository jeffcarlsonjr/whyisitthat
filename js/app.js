var validationApp = angular.module('validationApp', ['ngRoute']);

    
validationApp.config(['$routeProvider', function($routeProvider) {
            $routeProvider.
                    when('/home', {
                        templateUrl: 'index.php',
                        controller: 'signupController'
                    }).
                    otherwise({redirectTo: '/home'});
    }]);

    
validationApp.controller('commentCtrl', function($scope, $http){
    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $http.get("./ajax/getComments.php").success(function(data)
        {
            $scope.comment = data;
        });
        
        
      
});


validationApp.controller('signupController',function($scope,$http)
    {
        $scope.submitForm = function(){
            $scope.url = './ajax/addComment.php';
            if($scope.commentForm.$valid){
                //alert('Your What Is It That has been submitted.');
                $('#PreSyn').css('display', 'block');
                $('#userNamePreSyn').html($scope.comment.username +' had to say');
                $('#commentPreSyn').html($scope.comment.comment);
                
                
                $http.post($scope.url,{username: $scope.comment.username, email: $scope.comment.email, comment: $scope.comment.comment}).
                        success(function(data) {
                          
                        });
                        console.log($scope.comment.username);
                    }
                 
            };
            
    });


