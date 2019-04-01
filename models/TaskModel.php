<?php

namespace Models;

class Task
{
    const TASKS_LIMIT = 3; //лимит задач на странице
    const TASK_STATUS_FINISHED = 'finished'; // статус завершенности задачи

    /**
     * Возврат массива задач, списком, с учетом сортировки
     * @param array $filters
     * @param int $offset
     * @return array
     */
    public static function getTasks($offset = 0, $order = null, $direct = 'desc')
    {
        return \Tools\DB::connection()->fetchRowMany('SELECT id, email, user_name, task_status, task_text FROM tasks ORDER BY ' . $order . ' ' . $direct . ' LIMIT :limit OFFSET :offset',
            [
               // 'ord' => $order ?: 'id',
                'limit' => static::TASKS_LIMIT,
                'offset' => $offset ? intval($offset) * static::TASKS_LIMIT : $offset,
            ]);
    }

    /**
     * пагинация
     * @param int $offset актиная страница
     * @param string|null $order
     * @return array
     */
    public static function getPagination($offset = 0, $order = null, $direct = 'desc')
    {
        $cnt = \Tools\DB::connection()->FetchColumn('SELECT COUNT(id) as cnt FROM tasks ORDER BY :ord', ['ord' => $order ?: 'id']);

        $query = [];

        if ($order) {
            $query[] = 'order=' . $order;
            $query[] = 'direct=' . $direct;
            $query[] = '';
        }

        return [
            'pages' => ceil($cnt / static::TASKS_LIMIT),
            'query' => implode('&', $query),
            'active' => $offset
        ];
    }

    public static function newTask($email, $user_name, $task_text)
    {
        \Tools\DB::connection()->insert('tasks', [
            'email' => $email,
            'user_name' => $user_name,
            'task_text' => $task_text
        ]);
    }

    public static function updateTask($email, $user_name, $task_text, $id)
    {
        \Tools\DB::connection()->update('tasks', ['id' => $id], [
            'email' => $email,
            'user_name' => $user_name,
            'task_text' => $task_text
        ]);
    }

    public function finishTask($id)
    {
        \Tools\DB::connection()->update('tasks', ['id' => $id], [
            'task_status' => static::TASK_STATUS_FINISHED
        ]);
    }
}