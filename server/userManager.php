<?php

/**
 * Script Name : userManager
 * 
 * Description : Handles incoming http/https requests related to the Users
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/SessionManager.php');
require_once('wrk/UserDBManager.php');
require_once('wrk/LogDBManager.php');
require_once('wrk/TokenDBManager.php');

session_start();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'loginUser':
                    if (isset($_POST['username']) && isset($_POST['password'])) {
                        $userDBManager = new UserDBManager();
                        $sessionManager = new SessionManager();
                        $user = $userDBManager->checkUserCredentials($_POST['username'], $_POST['password']);
                        if (isset($user) and $user->getPkUser() != "") {
                            // A user has been found, the credentials were correct
                            correctCredentials($sessionManager, $user);
                            $answer = '<result>';
                            $answer .= $user->toXML();
                            // Check if the user required a token (rememberMe)
                            if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == "true") {
                                $tokenDBManager = new TokenDBManager();
                                $token = $tokenDBManager->addTokenUser($user->getPkUser(), 100);
                                $answer .= '<token>' . $token . '</token>';
                            }
                            $answer .= '</result>';

                            // Send data
                            echo $answer;
                        }
                    } else if (isset($_POST['token'])) {
                        // User is trying to connect using a token
                        $tokenDBManager = new TokenDBManager();
                        $user = $tokenDBManager->checkTokenUser($_POST['token']);
                        if (isset($user)) {
                            $sessionManager = new SessionManager();
                            correctCredentials($sessionManager, $user);
                            echo $user->toXML();
                        }
                    }
                    break;
                case 'disconnectUser':
                    $sessionManager = new SessionManager();
                    $sessionManager->disconnectUser();
                    if (isset($_POST['token']) && $_POST['token'] != "") {
                        $tokenDBManager = new TokenDBManager();
                        $tokenDBManager->removeToken($_POST['token']);
                    }
                    echo "<result>OK</result>";
                    break;
            }
        }
        break;
    case 'GET':
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'getLoggedUser':
                    $userDBManager = new UserDBManager();
                    $sessionManager = new SessionManager();
                    $loggedUser = $sessionManager->getLoggedUser();
                    if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                        echo $loggedUser->toXML();
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
                case 'changeLoggedUserPassword':
                    if (isset($_PUT['newPassword'])) {
                        $userDBManager = new UserDBManager();
                        $sessionManager = new SessionManager();
                        $loggedUser = $sessionManager->getLoggedUser();
                        if ($sessionManager->isLoggedIn() && isset($loggedUser)) {
                            $userDBManager->changeUserPasswordByPk($loggedUser->getLogin(), $_PUT['newPassword']);
                            echo "<result>OK</result>";
                        } else {
                            http_response_code(401);
                        }
                    }
                    break;
            }
        }
        break;
}


function correctCredentials($sessionManager, $user)
{
    // Update the session
    $sessionManager->setLoggedIn(true);
    $sessionManager->setLoggedUser($user);

    // Add a log
    $logDBManager = new LogDBManager();
    $logDBManager->addLog($user->getPkUser());
}