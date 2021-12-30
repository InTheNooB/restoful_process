/*
 *   Author :      Lionel Ding
 *   Version :     1
 *   Date :        05.03.2021 
 *   Description : JavaScript script that handles the login page
 */

/**
 * Function called once the page is fully loaded. Inits everything
 */
$(document).ready(function() {
    $.getScript("./js/services/httpService.js", () => {

        // Hides the alerts
        hideAlerts();

        // Sets an event listener that triggers when the login form is submitted 
        $("#login-form").submit((e) => {
            e.preventDefault();
            let username = $(this).find("input#username").val();
            let password = $(this).find("input#password").val();
            let rememberMe = $(this).find("input#rememberMe").is(':checked');
            loginUserRequest(username, password, rememberMe, loginUserSuccess, loginUserError);
        });

        // Check if the localstorage contains a token
        lookForLoginToken();
    });
});

function lookForLoginToken() {
    let token = localStorage.getItem('loginToken');
    if (token) {
        // A token was found, try to connect using it
        loginUserTokenRequest(token, loginUserSuccess, loginUserError);
    }
}

/**
 * Hides every alerts on the page
 */
function hideAlerts() {
    $(".login-form .alert-danger").hide();
}


/**
 * SuccessCallback function of the "login user request".
 * Redirects to an other page if the credentials were correct, shows an error alert if not.
 */
function loginUserSuccess(data, text, jqXHR) {
    if ($(data).find("user").find('pkUser').text() == "") {
        // Wrong credentials
        $(".login-form #alert-wrong-credentials").fadeIn();
    } else {
        // Correct credentials
        if ($(data).find("token") && $(data).find("token").text()) {
            localStorage.setItem('loginToken', $(data).find("token").text());
        }
        document.location.href = "./html/profile.php";
    }
}

/**
 * ErrorCallback function of the "login user request". 
 * Shows an error alert
 */
function loginUserError(request, status, error) {
    // Show error alert
    $(".login-form #alert-error").fadeIn();
}