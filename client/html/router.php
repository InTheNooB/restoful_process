<?php
if (!isset($_SESSION['loggedIn']) or $_SESSION['loggedIn'] == false) {
    header('Location: ../index.php');
}