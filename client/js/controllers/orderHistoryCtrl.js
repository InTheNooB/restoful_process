/*
 *   Author :      Lionel Ding
 *   Version :     1
 *   Date :        05.03.2021 
 *   Description : JavaScript script that handles the page that contains validated orders
 */

/**
 * Function called once the page is fully loaded. Inits everything
 */
$(document).ready(function() {
    $.getScript("../js/services/httpService.js", () => {

        // Update the nav to set the active tab
        setActiveTab('order-history-tab');

        // Init the datatable
        initDatatable();

        // Load and fill the table of validated orders
        loadAndFillTable();
    });
});

/**
 * Loads and fills the datatable with validated orders from the database.
 */
function loadAndFillTable() {
    getValidatedOrdersRequest(getValidatedOrdersSuccess, getValidatedOrdersError);
}

/**
 * SuccessCallback function of the "get validated orders request". 
 * Fills the datatable with orders retrieved from the database.
 * Once filled, the datatable is updated.
 */
function getValidatedOrdersSuccess(data, text, jqXHR) {
    // Clears the datatable
    $('#orders-datatable tbody').html("");

    // Fills it with new data
    $(data).find('order').each((i, e) => {
        $('#orders-datatable tbody').append(`
            <tr pk="${$(e).find('pkOrder').text()}">
            <td>${htmlEntities($(e).find('content').text())}</td>
            <td>${htmlEntities($(e).find('restofulOrderUser').find('login').text())}</td>
            <td>${htmlEntities($(e).find('orderDateTime').text())}</td>
            <td>${htmlEntities($(e).find('deliveryDateTime').text())}</td>
            <td>${htmlEntities($(e).find('destination').text())}</td>
            <td>${htmlEntities($(e).find('price').text())}</td>
            </tr>
        `);
    });

    // Updated the datatable
    $('#orders-datatable').DataTable();
}

/**
 * ErrorCallback function of the "get validated orders request". 
 * Shows an error alert
 */
function getValidatedOrdersError(request, status, error) {
    showErrorAlert();
}

/**
 * Inits the datatable with parameters and defines the event listeners that handle the selection of items in the list.
 */
function initDatatable() {
    // Inits the datatable
    $('#orders-datatable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false
    });

    // Event listener that handle the selection of item
    $('#orders-datatable tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            $('#orders-datatable').find('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
}