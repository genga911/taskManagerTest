<?php

namespace Controllers;

class TasksController extends BasicController
{

    /**
     * лист задач с сортировкой
     * @param $vars
     * @throws \Exception
     */
    public static function tasks($vars)
    {
        if (empty($vars->request['direct']) || !empty($vars->request['direct']) && in_array($vars->request['direct'], ['desc', 'asc']) &&
            empty($vars->request['order']) || !empty($vars->request['order']) && in_array($vars->request['order'], ['id', 'email', 'user_name', 'task_status'])
        ) {
            self::View('tasks', [
                'tasks' => \Models\Task::getTasks(intval($vars->request['offset']), $vars->request['order'] ?? 'id', $vars->request['direct'] ?? 'desc'),
                'isAdmin' => \Models\UserModel::isAdmin(),
                'pagination' => \Models\Task::getPagination(intval($vars->request['offset']), $vars->request['order'] ?? 'id', $vars->request['direct'] ?? 'desc'),
                'offset' => $vars->request['offset'],
                'order' => $vars->request['order'] ?? 'id',
                'direct' => $vars->request['direct'] ?: 'desc',
            ]);
        } else {
            throw new \Exception(422);
        }
    }

    /**
     * вспомогательный метод валидации данных для создаия или изменения задачи
     * @param $requestData
     * @return bool
     * @throws \Exception
     */
    private static function checkDataRequest($requestData)
    {
        $res = filter_var($requestData['email'], FILTER_VALIDATE_EMAIL) && $requestData['user_name'] && $requestData['task_text'];
        if (!$res) {
            throw new \Exception(422);
        }

        return $res;
    }

    /**
     * создание новой задачи
     * @param $vars
     * @throws \Exception
     */
    public static function newTask($vars)
    {
        if (static::checkDataRequest($vars->request)) {
            \Models\Task::newTask(
                $vars->request['email'],
                $vars->request['user_name'],
                $vars->request['task_text']
            );
        }
    }

    /**
     * создание новой задачи
     * @param $vars
     * @throws \Exception
     */
    public static function updateTask($vars)
    {
        if (static::checkDataRequest($vars->request)) {
            if ($vars->params['id']) {
                \Models\Task::updateTask(
                    $vars->request['email'],
                    $vars->request['user_name'],
                    $vars->request['task_text'],
                    $vars->params['id']
                );
            } else {
                throw new \Exception(422);
            }
        }
    }

    /**
     * завершение задачи
     * @param $vars
     * @throws \Exception
     */
    public static function finishTask($vars)
    {
        if ($vars->params['id']) {
            \Models\Task::finishTask($vars->params['id']);
        } else {
            throw new \Exception(422);
        }
    }
}