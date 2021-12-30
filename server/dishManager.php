<?php

/**
 * Script Name : dishManager
 * 
 * Description : Handles incoming http/https requests related to the Dishes
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/SessionManager.php');
require_once('wrk/DishDBManager.php');

session_start();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'getDishes':
                    $dishDBManager = new DishDBManager();
                    $sessionManager = new SessionManager();
                    $loggedUser = $sessionManager->getLoggedUser();
                    if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                        echo $dishDBManager->getDishesAsXML();
                    } else {
                        http_response_code(401);
                    }
                    break;
            }
        }
        break;
    case 'POST':
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'addDish':
                    if (isset($_POST['dishName']) && $_POST['dishName'] != "") {
                        $dishDBManager = new DishDBManager();
                        $sessionManager = new SessionManager();
                        $loggedUser = $sessionManager->getLoggedUser();
                        if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                            echo $dishDBManager->addDish($_POST['dishName']);
                            echo "<result>OK</result>";
                        } else {
                            http_response_code(401);
                        }
                    }
                    break;
            }
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        if (isset($_DELETE) and isset($_DELETE['action'])) {
            switch ($_DELETE['action']) {
                case 'removeDish':
                    if (isset($_DELETE['pkDish']) && $_DELETE['pkDish'] != "") {
                        $dishDBManager = new DishDBManager();
                        $sessionManager = new SessionManager();
                        $loggedUser = $sessionManager->getLoggedUser();
                        if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                            $dishDBManager->removeDishByPk($_DELETE['pkDish']);
                            echo "<result>OK</result>";
                        }
                    }
                    break;
            }
        }
        break;
}
