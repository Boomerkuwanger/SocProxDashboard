/*
 *
 */

function addUser($scope, $http) {
    $scope.init = function(){
        $scope.email = "";
        $scope.username = "";
        $scope.password = "";
        $scope.confirm = "";
        $scope.errorReport="";
        $scope.alertPwd = "secondary";
        $scope.alertEmail = "secondary";
        $scope.alertUser = "secondary";
        $scope.errorStatus= "secondary";
        $('#registerForm').show();
        $('#loginForm').show();
        $('#regSuccesslogin').hide();
    };
    // Register a User
    $scope.register = function() {
        var err = false;
        var errorReport = "";
        if($scope.password !== $scope.confirm){
            $('#focusPwd').focus();
            $scope.alertPwd = "error";
            errorReport = "Passwords don't match ";
            err = true;
        } else if ($scope.password == null || $scope.password.length < 6) {
            $('#focusPwd').focus();
            $scope.alertPwd = "error";
            errorReport = "Password must be at least six characters ";
            err = true;
        } else {
            $scope.alertPwd = "success";
        }
        if ($scope.email == null || $scope.email.length < 6 ) {
            $('#focusEmail').focus();
            $scope.alertEmail = "error";
            if(err)
                errorReport = errorReport + "and ";

            errorReport = errorReport + "Email is invalid ";

            err = true;
        } else {
            $scope.alertEmail = "secondary";
        }

        if ($scope.username == null || $scope.username.length < 6) {
            $('#focusUser').focus();
            $scope.alertUser = "error";
            if(err)
                errorReport = errorReport + "and ";

            errorReport = errorReport + "Username must be at least six characters";
            err = true;
        } else {
            $scope.alertUser = "secondary";
        }

        if(err){
            $scope.errorStatus = "alert";
            $scope.errorReport = errorReport;
            return null;
        }

        var user = ('?n=' + $scope.username + '&e=' + $scope.email + '&p=' + $scope.password);
        $http.get('../php/addUser.php' + user ).success(function(data){
            var err = false;
            if(data.indexOf("Email") !== -1) {
                $('#focusEmail').focus();
                $scope.alertEmail = "error";
                err = true;
            } else {
                $scope.alertEmail = "success";
            }
            if(data.indexOf("Username") !== -1) {
                $('#focusUser').focus();
                $scope.alertUser = "error";
                err = true;
            } else {
                $scope.alertUser = "success";
            }

            if(err){
                $scope.errorStatus = "alert";
                $scope.errorReport = data;
            }
            if(!err) {
                $scope.errorStatus = "success";
                $scope.errorReport = "Successfully Registered!";
                $('#registerForm').hide();
                $('#regSuccess').show();
            }
        }).error(function(data){
            alert(data);
        });
    };

    $scope.login = function(){
        var user = ('?n=' + $scope.username + '&p=' + $scope.password);
        $http.get('../php/Functions/addUser.php' + user ).success(function(data){
            var err = false;
            if(data.indexOf("Error") !== -1) {
                $('#focusUserLogin').focus();
                $scope.alertUser = "error";
                err = true;
            } else {
                $scope.alertUser = "success";
            }

            if(err){
                $scope.errorStatus = "alert";
                $scope.errorReport = "Login Failed";
            }
            if(!err) {
                $scope.errorStatus = "success";
                $scope.errorReport = "Successfully Registered!";
                $('#loginForm').hide();
                $('#regSuccesslogin').show();
            }
        }).error(function(data){
                alert(data);
            });
    };
}
