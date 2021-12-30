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
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/nav.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/profile.css" rel="stylesheet">
    <script type="text/javascript" src="../js/helpers/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../js/controllers/navCtrl.js"></script>
    <script type="text/javascript" src="../js/controllers/profileCtrl.js"></script>
</head>

<body>
    <?php include 'nav.html'; ?>
    <div class="page-title">
        <h1 class="page-main-title">RESTOful Process</h1>
        <h2 class="page-sub-title">Profile</h2>
    </div>
    <div class="container">
        <div class="alert alert-success" id="change-password-success" role="alert">
            <p>Password successfully changed</p>
        </div>
        <div class="alert alert-danger" id="change-password-error" role="alert">
            <p>Error changing the password</p>
        </div>
        <div class="alert alert-danger" id="get-user-error" role="alert">
            <p>Error loading user data</p>
        </div>
        <table>
            <tbody>
                <tr>
                    <td rowspan="7" id="avatar">
                        <img id="user-avatar" src="" alt="Avatar of the user">
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Last Name :</h3>
                        <p id="user-last-name"></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>First Name :</h3>
                        <p id="user-first-name"></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Email :</h3>
                        <p id="user-email"></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Login :</h3>
                        <p id="user-login"></p>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="user-new-password">
                        <button id="user-change-password-button">Change Password</button>
                    </td>
                </tr>
                <tr>
                    <td>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>