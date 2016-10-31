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
use components\Database;
use components\FlashMessages;
use components\Request;
use components\Session;
use components\UrlManager;
use components\User;

ini_set('display_errors',  '1');
header('Content-Type: text/html; charset=utf-8');
define('PROJECT_ROOT', __DIR__); //константа содержит путь до корня проекта
require_once 'classes/components/Autoloader.php';

$autoloader = new Autoloader();
$autoloader->register();
$database = new Database();
$database->connect('188.73.181.180', 'root', 'pi31415', 'Geralt'); //теперь адрес сервера БД в виде ip, т.к. убунта долго резолвит днс
$session = new Session();
$flashMessages = new FlashMessages($session);
$user = new User($session, $database);

$request = new Request();
$urlManager = new UrlManager();
$route = $urlManager->getCurrentRoute();
$application = Application::getInstance();
$application->request = $request;
$application->autoloader = $autoloader;
$application->db = $database;
$application->session = $session;
$application->flashMessages = $flashMessages;
$application->user = $user;
$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);
