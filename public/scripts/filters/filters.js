angular.module('utilFilters', []).filter('checkmark', function() {

	console.log("test");

	return function(input) {
	  return input ? '\u2713' : '\u2718';
	};

});