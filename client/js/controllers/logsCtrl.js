/*
 *   Author :      Lionel Ding
 *   Version :     1
 *   Date :        05.03.2021 
 *   Description : JavaScript script that handles the page that contains the logs
 */

/**
 * Function called once the page is fully loaded. Inits everything
 */
$(document).ready(function() {
    $.getScript("../js/services/httpService.js", () => {

        // Update the nav to set the active tab
        setActiveTab('logs-tab');

        // Init the datatable
        initDatatable();

        // Load and fill the table of logs
        loadAndFillTable();
    });
});

/**
 * Loads and fill the datatable with data retrieved from the database.
 */
function loadAndFillTable() {
    getLogsRequest(getLogsSuccess, getLogsError);
}


/**
 * SuccessCallback function of the "get logs request".
 * Clears the datatable, fills it with new data retrieved from the database and updates it.
 */
function getLogsSuccess(data, text, jqXHR) {
    // Clear the datatable
    $('#logs-datatable tbody').html("");

    // Fills it with new data
    $(data).find('log').each((i, e) => {
        $('#logs-datatable tbody').append(`
            <tr>
                <td>${htmlEntities($(e).find('pkLog').text())}</td>
                <td>
                    ${htmlEntities($(e).find('user').find('firstName').text())}
                    ${htmlEntities($(e).find('user').find('lastName').text())}
                </td>
                <td>${htmlEntities($(e).find('start').text())}</td>
            </tr>
        `);
    });

    // Update the datatable 
    $('#logs-datatable').DataTable();
}
/**
 * ErrorCallback function of the "get logs request". 
 * Logs the error
 */
function getLogsError(request, status, error) {
    console.log(error);
}

/**
 * Inits the datatable with parameters and defines the event listeners that handle the selection of items in the list.
 */
function initDatatable() {
    // Inits the datatable
    $('#logs-datatable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false
    });

    // Event listener that handles the selection of items
    $('#logs-datatable tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            $('#logs-datatable').find('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
}