var appPeralatan = angular.module('peralatanRecords', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
	.constant('API_URL', 'http://localhost:8000/api/v1/');


var appPerbaikan = angular.module('perbaikanRecords', ["ngQuickDate"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
	.constant('API_URL', 'http://localhost:8000/api/v1/');


var appPengguna = angular.module('penggunaRecords', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
	.constant('API_URL', 'http://localhost:8000/api/v1/');