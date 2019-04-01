# taskManagerTest
Тестовое задание по созданию простого менеджера задач

Запуск:
1. Скопировать содержимое репозитория
2. Выполнить composer install
3. Создать БД Mysql (название произвольное)
4. Создать таблицу tasks в БД 
  ```sql
    CREATE TABLE `tasks` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(100) NOT NULL,
    `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
    `task_status` enum('progress','finished') NOT NULL DEFAULT 'progress',
    `task_text` varchar(255) CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8;
  ```
  6. Открыть файл /tools/DB.php, установить настройки подключения 
  ```php
    private static $server = 'localhost';
    private static $user = 'root';
    private static $pass = '123456789';
    private static $database = 'test';
  ```
  5. Запустить php сервер, открыть index.php 

Если все верно, откроется список с текущими добавленными задачами.

Колонки
1. номер задачи
2. Email добавлявшего
3. Имя добавлявшего
4. Статус задачи (выполняется/выполнено)
5. Список опций (просмотр - для всех)

##Опции
#Для пользователя
1. Добавить задачу
2. Посмотреть задачу

#Для администратора (кнопка вход, admin/123)
1. Завершить (завершает рекущую задачу)
2. Редактировать


