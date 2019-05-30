<?php

namespace App\System;

/**
 * Class Auth
 * @package App\System
 */
class Auth
{
    /**
     * @var array config data
     */
    private $config;

    /**
     * Auth constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * user login
     * @param string $username
     * @param string $password
     * @return bool true if user logged in or false if not
     */
    public function login(string $username, string $password): bool
    {
        $username = $this->sanitizeString($username);
        $password = $this->sanitizeString($password);

        if ((!isset($_SESSION['logged']) || !$_SESSION['logged'])
            && $this->config['auth']['username'] === $username
            && $this->config['auth']['password'] === $password) {

            $_SESSION['logged'] = 'true';

        }
        return $this->isLoggedIn();
    }

    /**
     * user logout
     * @return bool true if user not logged or false if logged
     */
    public function logout(): bool
    {
        unset($_SESSION['logged']);

        return !$this->isLoggedIn();
    }

    /**
     * check if user logged in
     * @return bool true if logged or false if not
     */
    public function isLoggedIn(): bool
    {
        return $_SESSION['logged'] ?? false;
    }

    /**
     * @param string $string
     * @return mixed
     */
    private function sanitizeString(string $string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

}