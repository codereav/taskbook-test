<?php

namespace App\Controller;

use App\Model\TaskModel;
use App\System\Application;

/**
 * Class MainController
 *
 * @package App\Controller
 */
class MainController extends BaseController
{
    /**
     * @var TaskModel $taskModel
     */
    private $taskModel;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        //Set TaskModel in property
        $this->taskModel = new TaskModel();
    }

    /**
     * Method shows tasks table
     */
    public function index(): void
    {
        //Get all tasks
        $tasks = $this->taskModel->getTasks();

        $this->data['title'] = 'Список задач';
        $this->data['tasks'] = $this->buildDataTableTasks($tasks); //Convert array of tasks to json-string for DataTable

        //Build and render view
        $this->view->addPart('common' . DS . 'header');
        $this->view->addPart('table');
        $this->view->addPart('common' . DS . 'footer');

        $this->view->render($this->data);
    }

    /**
     * Method display task form for editing or create
     *
     * @param int|null $id
     */
    public function form(?int $id): void
    {
        //If exists Id and user authorized and exists task with this id
        if ($id && $this->isLogged && $task = $this->taskModel->getTaskById($id)) {

            $this->data['title'] = 'Задача #' . $id;
            $this->data['task'] = $task;

        } elseif ($id) { //else if Id exists - redirect to error page

            Application::getInstance()->redirect('/error');

        } else { //else show new task form

            $this->data['title'] = 'Создание задачи';
        }

        //Build and render view
        $this->view->addPart('common' . DS . 'header');
        $this->view->addPart('form');
        $this->view->addPart('common' . DS . 'footer');

        $this->view->render($this->data);
    }

    /**
     * Method save task data and redirect to main page,
     * or redirect to error page if $_POST empty or permissions denied
     */
    public function save(): void
    {
        //If not empty $_POST and data validated
        if (!empty($_POST) && $this->taskModel->validate($_POST)) {
            $this->taskModel->save();
            Application::getInstance()->redirect('/');
        } else {
            Application::getInstance()->redirect('/error');
        }
    }

    /**
     * Method display error page
     */
    public function error(): void
    {
        //Build and render view
        $this->data['title'] = 'Ошибка :: Доступ запрещён';
        $this->view->addPart('common' . DS . 'header');
        $this->view->addPart('deny');
        $this->view->addPart('common' . DS . 'footer');
        $this->view->render($this->data);
    }

    /**
     * Method display login form and handle $_POST request
     */
    public function login(): void
    {

        //If not empty $_POST and isset username and password
        if  (!empty($_POST) && isset($_POST['username'], $_POST['password'])) {

            //If login, redirect to main page
            if (Application::getInstance()->getAuth()->login($_POST['username'], $_POST['password'])) {
                Application::getInstance()->redirect('/');
            }
        }

        //Build and render view
        $this->view->addPart('common' . DS . 'header');
        $this->view->addPart('login');
        $this->view->addPart('common' . DS . 'footer');
        $this->view->render($this->data);
    }

    /**
     * Method doing logout and redirect to main page
     */
    public function logout(): void
    {
        Application::getInstance()->getAuth()->logout();
        Application::getInstance()->redirect('/');
    }

    /**
     * Method build DataTables-oriented json string from array of tasks
     * @param $tasks
     * @return string
     */
    private function buildDataTableTasks($tasks): string
    {
        $result = [];

        foreach ($tasks as $task) {
            $result[] = [
                $task['id'],
                $task['username'],
                $task['email'],
                $task['content'],
                $task['status'] ? 'Выполнена' : 'В работе',
                $this->isLogged ? ('<a href="/edit/' . $task['id'] . '">Редактировать</a>') : '',
            ];
        }
        return json_encode($result);
    }

}