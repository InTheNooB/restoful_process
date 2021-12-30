<?php

/**
 * Class Name : UserDBManager
 * 
 * Description : PHP Class handling the CRUD operations with User objects
 * 
 * @version 1.0
 * @auhor Ding Lionel 
 * @project RestofulProcess
 */

require_once('wrk/DatabaseConnection.php');
require_once('wrk/HashManager.php');
require_once('bean/User.php');

class UserDBManager
{

  private $databaseConnection;

  public function __construct()
  {
    $this->databaseConnection = DatabaseConnection::getInstance();
  }

  /**
   * Looks for a user in the database using a primary key as filter.
   * 
   * @param string $pkUser. The primary key of the user to find
   * @return User the corresponding user if there was one, an empty user otherwise.
   */
  public function getUserByPk($pkUser)
  {
    $user = new User("", "", "", "", "", "", "");
    if (isset($pkUser) && $pkUser != "") {
      $queryContent = "select * from t_user where pk_user=:pkUser";
      $params = ['pkUser' => htmlentities($pkUser)];
      $query = $this->databaseConnection->selectQuery($queryContent, $params);
      if (count($query) == 1) {
        $pk = $query[0]['pk_user'];
        $lastName = $query[0]['last_name'];
        $firstName = $query[0]['first_name'];
        $email = $query[0]['email'];
        $login = $query[0]['login'];
        $passw = $query[0]['password'];
        $img = $query[0]['img'];
        $user = new User($pk, $lastName, $firstName, $email, $login, $passw, $img);
      }
    }
    return $user;
  }

  /**
   * Checks if credentials are correct.
   * 
   * @param string $login. The login of the user to check
   * @param string $password. The password of the user to check
   * 
   * @return User the corresponding user if there is one, en empty user otherwise. 
   */
  public function checkUserCredentials($login, $password)
  {
    $user = new User("", "", "", "", "", "", "");
    if (isset($login) && isset($password)) {

      // First get the password in the database that corresponds to the login
      $queryContent = "select * from t_user where login=:login";
      $params = ['login' => htmlentities($login)];
      $query = $this->databaseConnection->selectQuery($queryContent, $params);

      if (count($query) == 1) {
        // If there is one, then check if the credentials are correct by hashing them
        $pwdCorrect = $query[0]['password'];
        if (HashManager::verifyUserPassword(htmlentities($login), $password, $pwdCorrect)) {
          $pk = $query[0]['pk_user'];
          $lastName = $query[0]['last_name'];
          $firstName = $query[0]['first_name'];
          $email = $query[0]['email'];
          $login = $query[0]['login'];
          $passw = $query[0]['password'];
          $img = $query[0]['img'];
          $user = new User($pk, $lastName, $firstName, $email, $login, $passw, $img);
        }
      }
    }

    return $user;
  }

  /**
   * Hashes and changes the specified password in the database 
   * 
   * @param string $login. The login of the user to change password
   * @param string $password. The new password
   * @return void
   */
  public function changeUserPasswordByPk($login, $password)
  {
    if (isset($login) && isset($password)) {
      $hashedPassword = HashManager::getHashedUserPassword($login, $password);
      $queryContent = "update t_user set password=:password where login=:login";
      $params = ['login' => htmlentities($login), 'password' => htmlentities($hashedPassword)];
      $this->databaseConnection->executeQuery($queryContent, $params);
    }
  }
}
