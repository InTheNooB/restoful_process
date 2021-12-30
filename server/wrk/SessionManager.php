<?php

 /**
 * Class Name : SessionManager
 * 
 * Description : PHP Class handling the IO in the session super global variable
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

require_once('wrk/DatabaseConnection.php');
require_once('bean/User.php');

class SessionManager
{

	/**
	 * @return User the logged user if there is one, null otherwise
	 */
	public function getLoggedUser()
	{
		if (isset($_SESSION['loggedUser'])) {
			return $_SESSION['loggedUser'];
		} else {
			return null;
		}
	}

	/**
	 * Sets the loggued user
	 * 
	 * @param User $user. The user to set in the session
	 * @return void
	 */
	public function setLoggedUser($user)
	{
		$_SESSION['loggedUser'] = $user;
	}

	/**
	 * @return boolean true if the user is logged in according to the session, false otherwise
	 */
	public function isLoggedIn()
	{
		if (isset($_SESSION['loggedIn'])) {
			return $_SESSION['loggedIn'];
		} else {
			return false;
		}
	}

	/**
	 * @param boolean $loggedIn. Boolean representing logged or not not logged
	 */
	public function setLoggedIn($loggedIn)
	{
		$_SESSION['loggedIn'] = $loggedIn;
	}

	/**
	 * Clear the differents session values
	 */
	public function disconnectUser()
	{
		$this->setLoggedIn(false);
		$this->setLoggedUser(null);
	}
}
