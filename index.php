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
use components\Autoloader;

ini_set('display_errors',  '1');
header('Content-Type: text/html; charset=utf-8');
define('PROJECT_ROOT', __DIR__); //константа содержит путь до корня проекта
require_once 'classes/components/Autoloader.php';

$autoloader = new Autoloader();
$autoloader->register();

$config = include 'config.php';
$application = Application::getInstance();
$application->autoloader = $autoloader;
$application->configure($config);
$route = $application->urlManager->getCurrentRoute();
$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);
