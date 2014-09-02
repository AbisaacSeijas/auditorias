angular.module('miApp', [])

.config(function($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
})

.controller('angularCtrl', function($scope, $http) {

	$http.get('http://localhost/sisri/angular/getData').success(function(data) {
		$scope.date = data.date;
	});

});


//angularCtrl.$inject = ['$scope', '$http']; // Ask Angular.js to inject the requested services

//miApp.controller('angularCtrl', angularCtrl); // Initialize controller in pre-defined module