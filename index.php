<?php

if (!isset($_POST['data'])) {
    // раскомментируй ответ в случае отсутсвия данных в запросе
    // echo 'No POST data';
    // die();
}

require 'inc/class-Router.php';
$router = new Router();

$router->setEnvData();

$url = key($_GET);

$router->addRoute('/', 'report.php');
$router->route('/', $url);
