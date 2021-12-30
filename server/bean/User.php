<?php

/**
 * Class Name : User
 * 
 * Description : Bean of the table t_user from the database
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

class User
{
	private $pkUser;
	private $lastName;
	private $firstName;
	private $email;
	private $login;
	private $password;
	private $img;


	function __construct($pkUser, $lastName, $firstName, $email, $login, $password, $img)
	{
		$this->pkUser = htmlentities($pkUser);
		$this->lastName = htmlentities($lastName);
		$this->firstName = htmlentities($firstName);
		$this->email = htmlentities($email);
		$this->login = htmlentities($login);
		$this->password = htmlentities($password);
		$this->img = $img;
	}

	/**
	 * Converts the bean into the XML format
	 * @return string the bean in the XML format
	 */
	public function toXML()
	{
		$xml = "<user>";
		$xml .= "<pkUser>{$this->pkUser}</pkUser>";
		$xml .= "<lastName>{$this->lastName}</lastName>";
		$xml .= "<firstName>{$this->firstName}</firstName>";
		$xml .= "<email>{$this->email}</email>";
		$xml .= "<login>{$this->login}</login>";
		$xml .= "<password>{$this->password}</password>";
		$img = base64_encode($this->img);
		$xml .= "<img>{$img}</img>";
		$xml .= "</user>";
		return $xml;
	}

	public function getPkUser()
	{
		return $this->pkUser;
	}

	public function setPkUser($pkUser)
	{
		$this->pkUser = $pkUser;
	}

	public function getLastName()
	{
		return $this->lastName;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
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
