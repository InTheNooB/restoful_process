<?php

/**
 * Script Name : logManager
 * 
 * Description : Handles incoming http/https requests related to the Logs
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/SessionManager.php');
require_once('wrk/LogDBManager.php');

session_start();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'getLogs':
                    $logDBManager = new LogDBManager();
                    $sessionManager = new SessionManager();
                    $loggedUser = $sessionManager->getLoggedUser();
                    if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                        echo $logDBManager->getLogsAsXML();
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
                case 'addLog':
                    $logDBManager = new LogDBManager();
                    $sessionManager = new SessionManager();
                    $loggedUser = $sessionManager->getLoggedUser();
                    if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                        echo $logDBManager->addLog($loggedUser->getPkUser());
                        echo "<result>OK</result>";
                    } else {
                        http_response_code(401);
                    }
                    break;
            }
        }
        break;
}
