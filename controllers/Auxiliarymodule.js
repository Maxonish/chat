angular.module('Auxiliary', []);


angular.module('Auxiliary').directive('sourcemessage', function(){
    return {
        restrict: 'A',
        link: function($scope, element, attrs, ctrl) {
            if($scope.partner !== attrs.sourcemessage){
                element[0].classList.add('creater');
            }        
        }
    };
});

angular.module('Auxiliary').directive('scroll', function(){
    return {
        restrict: 'A',
        scope: true,
        link: function($scope, element, attrs, ctrl) {
            $scope.$watch('messages', function(newvalue, oldvalue){
                if(newvalue!==''){
                    var block = element[0];
                    block.scrollTop = block.scrollHeight;
                }
            });
        }
    };
});

angular.module('Auxiliary').service('Auth',['$http','$q',function($http, $q){

	this.Validate = function(e,a){
		if (e===true && a===true){
			return 'good';
    	}else if(e === false && a===true){
    		return 'Nickname должен содержать от 3-10 символов';
    	} else if (e === true && a===false){
    		return 'Password должен содержать не менее 7 символов';
    	} else if (e === false && a===false){
    		return 'Nickname и Password заданы некоректно';
    	}
	}

	this.Http_request = function(data,url){
		var defer=$q.defer();
		$http.post(url,data).
        then(function(response) {
		    defer.resolve(response);
		});
		return defer.promise;
	}
}]);

angular.module('Auxiliary').factory('Scroll', ['', function(){
    return {
        Fuction: function(){

        }
        
    };
}])


