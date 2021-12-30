<?php

/**
 * Script Name : orderManager
 * 
 * Description : Handles incoming http/https requests related to the Orders
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/SessionManager.php');
require_once('wrk/OrderDBManager.php');

session_start();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
            }
        }
        break;
    case 'GET':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'getUnvalidatedOrders':
                    $orderDBManager = new OrderDBManager();
                    $sessionManager = new SessionManager();
                    $loggedUser = $sessionManager->getLoggedUser();
                    if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                        echo $orderDBManager->getUnvalidatedOrdersAsXML();
                    } else {
                        http_response_code(401);
                    }
                    break;
                case 'getValidatedOrders':
                    $orderDBManager = new OrderDBManager();
                    $sessionManager = new SessionManager();
                    $loggedUser = $sessionManager->getLoggedUser();
                    if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                        echo $orderDBManager->getValidatedOrdersAsXML();
                    } else {
                        http_response_code(401);
                    }
                    break;
            }
        }
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($_PUT) and isset($_PUT['action'])) {
            switch ($_PUT['action']) {
                case 'validateOrder':
                    if (isset($_PUT['pkOrder'])) {
                        $orderDBManager = new OrderDBManager();
                        $sessionManager = new SessionManager();
                        $loggedUser = $sessionManager->getLoggedUser();
                        if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                            $orderDBManager->validateOrderByPk($_PUT['pkOrder']);
                            echo "<result>OK</result>";
                        } else {
                            http_response_code(401);
                        }
                        break;
                    }
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
