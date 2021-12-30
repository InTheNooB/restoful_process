<?php

/**
 * Class Name : RestofulOrderUser
 * 
 * Description : Bean of the table t_restoful_order_user from the database
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

class RestofulOrderUser
{
	private $pkRestofulOrderUser;
	private $login;
	private $password;


	function __construct($pkRestofulOrderUser, $login, $password)
	{
		$this->pkRestofulOrderUser = htmlentities($pkRestofulOrderUser);
		$this->login = htmlentities($login);
		$this->password = htmlentities($password);
	}


	/**
	 * Converts the bean into the XML format
	 * @return string the bean in the XML format
	 */
	public function toXML()
	{
		$xml = "<restofulOrderUser>";
		$xml .= "<pkRestofulOrderUser>{$this->pkRestofulOrderUser}</pkRestofulOrderUser>";
		$xml .= "<login>{$this->login}</login>";
		$xml .= "<password>{$this->password}</password>";
		$xml .= "</restofulOrderUser>";
		return $xml;
	}


	/**
	 * Converts the bean into the XML format without the root tags
	 * @return String the bean in the XML format
	 */
	public function toXMLInnerValues()
	{
		$xml = "<pkRestofulOrderUser>{$this->pkRestofulOrderUser}</pkRestofulOrderUser>";
		$xml .= "<login>{$this->login}</login>";
		$xml .= "<password>{$this->password}</password>";
		return $xml;
	}

	public function getPkRestofulOrderUser()
	{
		return $this->pkRestofulOrderUser;
	}

	public function setPkRestofulOrderUser($pkRestofulOrderUser)
	{
		$this->pkRestofulOrderUser = $pkRestofulOrderUser;
	}

	public function getLogin()
	{
		return $this->login;
	}

	public function setLogin($login)
	{
		$this->login = $login;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}
}
