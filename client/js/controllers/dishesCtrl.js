/*
 *   Author :      Lionel Ding
 *   Version :     1
 *   Date :        05.03.2021 
 *   Description : JavaScript script that handles the page that contains the dishes
 */

/**
 * Function called once the page is fully loaded. Inits everything
 */
$(document).ready(function() {
    $.getScript("../js/services/httpService.js", () => {

        // Hides the alerts
        hideAlerts();

        // Update the nav to set the active tab
        setActiveTab('dishes-tab');

        // Set the event listeners for the list of dishes
        setDishesListEventListener();

        // Fill the list
        fillDishesList();

        // Set the event listener of each button
        setButtonEventListener();

    });
});


/**
 * Shows the error alert
 */
function showErrorAlert() {
    $('#dish-error').fadeIn();
    setTimeout(() => { $('#dish-error').fadeOut() }, 2000);
}

/**
 * Shows the success alert that concerns the addition of a dish
 */
function showAddDishSuccessAlert() {
    $('#add-dish-success').fadeIn();
    setTimeout(() => { $('#add-dish-success').fadeOut() }, 2000);
}

/**
 * Shows the success alert that concerns the deletion of a dish
 */
function showRemoveDishSuccessAlert() {
    $('#remove-dish-success').fadeIn();
    setTimeout(() => { $('#remove-dish-success').fadeOut() }, 2000);
}

/**
 * Hides every alert present on the page
 */
function hideAlerts() {
    $('.alert').hide();
}

/**
 * Sets the event lister for each button on the page (add, delete dish)
 */
function setButtonEventListener() {
    // Add dish button
    $('#dish-add-button').click(() => {
        let dishName = $('#dish-new').val();
        if (dishName) {
            addDishRequest(dishName, addDishSuccess, addDishError);
        }
    });

    // Delete dish button
    $('#dish-delete-button').click(() => {
        if ($('.selected')) {
            let dishPk = $('.selected').attr('pk');
            if (dishPk) {
                removeDishRequest(dishPk, removeDishSuccess, removeDishError)
            }
        }
    });
}

/**
 * SuccessCallback function of the "remove dish request". 
 * Shows a success alert and fill the list with the updated list of dishes
 */
function removeDishSuccess(data, text, jqXHR) {
    showRemoveDishSuccessAlert();
    fillDishesList();
}

/**
 * ErrorCallback function of the "remove dish request". 
 * Shows an error alert
 */
function removeDishError(request, status, error) {
    showErrorAlert();
}

/**
 * SuccessCallback function of the "add dish request". 
 * Shows a success alert and fill the list with the updated list of dishes
 */
function addDishSuccess(data, text, jqXHR) {
    showAddDishSuccessAlert();
    fillDishesList();
    $('#dish-new').val("");
}

/**
 * ErrorCallback function of the "add dish request". 
 * Shows an error alert
 */
function addDishError(request, status, error) {
    showErrorAlert();
}

/**
 * Fills the dishes list with dishes retrieved from the database
 */
function fillDishesList() {
    getDishesRequest(getDishesSuccess, getDishesError);
}

/**
 * SuccessCallback function of the "get dishes request". 
 * Clears and fills the list of dishes with
 */
function getDishesSuccess(data, text, jqXHR) {
    // Clears the list
    $('.dish-list ul').html("");

    // Fills it with new data
    $(data).find('dishes').find('dish').each((i, e) => {
        let dishName = htmlEntities($(e).find('name').text());
        let dishPk = htmlEntities($(e).find('pkDish').text());
        $('.dish-list ul').append(`<li pk="${dishPk}">${dishName}</li>`);
    });
}

/**
 * ErrorCallback function of the "get dishes request". 
 * Shows an error alert
 */
function getDishesError(request, status, error) {
    showErrorAlert();
}

/**
 * Sets the event listener that handles the selection of items in the list
 */
function setDishesListEventListener() {
    document.querySelector('ul').addEventListener('click', function(e) {
        if (e.target.tagName === 'LI') {
            selected = document.querySelector('li.selected');
            if (selected) selected.className = '';
            e.target.className = 'selected';
        }
    });
}