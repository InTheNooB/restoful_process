/*
 *   Author :      Lionel Ding
 *   Version :     1
 *   Date :        05.03.2021 
 *   Description : JavaScript script that handles the page that contains profile of the user
 */

/**
 * Function called once the page is fully loaded. Inits everything
 */
$(document).ready(function() {
    $.getScript("../js/services/httpService.js", () => {

        // Update the nav to set the active tab
        setActiveTab('profile-tab');

        // Fill the profile fields
        fillProfileFields();

        // Set "change password" event listenener
        changePasswordEventListener();

        // Hide alerts
        hideAlerts();

    });
});

/**
 * Hides every alert on the page
 */
function hideAlerts() {
    $('.alert').hide();
}

/**
 * Sets the event listener that handles the changing of password
 */
function changePasswordEventListener() {
    $('#user-change-password-button').click(() => {
        let password = $('#user-new-password').val();
        if (password) {
            changeLoggedUserPasswordRequest(password, changeLoggedUserPasswordSuccess, changeLoggedUserPasswordError)
        }
    });
}

/**
 * SuccessCallback function of the "change user password request". 
 * Shows a success alert if the password has successfully been changed.
 */
function changeLoggedUserPasswordSuccess(data, text, jqXHR) {
    if ($(data).find("result").text() == "OK") {
        $('#change-password-success').fadeIn();
        $('#user-new-password').val("");
    }
}

/**
 * ErrorCallback function of the "change user password request". 
 * Shows an error alert
 */
function changeLoggedUserPasswordError(request, status, error) {
    $('#change-password-error').fadeIn();
}

/**
 * Fills every profil field with data retrieved from the database.
 */
function fillProfileFields() {
    getLoggedUserRequest(getLoggedUserSuccess, getLoggedUserError);
}

/**
 * SuccessCallback function of the "get logged user request". 
 * Fills every field with data retrieved from the database
 */
function getLoggedUserSuccess(data, text, jqXHR) {
    if ($(data).find("user").find('pkUser').text()) {
        let src = `data:image/png;base64,${htmlEntities($(data).find('img').text())}`;
        $('#user-avatar').attr("src", src);
        $('#user-last-name').text(htmlEntities($(data).find('lastName').text()));
        $('#user-first-name').text(htmlEntities($(data).find('firstName').text()));
        $('#user-email').text(htmlEntities($(data).find('email').text()));
        $('#user-login').text(htmlEntities($(data).find('login').text()));
    }
}

/**
 * ErrorCallback function of the "get logged user request". 
 * Shows an error alert
 */
function getLoggedUserError(request, status, error) {
    $('#get-user-error').fadeIn();
}