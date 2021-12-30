<?php

/**
 * Class Name : OrderDBManager
 * 
 * Description : PHP Class handling the CRUD operations with Order objects
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/DatabaseConnection.php');
require_once('bean/Order.php');
require_once('bean/Dish.php');
require_once('bean/RestofulOrderUser.php');

class OrderDBManager
{

  private $databaseConnection;

  public function __construct()
  {
    $this->databaseConnection = DatabaseConnection::getInstance();
  }

  /**
   * Processes a query containing data from the tables t_order, t_restoful_order_user, t_dish and tr_order_dish into an XML format
   * 
   * @param string $query. The query to process
   * @return string The list of orders in the XML format or null if the $query is null or empty
   */
  private function processOrdersAndReturnAsXML($query)
  {
    if (!isset($query) or $query == "") {
      return null;
    }

    $orders = array();

    // Process the query to export an XML version of it 
    foreach ($query as $q) {
      $restofulOrderUser = new RestofulOrderUser($q['pk_restoful_order_user'], $q['login'], $q['password']);
      $order = new Order(
        $q['pk_order'],
        $restofulOrderUser,
        $q['order_date_time'],
        $q['delivery_date_time'] ?? null,
        $q['destination'],
        $q['price'],
        $q['dish_name']
      );

      // This part is needed to merge every tr_order_dish into one "content" field separated by "," 
      $found = false;
      foreach ($orders as $o) {
        if ($o->getPkOrder() == $q['pk_order']) {
          $found = true;
          $o->setContent($o->getContent() . ", " . $order->getContent());
        }
      }
      if (!$found) {
        array_push($orders, $order);
      }
    }

    $xml = "<orders>";
    foreach ($orders as $order) {
      $xml .= $order->toXML();
    }
    $xml .= "</orders>";
    return $xml;
  }

  /**
   * Retrieves an Order from the database using a specified client foreign key.
   * 
   * @param string $fkClient. The foreign key of the client
   * @return string A list of order beans in the XML format or null if the $fkClient is null or empty
   */
  public function getOrdersByFkClientAsXML($fkClient)
  {
    if (!isset($fkClient) or $fkClient == "") {
      return null;
    }

    // Retrieve data from the database
    $queryContent = "
    select ord.pk_order, ord.order_date_time, ord.delivery_date_time, ord.destination, ord.price, rou.pk_restoful_order_user, rou.login, rou.password, dis.name dish_name
    from t_order ord
    inner join t_restoful_order_user rou
    on rou.pk_restoful_order_user = ord.fk_restoful_order_user
    inner join tr_order_dish odi
    on ord.pk_order = odi.pfk_order
    inner join t_dish dis
    on dis.pk_dish = odi.pfk_dish
    where rou.pk_restoful_order_user = :fkClient
    ";
    $query = $this->databaseConnection->selectQuery($queryContent, ['fkClient' => htmlentities($fkClient)]);

    // Process this data to have an XML version of it
    return $this->processOrdersAndReturnAsXML($query);
  }

  /**
   * Retrieves a list of Order from the database.
   * 
   * @return string A list of bean in the XML format 
   */
  public function getOrdersAsXML()
  {
    // Retrieve data from the database
    $queryContent = "
    select ord.pk_order, ord.order_date_time, ord.delivery_date_time, ord.destination, ord.price, rou.pk_restoful_order_user, rou.login, rou.password, dis.name dish_name
    from t_order ord
    inner join t_restoful_order_user rou
    on rou.pk_restoful_order_user = ord.fk_restoful_order_user
    inner join tr_order_dish odi
    on ord.pk_order = odi.pfk_order
    inner join t_dish dis
    on dis.pk_dish = odi.pfk_dish
    ";
    $query = $this->databaseConnection->selectQuery($queryContent, null);

    // Process this data to have an XML version of it
    return $this->processOrdersAndReturnAsXML($query);
  }

  /**
   * Retrieves a list of unvalidated Order from the database.
   * 
   * @return string A list of bean in the XML format 
   */
  public function getUnvalidatedOrdersAsXML()
  {
    // Retrieve data from the database
    $queryContent = "
    select ord.pk_order, ord.order_date_time, ord.delivery_date_time, ord.destination, ord.price, rou.pk_restoful_order_user, rou.login, rou.password, dis.name dish_name
    from t_order ord
    inner join t_restoful_order_user rou
    on rou.pk_restoful_order_user = ord.fk_restoful_order_user
    inner join tr_order_dish odi
    on ord.pk_order = odi.pfk_order
    inner join t_dish dis
    on dis.pk_dish = odi.pfk_dish
    where delivery_date_time is null
    ";
    $query = $this->databaseConnection->selectQuery($queryContent, null);

    // Process this data to have an XML version of it
    return $this->processOrdersAndReturnAsXML($query);
  }

  /**
   * Retrieves a list of validated Order from the database
   * 
   * @return string A list of bean in the XML format 
   */
  public function getValidatedOrdersAsXML()
  {
    // Retrieve data from the database
    $queryContent = "
    select ord.pk_order, ord.order_date_time, ord.delivery_date_time, ord.destination, ord.price, rou.pk_restoful_order_user, rou.login, rou.password, dis.name dish_name
    from t_order ord
    inner join t_restoful_order_user rou
    on rou.pk_restoful_order_user = ord.fk_restoful_order_user
    inner join tr_order_dish odi
    on ord.pk_order = odi.pfk_order
    inner join t_dish dis
    on dis.pk_dish = odi.pfk_dish
    where delivery_date_time is not null
    ";
    $query = $this->databaseConnection->selectQuery($queryContent, null);

    // Process this data to have an XML version of it
    return $this->processOrdersAndReturnAsXML($query);
  }

  /**
   * Removes an Order from the database using a specified primary key 
   * 
   * @param string $pkOrder. The primary key of the order.
   * @return void
   */
  public function removeOrderByPk($pkOrder)
  {
    if (isset($pkOrder) && $pkOrder != "") {
      $pkOrder = htmlentities($pkOrder);
      $queryContent = "delete from t_order where pk_order=:pkOrder;";
      $params = ['pkOrder' => $pkOrder];
      $this->databaseConnection->executeQuery($queryContent, $params);
    }
  }


  /**
   * Validates an Order in the database by setting the delivery_date_time as current time. 
   * The Order is found using the specified primary key.
   * 
   * @param string $pkOrder. The primary key of the order to validate
   * @return void
   */
  public function validateOrderByPk($pkOrder)
  {
    if (isset($pkOrder) && $pkOrder != "") {
      // Get the current time
      date_default_timezone_set("Europe/Paris");
      $now = date('Y-m-d H:i:s');

      $queryContent = "update t_order set delivery_date_time=:date where pk_order=:pkOrder;";
      $params = ['date' => $now, 'pkOrder' => htmlentities($pkOrder)];
      $this->databaseConnection->executeQuery($queryContent, $params);
    }
  }

  /**
   * Creates an Order by processing the array passed as parameter and adds it to the database
   * 
   * @param RestofulOrderUser $restofulOrderClient. The client that asked to add an order
   * @param array $array. An array containing all the data about the order to add
   * @return void
   */
  public function addOrderFromArray($restofulOrderClient, $array)
  {
    if (isset($restofulOrderClient) && isset($array) && count($array) != 0) {

      // Creates the order
      $order = new Order(
        null,
        $restofulOrderClient,
        null,
        null,
        $array['destination'],
        $array['price'],
        null
      );

      // Adds every dish present in the array
      $dishes = array();
      foreach ($array['content'] as $c) {
        array_push($dishes, new Dish(
          $c,
          null
        ));
      }

      // Adds the order to the database
      $this->addOrder($order, $dishes);
    }
  }

  /**
   * Adds an order to the database and adds an entry in tr_order_dish for each item in the $dishes array
   * 
   * @param Order $order. The order to add
   * @param array $dishes. An array containing every dishes related to this order
   * @return void
   */
  private function addOrder($order, $dishes)
  {
    if (isset($order) && isset($dishes)) {
      // Get the current time
      date_default_timezone_set("Europe/Paris");
      $now = date('Y-m-d H:i:s');

      // Add the order
      $queryContent = "
        insert into t_order (fk_restoful_order_user, order_date_time, destination, price) 
        values (:pkRestofulOrderUser, :orderDateTime, :destination, :price)
      ";
      $params = ['pkRestofulOrderUser' => $order->getRestofulOrderUser()->getPkRestofulOrderUser(), 'orderDateTime' => $now, 'destination' => $order->getDestination(), 'price' => $order->getPrice()];
      if ($this->databaseConnection->executeQuery($queryContent, $params) == 1) {

        // Get the recently added order to get it's PK
        $queryContent = "
          select pk_order from t_order 
          where fk_restoful_order_user=:pkRestofulOrderUser
          and order_date_time=:orderDateTime
          and destination=:destination
          and price=:price";
        $query = $this->databaseConnection->selectQuery($queryContent, $params);
        if (count($query) == 1) {
          // Add every tr_order_dish
          foreach ($dishes as $d) {
            $queryContent = "insert into tr_order_dish (pfk_order, pfk_dish) values (:pkOrder, :pkDish)";
            $params = ['pkOrder' => $query[0]['pk_order'], 'pkDish' => $d->getPkDish()];
            $this->databaseConnection->executeQuery($queryContent, $params);
          }
        }
      }
    }
  }
}
