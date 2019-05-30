<?php

namespace App\Model;

use App\System\Application;

/**
 * Class BaseModel
 * @package App\Model
 */
abstract class BaseModel
{
    /**
     * @var \PDO
     */
    protected $db;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $this->db = Application::getInstance()->getDb();
    }

}