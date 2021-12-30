<?php

/**
 * Class Name : Order
 * 
 * Description : Bean of the table t_order from the database
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

class Order
{
	private $pkOrder;
	private $restofulOrderUser;
	private $orderDateTime;
	private $deliveryDateTime;
	private $destination;
	private $price;
	private $content;


	function __construct($pkOrder, $restofulOrderUser, $orderDateTime, $deliveryDateTime, $destination, $price, $content)
	{
		$this->pkOrder = htmlentities($pkOrder);
		$this->restofulOrderUser = $restofulOrderUser;
		$this->orderDateTime = htmlentities($orderDateTime);
		$this->deliveryDateTime = htmlentities($deliveryDateTime);
		$this->destination = htmlentities($destination);
		$this->price = htmlentities($price);
		$this->content = htmlentities($content);
	}


	/**
	 * Converts the bean into the XML format
	 * @return string the bean in the XML format
	 */
	public function toXML()
	{
		$xml = "<order>";
		$xml .= "<pkOrder>{$this->pkOrder}</pkOrder>";
		$xml .= "<restofulOrderUser>{$this->restofulOrderUser->toXMLInnerValues()}</restofulOrderUser>";
		$xml .= "<orderDateTime>{$this->orderDateTime}</orderDateTime>";
		$xml .= "<deliveryDateTime>{$this->deliveryDateTime}</deliveryDateTime>";
		$xml .= "<destination>{$this->destination}</destination>";
		$xml .= "<price>{$this->price}</price>";
		$xml .= "<content>{$this->content}</content>";
		$xml .= "</order>";
		return $xml;
	}

	public function getPkOrder()
	{
		return $this->pkOrder;
	}

	public function setPkOrder($pkOrder)
	{
		$this->pkOrder = $pkOrder;
	}

	public function getRestofulOrderUser()
	{
		return $this->restofulOrderUser;
	}

	public function setRestofulOrderUser($restofulOrderUser)
	{
		$this->restofulOrderUser = $restofulOrderUser;
	}

	public function getOrderDateTime()
	{
		return $this->orderDateTime;
	}

	public function setOrderDateTime($orderDateTime)
	{
		$this->orderDateTime = $orderDateTime;
	}

	public function getDeliveryDateTime()
	{
		return $this->deliveryDateTime;
	}

	public function setDeliveryDateTime($deliveryDateTime)
	{
		$this->deliveryDateTime = $deliveryDateTime;
	}

	public function getDestination()
	{
		return $this->destination;
	}

	public function setDestination($destination)
	{
		$this->destination = $destination;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}
	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}
}
