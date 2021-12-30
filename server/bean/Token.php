<?php

/**
 * Class Name : Token
 * 
 * Description : Bean of the table t_token from the database
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

class Token
{
	private $pkToken;
	private $restofulOrderUser;
	private $token;
	private $expirationDateTime;
	private $creationDateTime;


	function __construct($pkToken, $restofulOrderUser, $token, $expirationDateTime, $creationDateTime)
	{
		$this->pkToken = htmlentities($pkToken);
		$this->restofulOrderUser = $restofulOrderUser;
		$this->token = htmlentities($token);
		$this->expirationDateTime = htmlentities($expirationDateTime);
		$this->creationDateTime = htmlentities($creationDateTime);
	}


	/**
	 * Converts the bean into the XML format
	 * @return string the bean in the XML format
	 */
	public function toXML()
	{
		$xml = "<token>";
		$xml .= "<pkToken>{$this->pkToken}</pkToken>";
		$xml .= $this->restofulOrderUser->toXML();
		$xml .= "<token>{$this->token}</token>";
		$xml .= "<expirationDateTime>{$this->expirationDateTime}</expirationDateTime>";
		$xml .= "<creationDateTime>{$this->creationDateTime}</creationDateTime>";
		$xml .= "</token>";
		return $xml;
	}

	public function getPkToken()
	{
		return $this->pkToken;
	}

	public function setPkToken($pkToken)
	{
		$this->pkToken = $pkToken;
	}

	public function getRestofulOrderUser()
	{
		return $this->restofulOrderUser;
	}

	public function setRestofulOrderUser($restofulOrderUser)
	{
		$this->restofulOrderUser = $restofulOrderUser;
	}

	public function getToken()
	{
		return $this->token;
	}

	public function setToken($token)
	{
		$this->token = $token;
	}

	public function getExpirationDateTime()
	{
		return $this->expirationDateTime;
	}

	public function setExpirationDateTime($expirationDateTime)
	{
		$this->expirationDateTime = $expirationDateTime;
	}

	public function getCreationDateTime()
	{
		return $this->creationDateTime;
	}

	public function setCreationDateTime($creationDateTime)
	{
		$this->creationDateTime = $creationDateTime;
	}
}
