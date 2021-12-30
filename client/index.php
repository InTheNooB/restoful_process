<?php
session_start();
//$sessionManager = new SessionManager();
if (isset($_SESSION['loggedIn']) and $_SESSION['loggedIn'] == true) {
    header('Location: ./html/currentOrders.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script type="text/javascript" src="js/helpers/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/controllers/indexCtrl.js"></script>
    <link rel="stylesheet" href="./css/login.css">

</head>

<body>
    <div class="login-form" >
        <h1>Login</h1>
        <div class="alert alert-danger" id="alert-wrong-credentials" role="alert">
            <p>Invalid username or password</p>
        </div>
        <div class="alert alert-danger" id="alert-error" role="alert">
            <p>An error has occured</p>
        </div>
        <form id="login-form">
            <div class="user-box">
                <input type="text" name="username" id="username" required="">
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" id="password" required="">
                <label>Password</label>
            </div>
            <div class="remember-me">
                <input type="checkbox" name="rememberMe" id="rememberMe">
                <label for="rememberMe">Remember me</label>
            </div>
            <div class="login-button">
                <button>Login</button>
            </div>
        </form>
    </div>

</body>

</html>