<?php

/**
 * Class Name : RestofulOrderUserDBManager
 * 
 * Description : PHP Class handling the CRUD operations with Log objects
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/DatabaseConnection.php');
require_once('wrk/HashManager.php');
require_once('bean/RestofulOrderUser.php');

class RestofulOrderUserDBManager
{

  private $databaseConnection;

  public function __construct()
  {
    $this->databaseConnection = DatabaseConnection::getInstance();
  }

  /**
   * Retreives a RestofulOrderUser from the database using a specified primary key.
   * returns null if the key is null, undefined or empty
   * 
   * @param string $pkUser. The primary key of the user to get from the database.
   * @return User the user corresponding to the primary key $pkUser of there is one, an empty User otherwise
   */
  public function getPkRestofulOrderUser($pkUser)
  {
    if (!isset($pkUser) or $pkUser == "") {
      return null;
    }
    // Execute query
    $queryContent = "select * from t_restoful_order_user where pk_restoful_order_user=:pkUser";
    $params = ['pkUser' => htmlentities($pkUser)];
    $query = $this->databaseConnection->selectQuery($queryContent, $params);

    // If a user was found
    if (count($query) == 1) {
      $pk = $query[0]['pk_restoful_order_user'];
      $login = $query[0]['login'];
      $password = $query[0]['password'];
      $user = new RestofulOrderUser($pk, $login, $password);
    } else {
      $user = new RestofulOrderUser("", "", "");
    }
    return $user;
  }

  /**
   * Checks if given credentials are correct
   * 
   * @param string $login. The login of the user 
   * @param string $password. The password to check
   * 
   * @return RestofulOrderUser The corresponding user if there was one, an empty user if not
   */
  public function checkUserCredentials($login, $password)
  {
    $user = new RestofulOrderUser("", "", "", "", "", "", "");
    if (isset($login) && isset($password)) {
      // First get the password in the database that corresponds to the login
      $login = htmlentities($login);
      $queryContent = "select * from t_restoful_order_user where login=:login";
      $params = ['login' => $login];
      $query = $this->databaseConnection->selectQuery($queryContent, $params);

      if (count($query) == 1) {
        // If there is one, then check if the credentials are correct by hashing them
        $pwdCorrect = $query[0]['password'];
        if (HashManager::verifyUserPassword($login, $password, $pwdCorrect)) {
          $pk = $query[0]['pk_restoful_order_user'];
          $login = $query[0]['login'];
          $password = $query[0]['password'];
          $user = new RestofulOrderUser($pk, $login, $password);
        }
      }
    }
    return $user;
  }
}
