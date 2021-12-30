<?php

/**
 * Class Name : Dish
 * 
 * Description : Bean of the table t_dish from the database
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

class Dish
{
	private $pkDish;
	private $name;


	function __construct($pkDish, $name)
	{
		$this->pkDish = htmlentities($pkDish);
		$this->name = htmlentities($name);
	}

	/**
	 * Converts the bean into the XML format
	 * @return string the bean in the XML format
	 */
	public function toXML()
	{
		$xml = "<dish>";
		$xml .= "<pkDish>{$this->pkDish}</pkDish>";
		$xml .= "<name>{$this->name}</name>";
		$xml .= "</dish>";
		return $xml;
	}

	public function getPkDish()
	{
		return $this->pkDish;
	}

	public function setPkDish($pkDish)
	{
		$this->pkDish = $pkDish;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

}