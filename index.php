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
require_once 'Autoloader.php';

$autoloader = new Autoloader();
$autoloader->register();
$database = new Database();
$database->connect('Buncha.ru', 'root', 'pi31415', 'Geralt');
//$queryData = $database->sendQuery('SELECT * FROM cities`LEFT JOIN countries ON cities.countryId = countries.id');
//print_r($queryData);
$query = new Query($database);
print_r($query
    ->select(['cities.name as City', 'countries.name as Country'])
    ->from('cities')
    ->join('countries', ['=', 'countries.id', new DatabaseFieldExpression('cities.countryId')])
    ->group(['Country', 'isCapital'])
    ->order(['Country'])
    ->getRows()
);
exit;

$request = new Request();
$urlManager = new UrlManager();
$route = $urlManager->getCurrentRoute();
$application = new Application();
$application->request = $request;
$application->autoloader = $autoloader;
$controller = $application->getController($route->controllerName);
$controller->execute($route->actionName);