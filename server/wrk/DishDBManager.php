<?php

/**
 * Class Name : DishDBManager
 * 
 * Description : PHP Class handling the CRUD operations with Dish objects
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/DatabaseConnection.php');
require_once('bean/Dish.php');

class DishDBManager
{

  private $databaseConnection;

  public function __construct()
  {
    $this->databaseConnection = DatabaseConnection::getInstance();
  }

  /**
   * Retrieves a list of Dish from the database and returns it as XML
   * 
   * @return string the list of dishes in the XML format
   */
  public function getDishesAsXML()
  {
    // Retrieve data from the database
    $queryContent = "select * from t_dish";
    $query = $this->databaseConnection->selectQuery($queryContent, null);

    // Process this data to have an XML version of it
    $xml = "<dishes>";
    foreach ($query as $q) {
      $pk = $q['pk_dish'];
      $name = $q['name'];
      $d = new Dish($pk, $name);
      $xml .= $d->toXML();
    }
    $xml .= "</dishes>";
    return $xml;
  }

  /**
   * Adds a dish to the database using the specified dish name
   * 
   * @param string $dishName. The dish name to add to the database
   * @return void 
   */
  public function addDish($dishName)
  {
    if (isset($dishName)) {
      $queryContent = "insert into t_dish (name) values (:dishName)";
      $params = ['dishName' => htmlentities($dishName)];
      $this->databaseConnection->executeQuery($queryContent, $params);
    }
  }

  /**
   * Removes a dish from the database using the specified primary key
   * 
   * @param string $pkDish. The primary key of the dish to remove from the database
   * @return void 
   */
  public function removeDishByPk($pkDish)
  {
    if (isset($pkDish) and $pkDish != "") {
      $queryContent = "delete from t_dish where pk_dish=:pkDish;";
      $params = ['pkDish' => htmlentities($pkDish)];
      $this->databaseConnection->executeQuery($queryContent, $params);
    }
  }
}
