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
    <title>Logs</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/nav.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/logs.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="../js/helpers/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/controllers/navCtrl.js"></script>
    <script type="text/javascript" src="../js/controllers/logsCtrl.js"></script>
</head>

<body>
    <?php include 'nav.html'; ?>
    <div class="page-title">
        <h1 class="page-main-title">RESTOful Process</h1>
        <h2 class="page-sub-title">Order History</h2>
    </div>
    <div class="container">
        <table id="logs-datatable" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Start Date/Time</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</body>
</html>