<?php

namespace App\System;

/**
 * Class Database
 * @package App\System
 */
final class Database
{
    /**
     * @var \PDO
     */
    private static $instance;

    /**
     * Database constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $db = new \PDO(
            $config['driver'] . ':host=' . $config['host'] . ';' .
            'port=' . $config['port'] . ';' .
            'dbname=' . $config['database'],
            $config['username'],
            $config['password'],
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE ' . $config['collation']
            ]
        );

        if ($db) {
            self::$instance = $db;
        } else {
            throw new \PDOException('Database::connect() - Something went wrong');
        }
    }

    /**
     * @return \PDO
     */
    public static function getInstance(): \PDO
    {
        return self::$instance;
    }
}