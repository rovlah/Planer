// Application module
var crudApp = angular.module('crudApp',[]);
crudApp.controller("DbController",['$scope','$http', function($scope,$http){

// Function to get employee details from the database
getInfo();
function getInfo(){
// Sending request to EmpDetails.php files 
$http.post('databaseFiles/empDetails-raspored.php').success(function(data){
// Stored the returned data into scope 
$scope.details = data;
});
}

// Setting default value of gender 
$scope.empInfo = {'pred_vjezbe' : 'Predavanja'};
// Enabling show_form variable to enable Add employee button
$scope.show_form = true;
// Function to add toggle behaviour to form
$scope.formToggle =function(){
$('#empForm').slideToggle();
$('#editForm').css('display', 'none');
}
$scope.insertInfo = function(info){
	$http.post('databaseFiles/insertDetails-raspored.php',{"naziv_kolegija":info.naziv_kolegija,"pred_vjezbe":info.pred_vjezbe,"ime_profesora":info.ime_profesora,"dan":info.dan,"pocetak":info.pocetak,"zavrsetak":info.zavrsetak}).success(function(data){
if (data == true) {
getInfo();
$('#empForm').css('display', 'none');
}
});
}
$scope.deleteInfo = function(info){
$http.post('databaseFiles/deleteDetails-raspored.php',{"broj":info.broj}).success(function(data){
if (data == true) {
getInfo();
}
});
}
$scope.currentUser = {};
$scope.editInfo = function(info){
$scope.currentUser = info;
$('#empForm').slideUp();
$('#editForm').slideToggle();
}
$scope.UpdateInfo = function(info){
$http.post('databaseFiles/updateDetails-raspored.php',{"broj":info.broj,"naziv_kolegija":info.naziv_kolegija,"pred_vjezbe":info.pred_vjezbe,"ime_profesora":info.ime_profesora,"dan":info.dan,"pocetak":info.pocetak,"zavrsetak":info.zavrsetak}).success(function(data){
$scope.show_form = true;
if (data == true) {
getInfo();
}
});
}
$scope.updateMsg = function(emp_id){
$('#editForm').css('display', 'none');
}
}]);