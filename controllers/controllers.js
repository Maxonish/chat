angular.module('App', ['ngRoute','Auxiliary'])

.config(['$routeProvider', '$locationProvider',
  function($routeProvider, $locationProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'view/Signin.html',
        controller: 'SigninCtrl'
        
      })
      .when('/chat', {
        templateUrl: 'view/Chat.html',
        controller: 'ChatCtrl',
        resolve: {function($rootScope, $location){
            if($rootScope.nickname==undefined){
                $location.path('/');
            }
            }
        }
      });

    $routeProvider.otherwise({redirectTo: '/'});
    $locationProvider.html5Mode(true);
}])




angular.module('App').controller('SigninCtrl',['$scope', '$location', '$rootScope','Auth', function ($scope,$location,$rootScope,Auth) {
$scope.Pattern = new RegExp("^[a-zA-Zа-яА-Я][a-zA-Zа-яА-Я0-9]*[._-]?[a-zA-Zа-яА-Я0-9]+$");
$scope.Inspection = function(e,a) {
    var promise = Auth.Validate(e,a);
    if(promise==='good'){
        $scope.validate=true;
    }else {
        $scope.error=promise;
    }
}
$scope.Registration = function(data){
    if ($scope.validate===true){
        var promise = Auth.Http_request(data, 'ajax/registration.php')
        promise.then(function(value){
            if(value.data!==''){
                if (value.data === 'false'){
                    $scope.error = "Такой nickname уже существует";
                }else{
                    $rootScope.nickname=data.nick;
                    $location.path('/chat');
                }
            }
        });
    }
    
};

$scope.Enter = function(data){
    if ($scope.validate===true){
        var promise = Auth.Http_request(data, 'ajax/Enter.php');
        promise.then(function(value) {
        if(value.data!==''){
            if (value.data == 'false'){
                $scope.error = "Nickname или Password введен не верно";
            }else{
                $rootScope.nickname=data.nick;
                $location.path('/chat');
            }
        }
  });
    }
};



}]);

/* ChatCtrl */

angular.module('App').controller('ChatCtrl',['$scope','$rootScope','$interval','$timeout','$http','$location','Auth', function($scope,$rootScope, $interval,$timeout, $http,$location,Auth){
    $scope.attention=true;
  
    $scope.Add = function(e,user){
    if(e.which==1){
        $scope.attention=false;
        $scope.num=undefined;
        $scope.useradd=user;
        var Updatemessages = function() {
            if($scope.num==undefined){
                $scope.num=0;
        }
        var data = {name: $scope.useradd, value: $rootScope.nickname, num: $scope.num};
        var promise = Auth.Http_request(data, 'ajax/message.php');
        promise.then(function(value) {
            if (value.data!=='false' && value.data!=='dont' && value.data!=='empty'){
                $scope.messages = value.data;
            } else if (value.data==='false' || value.data==='empty') {
                $scope.messages='';
            }
        });
        var request = Auth.Http_request(data, 'ajax/num.php');
        request.then(function(value) {
            if (value.data!=='false'){
                $scope.num=value.data;
            }else {
                $scope.num=0;
            }
        });
    }
        Updatemessages();
        $scope.interval=$interval(Updatemessages,2000);
    }
};


$scope.Addmessage = function(e,message) {
    if (e!==true){
        var data = {name: $scope.useradd, value: $rootScope.nickname, message: message, };
        Auth.Http_request(data, 'ajax/addmessage.php');
    }
};
      
var Time = function(){
    var data = {name: $rootScope.nickname};
    Auth.Http_request(data, 'ajax/status.php');
    $timeout(Time,25000);
    };
    



var Updateusers = function() {
    var data = {nick: $rootScope.nickname};
    var promise=Auth.Http_request(data, 'ajax/users.php');
    promise.then(function(value){
        $scope.users = value.data;
    });
    $timeout(Updateusers, 30000);
};

Time();
Updateusers();
  
$scope.Clearinterval=function(e) {
    if(e.which==1){
        $interval.cancel($scope.interval);
        $scope.interval=undefined;
    }
};

$scope.Select=function(partner){
    $scope.partner=partner;
}

}]);

