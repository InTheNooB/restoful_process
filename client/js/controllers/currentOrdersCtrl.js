/*
 *   Author :      Lionel Ding
 *   Version :     1
 *   Date :        05.03.2021 
 *   Description : JavaScript script that handles the page that contains the unvalidated orders
 */

/**
 * Function called once the page is fully loaded. Inits everything
 */
$(document).ready(function() {
    $.getScript("../js/services/httpService.js", () => {

        // Hides the alerts
        hideAlerts();

        // Update the nav to set the active tab
        setActiveTab('current-orders-tab');

        // Init the datatable
        initDatatable();

        // Load and fill the table of unvalidated orders
        loadAndFillTable();

        // Set the "validate button" event listener
        validateButtonEventListener();
    });
});

/**
 * Hides every alerts on the page
 */
function hideAlerts() {
    $('.alert').hide();
}

/**
 * Shows the error alert
 */
function showErrorAlert() {
    $('#order-error').fadeIn();
    setTimeout(() => { $('#order-error').fadeOut() }, 2000);
}

/**
 * Shows the success alert for 3 seconds then make it fadeout
 */
function showValidateOrderSuccessAlert() {
    $('#validate-order-success').fadeIn();
    setTimeout(() => { $('#validate-order-success').fadeOut() }, 2000);
}


/**
 * Creates the event listeners on the validate order button.
 */
function validateButtonEventListener() {
    $('#validate-order-button').click(() => {
        let pkOrder = $('#current-orders-datatable').find('.selected').attr('pk');
        if (pkOrder) {
            validateOrderRequest(pkOrder, validateOrderSuccess, validateOrderError);
        }
    });
}

/**
 * SuccessCallback function of the "get validate order request". 
 * Retrieves and updates the list of unvalidated orders and show a success alert.
 */
function validateOrderSuccess(data, text, jqXHR) {
    getUnvalidatedOrdersRequest(getUnvalidatedOrdersSuccess, getUnvalidatedOrdersError);
    showValidateOrderSuccessAlert();
}

/**
 * ErrorCallback function of the "get validate order request".
 * Shows the error alert.
 */
function validateOrderError(request, status, error) {
    showErrorAlert();
}

/**
 * Loads and fills the datatable with unvalidated orders from the database.
 */
function loadAndFillTable() {
    getUnvalidatedOrdersRequest(getUnvalidatedOrdersSuccess, getUnvalidatedOrdersError);
}

/**
 * SuccessCallback function of the "get unvalidated order request". 
 * Fills the datatable with orders retrieved from the database.
 * Once filled, the datatable is updated.
 */
function getUnvalidatedOrdersSuccess(data, text, jqXHR) {
    // Clears the datatable
    $('#current-orders-datatable tbody').html("");

    // Fills it with new data
    $(data).find('order').each((i, e) => {
        $('#current-orders-datatable tbody').append(`
                <tr pk="${$(e).find('pkOrder').text()}">
                <td>${htmlEntities($(e).find('content').text())}</td>
                <td>${htmlEntities($(e).find('restofulOrderUser').find('login').text())}</td>
                <td>${htmlEntities($(e).find('orderDateTime').text())}</td>
                <td>${htmlEntities($(e).find('destination').text())}</td>
                <td>${htmlEntities($(e).find('price').text())}</td>
                </tr>
            `);
    });

    // Updates the datatable
    $('#current-orders-datatable').DataTable();
}

/**
 * ErrorCallback function of the "get validate order request".
 * Shows the error alert.
 */
function getUnvalidatedOrdersError(request, status, error) {
    showErrorAlert();
}

/**
 * Inits the datatable with parameters and defines the event listeners that handle the selection of items in the list.
 */
function initDatatable() {
    // Inits the datatable
    $('#current-orders-datatable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false
    });

    // Event listener that handle the selection of item
    $('#current-orders-datatable tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            $('#current-orders-datatable').find('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
}