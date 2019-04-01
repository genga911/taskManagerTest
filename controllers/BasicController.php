<?php

namespace Controllers;

class BasicController
{
    /**
     * ленивый рендеринг
     * @param string $template шаблон
     * @param array $params данные
     */
    public static function View($template = 'index', $params = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader('./templates');
        $twig = new \Twig\Environment($loader);
        echo $twig->render($template . '.twig', $params);
    }
}