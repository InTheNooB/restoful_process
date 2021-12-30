<?php

/**
 * Class Name : LogDBManager
 * 
 * Description : PHP Class handling the CRUD operations with Log objects
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/DatabaseConnection.php');
require_once('wrk/UserDBManager.php');
require_once('bean/Log.php');

class LogDBManager
{

  private $databaseConnection;

  public function __construct()
  {
    $this->databaseConnection = DatabaseConnection::getInstance();
  }

  /**
   * Retrieves a list of Log from the database and returns it as XML
   * 
   * @return string the list of logs in the XML format
   */
  public function getLogsAsXML()
  {
    // Retrieve data from the database
    $queryContent = "select * from t_log";
    $query = $this->databaseConnection->selectQuery($queryContent, null);

    // Process this data to have an XML version of it
    $userDBManager = new UserDBManager();
    $xml = "<logs>";
    foreach ($query as $q) {
      $u = $userDBManager->getUserByPk(htmlentities($q['fk_user']));
      $d = new Log(
        $q['pk_log'],
        $u,
        $q['start']
      );
      $xml .= $d->toXML();
    }
    $xml .= "</logs>";
    return $xml;
  }

  /**
   * Adds a Log to the database
   * 
   * @param string $fkUser. The foreign key of the user associated to the log
   * @return void
   */
  public function addLog($fkUser)
  {
    if (isset($fkUser)) {
      $queryContent = "insert into t_log (fk_user, start) values (:fkUser, now())";
      $params = ['fkUser' => htmlentities($fkUser)];
      $this->databaseConnection->executeQuery($queryContent, $params);
    }
  }
}
