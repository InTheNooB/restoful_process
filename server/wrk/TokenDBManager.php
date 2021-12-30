<?php

/**
 * Class Name : TokenDBManager
 * 
 * Description : PHP Class handling the CRUD operations with Token objects
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/DatabaseConnection.php');
require_once('wrk/RestofulOrderUserDBManager.php');
require_once('bean/Token.php');

class TokenDBManager
{

  private $databaseConnection;

  public function __construct()
  {
    $this->databaseConnection = DatabaseConnection::getInstance();
  }

  /**
   * Retrieves a list of Tokens from the database.
   * 
   * @return string the list of tokens in the XML format
   */
  public function getTokensAsXML()
  {

    // Retrieve data from the database
    $queryContent = "select * from t_token";
    $query = $this->databaseConnection->selectQuery($queryContent, null);
    $userDBManager = new RestofulOrderUserDBManager();

    // Process this data to have an XML version of it
    $xml = "<tokens>";
    foreach ($query as $q) {
      $u = $userDBManager->getPkRestofulOrderUser(htmlentities($q['fk_restoful_order_user']));
      $d = new Token(
        $q['pk_token'],
        $u,
        $q['token'],
        $q['expiration_date_time'],
        $q['creation_date_time']
      );
      $xml .= $d->toXML();
    }
    $xml .= "</tokens>";
    return $xml;
  }

  /**
   * Adds a token to the database using the specified foreign restofulorderuser key
   * 
   * @param string $fkRestofulOrderUser. The primary key of the resofulorderuser to link to the token
   * @param string $duration. The duration (in days) of availability of the token
   * @return string The generated token if there was no error, null otherwise.
   */
  public function addTokenRestofulUser($fkRestofulOrderUser, $duration)
  {
    if (isset($fkRestofulOrderUser) && $fkRestofulOrderUser != "") {
      $queryContent = "
      insert into t_token (fk_restoful_order_user, token, expiration_date_time, creation_date_time) 
      values (:fkRestofulOrderUser, :token, date_add(current_date, interval :day day), now())";
      $token = $this->generateToken();
      $params = ['fkRestofulOrderUser' => htmlentities($fkRestofulOrderUser), 'token' => $token, 'day' => $duration];
      if ($this->databaseConnection->executeQuery($queryContent, $params) == 1) {
        return $token;
      }
    }
    return null;
  }
  /**
   * Adds a token to the database using the specified foreign user key 
   * 
   * @param string $fkUser. The primary key of the resofulorderuser to link to the token
   * @param string $duration. The duration (in days) of availability of the token
   * @return string The generated token if there was no error, null otherwise.
   */
  public function addTokenUser($fkUser, $duration)
  {
    if (isset($fkUser) && $fkUser != "") {
      $queryContent = "
      insert into t_token (fk_user, token, expiration_date_time, creation_date_time) 
      values (:fkUser, :token, date_add(current_date, interval :day day), now())";
      $token = $this->generateToken();
      $params = ['fkUser' => htmlentities($fkUser), 'token' => $token, 'day' => $duration];
      if ($this->databaseConnection->executeQuery($queryContent, $params) == 1) {
        return $token;
      }
    }
    return null;
  }

  /**
   * Checks if a given token corresponds to a user. 
   * 
   * @param string $token. The token to check
   * @return User the corresponding user if there was one, null otherwise.
   */
  public function checkTokenUser($token)
  {
    if (isset($token) && $token != "") {
      $queryContent = "select * from t_token tok
      inner join t_user rou
      on tok.fk_user = rou.pk_user
      where tok.token=:token and datediff(now(),tok.expiration_date_time) <= 0";
      $params = ['token' => htmlentities($token)];
      $query = $this->databaseConnection->selectQuery($queryContent, $params);
      if (count($query) == 1) {
        $u = new User(
          $query[0]['pk_user'],
          $query[0]['last_name'],
          $query[0]['first_name'],
          $query[0]['email'],
          $query[0]['login'],
          $query[0]['password'],
          $query[0]['img']
        );
        return $u;
      }
    }
    return null;
  }


  /**
   * Checks if a given token corresponds to a restofulorderuser. 
   * 
   * @param string $token. The token to check
   * @return RestofulOrderUser the corresponding user if there was one, null otherwise.
   */
  public function checkTokenRestofulOrderUser($token)
  {
    if (isset($token) && $token != "") {
      $queryContent = "select * from t_token tok
      inner join t_restoful_order_user rou
      on tok.fk_restoful_order_user = rou.pk_restoful_order_user
      where tok.token=:token and datediff(now(),tok.expiration_date_time) <= 0";
      $params = ['token' => htmlentities($token)];
      $query = $this->databaseConnection->selectQuery($queryContent, $params);
      if (count($query) == 1) {
        $u = new RestofulOrderUser(
          $query[0]['pk_restoful_order_user'],
          $query[0]['login'],
          $query[0]['password']
        );
        return $u;
      }
    }
    return null;
  }

  /**
   * Generates a random token of 15 char
   * 
   * @return string the generated token
   */
  public function generateToken()
  {
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(15 / strlen($x)))), 1, 15);
  }

  /**
   * Removes a token from the database
   * 
   * @param string $token. The token to delete
   * @return void
   */
  public function removeToken($token)
  {
    if (isset($token) && $token != null) {
      $queryContent = "delete from t_token where token=:token";
      $params = ['token' => $token];
      $this->databaseConnection->executeQuery($queryContent, $params);
    }
  }
}
