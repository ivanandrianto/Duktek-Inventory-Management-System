var appPeralatan = angular.module('peralatanRecords', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
	.constant('API_URL', 'http://localhost:8000/api/v1/')
    .config(function($locationProvider){
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        })
    });


var appPerbaikan = angular.module('perbaikanRecords', ["ngQuickDate"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
	.constant('API_URL', 'http://localhost:8000/api/v1/');


var appPengguna = angular.module('penggunaRecords', ["ngRoute"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
	.constant('API_URL', 'http://localhost:8000/api/v1/')
    .config(function($locationProvider){
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        })
    });

var appTransaksi = angular.module('transaksiRecords', ["ngQuickDate"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
    .constant('API_URL', 'http://localhost:8000/api/v1/');

var appBooking = angular.module('bookingRecords', ["ngQuickDate"], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
    .constant('API_URL', 'http://localhost:8000/api/v1/');

