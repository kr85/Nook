angular.module('nookApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}).controller('CommentsController', ['$scope', '$http', function($scope, $http) {

    //$http.get('/statuses/1001/comments').success(function(comments) {
    //    $scope.comments = comments;
    //});

}]);