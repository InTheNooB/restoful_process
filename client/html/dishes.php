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
    <title>Dishes</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/nav.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/dishes.css" rel="stylesheet">
    <script type="text/javascript" src="../js/helpers/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../js/controllers/navCtrl.js"></script>
    <script type="text/javascript" src="../js/controllers/dishesCtrl.js"></script>
</head>

<body>
    <?php include 'nav.html'; ?>
    <div class="page-title">
        <h1 class="page-main-title">RESTOful Process</h1>
        <h2 class="page-sub-title">Dishes</h2>
    </div>
    <div class="container">
        <div class="alert alert-success" id="add-dish-success" role="alert">
            <p>Dish successfully added</p>
        </div>
        <div class="alert alert-success" id="remove-dish-success" role="alert">
            <p>Dish successfully removed</p>
        </div>
        <div class="alert alert-danger" id="dish-error" role="alert">
            <p>An error has occured</p>
        </div>
        <table>
            <tbody>
                <tr>
                    <td rowspan="3" class="dish-list-td">
                        <div class="dish-list">
                            <ul></ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Dish Name :</h3>
                        <input type="text" id="dish-new">
                        <button id="dish-add-button">Add Dish</button>
                    </td>
                <tr>
                    <td>
                        <button id="dish-delete-button">Delete Dish</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>