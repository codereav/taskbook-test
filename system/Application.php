<?php

namespace App\System;

/**
 * Class Application
 * @package App\System
 */
final class Application
{
    /**
     * @var Auth
     */
    private $auth;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var Database
     */
    private $db;
    /**
     * @var View
     */
    private $view;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var Application
     */
    private static $instance;

    /**
     * Application constructor.
     * @param Auth $auth
     * @param Router $router
     * @param Database $db
     * @param View $view
     */
    public function __construct(Auth $auth, Router $router, Database $db, View $view)
    {
        if (self::$instance === null) {
            $this->auth = $auth;
            $this->router = $router;
            $this->db = $db;
            $this->view = $view;
            $this->baseUrl = $this->getBaseUrl();
            self::$instance = $this;
        }
    }

    /**
     * Method run router dispatch method
     */
    public function run(): void
    {
        $this->router->dispatch();
    }

    /**
     * @return Application
     */
    public static function getInstance(): Application
    {
        return self::$instance;
    }

    /**
     * @return \PDO
     */
    public function getDb(): \PDO
    {
        return $this->db::getInstance();
    }

    /**
     * @return Auth
     */
    public function getAuth(): Auth
    {
        return $this->auth;
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        return $this->view;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        if (!$this->baseUrl) {
            $this->baseUrl = $_SERVER['HTTPS']?'https://':'http://' . $_SERVER['HTTP_HOST'];
        }
        return $this->baseUrl;
    }

    /**
     * @param string $str
     * @return bool
     */
    public function redirect(string $str): bool
    {
        return header('Location: ' . $str);
    }
}