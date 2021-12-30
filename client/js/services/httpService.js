/*
 *   Author :      Lionel Ding
 *   Version :     1
 *   Date :        05.03.2021 
 *   Description : JavaScript script that handles the connection with server and each request sent
 */
var BASE_URL = "https://dingl01.emf-informatique.ch/restoful_process/server/";
var BASE_URL_USER = BASE_URL + "userManager.php";
var BASE_URL_LOG = BASE_URL + "logManager.php";
var BASE_URL_DISH = BASE_URL + "dishManager.php";
var BASE_URL_ORDER = BASE_URL + "orderManager.php";
var BASE_URL_RESTOFUL = BASE_URL + "orderManager.php";

/**
 * Parses a string to prevent HTML/JS injections
 */
function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

/**
 * Sends a "login" request to the server
 */
function loginUserRequest(username, password, rememberMe, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "xml",
        url: BASE_URL_USER,
        data: `action=loginUser&username=${username}&password=${password}&rememberMe=${rememberMe}`,
        success: successCallback,
        error: errorCallback
    });
}
/**
 * Sends a "login" request to the server
 */
function loginUserTokenRequest(token, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "xml",
        url: BASE_URL_USER,
        data: `action=loginUser&token=${token}`,
        success: successCallback,
        error: errorCallback
    });
}

/**
 * Sends a "disconnect user" request to the server 
 */
function disconnectUserRequest(token, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "xml",
        url: BASE_URL_USER,
        data: `action=disconnectUser&token=${token}`,
        success: successCallback,
        error: errorCallback
    });
}


/**
 * Sends a "get logged user" request to the server 
 */
function getLoggedUserRequest(successCallback, errorCallback) {
    $.ajax({
        type: "GET",
        dataType: "xml",
        url: BASE_URL_USER,
        data: `action=getLoggedUser`,
        success: successCallback,
        error: errorCallback
    });
}

/**
 * Sends a "change user password" request to the server 
 */
function changeLoggedUserPasswordRequest(newPassword, successCallback, errorCallback) {
    $.ajax({
        type: "PUT",
        dataType: "xml",
        url: BASE_URL_USER,
        data: `action=changeLoggedUserPassword&newPassword=${newPassword}`,
        success: successCallback,
        error: errorCallback
    });
}


/**
 * Sends a "get dishes" request to the server 
 */
function getDishesRequest(successCallback, errorCallback) {
    $.ajax({
        type: "GET",
        dataType: "xml",
        url: BASE_URL_DISH,
        data: `action=getDishes`,
        success: successCallback,
        error: errorCallback
    });
    /*
    $.ajax({
        type: "POST",
        dataType: "application/json",
        url: BASE_URL_RESTOFUL,
        data: {
            "action": "addOrder",
            "token": "81ny24NK0fHqUuv",
            "order": {
                "destination": "asdaassssdasdasdd",
                "price": 10.2,
                "content": [
                    1,
                    2,
                    3
                ]
            }
        },
        success: a,
        error: b
    });

    function a(aa, aaa, aaaa) {
        console.log(aa);
    }

    function b(aa, aaa, aaaa) {
        console.log(aaaa);
    }
    */
}


/**
 * Sends a "add dish" request to the server 
 */
function addDishRequest(dishName, successCallback, errorCallback) {
    $.ajax({
        type: "POST",
        dataType: "xml",
        url: BASE_URL_DISH,
        data: `action=addDish&dishName=${dishName}`,
        success: successCallback,
        error: errorCallback
    });
}

/**
 * Sends a "remove dish" request to the server 
 */
function removeDishRequest(pkDish, successCallback, errorCallback) {
    $.ajax({
        type: "DELETE",
        dataType: "xml",
        url: BASE_URL_DISH,
        data: `action=removeDish&pkDish=${pkDish}`,
        success: successCallback,
        error: errorCallback
    });
}


/**
 * Sends a "validate order" request to the server 
 */
function validateOrderRequest(pkOrder, successCallback, errorCallback) {
    $.ajax({
        type: "PUT",
        dataType: "xml",
        url: BASE_URL_ORDER,
        data: `action=validateOrder&pkOrder=${pkOrder}`,
        success: successCallback,
        error: errorCallback
    });
}


/**
 * Sends a "get unvalidated orders" request to the server 
 */
function getUnvalidatedOrdersRequest(successCallback, errorCallback) {
    $.ajax({
        type: "GET",
        dataType: "xml",
        url: BASE_URL_ORDER,
        data: `action=getUnvalidatedOrders`,
        success: successCallback,
        error: errorCallback
    });
}


/**
 * Sends a "get validated orders" request to the server 
 */
function getValidatedOrdersRequest(successCallback, errorCallback) {
    $.ajax({
        type: "GET",
        dataType: "xml",
        url: BASE_URL_ORDER,
        data: `action=getValidatedOrders`,
        success: successCallback,
        error: errorCallback
    });
}


/**
 * Sends a "get logs" request to the server 
 */
function getLogsRequest(successCallback, errorCallback) {
    $.ajax({
        type: "GET",
        dataType: "xml",
        url: BASE_URL_LOG,
        data: `action=getLogs`,
        success: successCallback,
        error: errorCallback
    });
}