<?php
session_start();
include 'router.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Orders</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/nav.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/currentOrders.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="../js/helpers/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/controllers/navCtrl.js"></script>
    <script type="text/javascript" src="../js/controllers/currentOrdersCtrl.js"></script>
</head>

<body>
    <?php include 'nav.html'; ?>
    <div class="page-title">
        <h1 class="page-main-title">RESTOful Process</h1>
        <h2 class="page-sub-title">Current Orders</h2>
    </div>
    <div class="container">
        <div class="alert alert-success" id="validate-order-success" role="alert">
            <p>Order successfully validated</p>
        </div>
        <div class="alert alert-danger" id="order-error" role="alert">
            <p>An error has occured</p>
        </div>
        <button id="validate-order-button">Validate Order</button>
        <table id="current-orders-datatable" class="display">
            <thead>
                <tr>
                    <th>Content</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Destination</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</body>
</html>