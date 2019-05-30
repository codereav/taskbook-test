<?php

namespace App\Model;

use App\System\Application;

/**
 * Class TaskModel
 * @package App\Model
 */
class TaskModel extends BaseModel implements ValidationInterface
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $username
     */
    private $username;
    /**
     * @var string $email
     */
    private $email;
    /**
     * @var string $content
     */
    private $content;
    /**
     * @var int $status
     */
    private $status;


    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * Method return array of tasks from DB
     * @return array
     */
    public function getTasks(): array
    {
        $result = [];
        $query = $this->db->query("SELECT * FROM tasks");
        if ($rows = $query->fetchAll()) {
            foreach ($rows as $row) {
                $result[] = $row;
            }
            return $result;
        }
    }

    /**
     * @param int $id
     * @return array
     */
    public function getTaskById(int $id): array
    {
        $query = $this->db->query("SELECT * FROM tasks WHERE id='" . $id . "' LIMIT 1");
        $result = $query->fetch();

        return $result ? $result : [];
    }

    /**
     * Method gets array ($_POST), validate and sanitize needle values and set its as model properties
     * @param array $post
     * @return bool
     */
    public function validate(array $post): bool
    {
        if (isset($post['id'])) {

            $id = filter_var($post['id'], FILTER_SANITIZE_NUMBER_INT);

            //if task exists and user is logged - set Id as model property, else redirect to error page
            if ($this->getTaskById($id) && Application::getInstance()->getAuth()->isLoggedIn()) {
                $this->id = $id;
            } else {
                Application::getInstance()->redirect('/error');
            }
        }

        if (isset($post['username'])) {
            $this->username = filter_var($post['username'], FILTER_SANITIZE_STRING);
        }

        if (isset($post['email'])) {
            $this->email = filter_var($post['email'], FILTER_SANITIZE_EMAIL);
        }

        if (isset($post['content'])) {
            $this->content = filter_var($post['content'], FILTER_SANITIZE_STRING);
        }

        if (isset($post['status'])) {

            //if user is logged - set status as model property, else redirect to error page
            if (Application::getInstance()->getAuth()->isLoggedIn()) {
                $this->status = (int)filter_var($post['status'], FILTER_VALIDATE_BOOLEAN);
            } else {
                Application::getInstance()->redirect('/error');
            }
        }

        return true;
    }

    /**
     * Method save model data to DB (update() if exists $this->id OR add() if not)
     * @return bool
     */
    public function save(): bool
    {
        if ($this->id) {
            return $this->update();
        } else {
            return $this->add();
        }
    }

    /**
     * Update task data
     * @return bool
     */
    private function update(): bool
    {
        $sql = "UPDATE tasks SET username='" . $this->username . "', email='" . $this->email . "', content='" . $this->content . "'";
        $sql .= ($this->status !== null) ? (", status='" . ($this->status ? '1' : '0') . "'") : '';
        $sql .= " WHERE id='" . $this->id . "'";
        return (bool)$this->db->query($sql);
    }

    /**
     * Add new task
     * @return bool
     */
    private function add(): bool
    {
        $sql = "INSERT INTO tasks SET username='" . $this->username . "', email='" . $this->email . "', content='" . $this->content . "'";
        return (bool)$this->db->query($sql);
    }


}