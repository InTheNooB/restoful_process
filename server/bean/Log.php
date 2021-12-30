<?php

/**
 * Class Name : Log
 * 
 * Description : Bean of the table t_log from the database
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

class Log
{
	private $pkLog;
	private $user;
	private $start;


	function __construct($pkLog, $user, $start)
	{
		$this->pkLog = htmlentities($pkLog);
		$this->user = $user;
		$this->start = htmlentities($start);
	}


	/**
	 * Converts the bean into the XML format
	 * @return string the bean in the XML format
	 */
	public function toXML()
	{
		$xml = "<log>";
		$xml .= "<pkLog>{$this->pkLog}</pkLog>";
		$xml .= $this->user->toXML();
		$xml .= "<start>{$this->start}</start>";
		$xml .= "</log>";
		return $xml;
	}

	public function getPkLog()
	{
		return $this->pkLog;
	}

	public function setPkLog($pkLog)
	{
		$this->pkLog = $pkLog;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}

	public function getStart()
	{
		return $this->start;
	}

	public function setStart($start)
	{
		$this->start = $start;
	}
}
