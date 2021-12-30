<?php

/**
 * Script Name : restofulOrderUserManager
 * 
 * Description : Handles incoming http/https requests related to the restofulOrderUser
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/RestofulOrderUserDBManager.php');
require_once('wrk/TokenDBManager.php');
require_once('wrk/OrderDBManager.php');
require_once('wrk/DishDBManager.php');

session_start();


switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'loginUser':
                    if (isset($_POST['username']) && isset($_POST['password'])) {
                        $restofulOrderUserDBManager = new RestofulOrderUserDBManager();
                        $user = $restofulOrderUserDBManager->checkUserCredentials($_POST['username'], $_POST['password']);
                        if (isset($user) and $user->getPkRestofulOrderUser() != "") {
                            // A user has been found, the credentials were correct
                            $tokenDBManager = new TokenDBManager();
                            echo $tokenDBManager->addTokenRestofulUser($user->getPkRestofulOrderUser(), 1);
                        } else {
                            // No user was found, the credentials were wrong
                            http_response_code(401);
                        }
                    }
                    break;
                case 'addOrder':
                    if (isset($_POST['token'])) {
                        $tokenDBManager = new TokenDBManager();
                        $client = $tokenDBManager->checkTokenRestofulOrderUser($_POST['token']);
                        if (isset($client)) {
                            $orderDBManager = new OrderDBManager();
                            $orderDBManager->addOrderFromArray($client, $_POST['order']);
                        } else {
                            http_response_code(401);
                        }
                    }
                    break;
            }
        }
        break;
    case 'GET':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'getOrders':
                    if (isset($_GET['token'])) {
                        $tokenDBManager = new TokenDBManager();
                        $client = $tokenDBManager->checkTokenRestofulOrderUser($_GET['token']);
                        if (isset($client)) {
                            $orderDBManager = new OrderDBManager();
                            echo $orderDBManager->getOrdersByFkClientAsXML($client->getPkRestofulOrderUser());
                        } else {
                            http_response_code(401);
                        }
                    }
                    break;
                case 'getDishes':
                    if (isset($_GET['token'])) {
                        $tokenDBManager = new TokenDBManager();
                        $client = $tokenDBManager->checkTokenRestofulOrderUser($_GET['token']);
                        if (isset($client)) {
                            $dishDBManager = new DishDBManager();
                            echo $dishDBManager->getDishesAsXML();
                        } else {
                            http_response_code(401);
                        }
                    }
                    break;
            }
        }
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($_PUT) and isset($_PUT['action'])) {
            switch ($_PUT['action']) {
            }
        }
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        if (isset($_DELETE) and isset($_DELETE['action'])) {
            switch ($_DELETE['action']) {
            }
        }
        break;
}
