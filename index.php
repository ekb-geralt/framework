<?php
/**
 * Created by PhpStorm.
 * User: Guest
 * Date: 16.03.2016
 * Time: 20:29
 */
//точка входа
//include - для того файла, который что то делает, require_once для объявления
//framework.local(название сайта)/news(название контроллера-модуль отвечающий за работу с определенными однотипными данными, в данном случае - с новостями)/list(экшен)?sort=date(параметры)
ini_set('display_errors',  '1');
header('Content-Type: text/html; charset=utf-8');
require_once 'Application.php';
require_once 'Request.php';
require_once 'UrlManager.php';

$request = new Request();
$urlManager = new UrlManager();
$route = $urlManager->getCurrentRoute();
$application = new Application();
$application->request = $request;
$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);