<?php

/**
 * Class Name : HashManager
 * 
 * Description : PHP Class handling the hash and verification of password
 * 
 * @version 1.0
 * @auhor Ding Lionel
 * @project RestofulProcess
 */

class HashManager
{
    protected static $staticSalt = "asdd31E+12413ASC";

    /**
     * Creates a hashed password by concatenating the user login, the user raw password and a static salt.
     * This hash is created using the password_hash function which is native in PHP
     * returns the hashed password.
     * 
     * @param string $login. The login of the user
     * @param string $password. The password of the user
     * 
     * @return string The hashed password
     */
    public static function getHashedUserPassword($login, $password)
    {
        return password_hash(self::$staticSalt . $password . $login, PASSWORD_DEFAULT);
    }

    /**
     * Verifies a user password using the password_verifiy function from PHP.
     * 
     * @param string $login. The login of the user
     * @param string $pwdToVerify. The password to check
     * @param string $pwdCorrect. The correct hashed password
     * 
     * @return boolean true if the password is correct, false otherwise
     */
    public static function verifyUserPassword($login, $pwdToVerify, $pwdCorrect)
    {
        return password_verify(self::$staticSalt . $pwdToVerify . $login, $pwdCorrect);
    }
}
