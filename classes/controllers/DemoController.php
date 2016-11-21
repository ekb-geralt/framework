<?php
namespace controllers;

use Application;
use City;
use Controller;

class DemoController extends Controller
{
    public $defaultActionName = 'hello'; //перегрузили значение свойства Controller::$defaultActionName

    public function sortAction()
    {
        $errors = [];
        $numbers = [];
        $strNumbers = $this->app->request->numbers; //numbers - несуществующее свойство, к которому мы обращаемся и поэтому вызывается магический метод __get из того объекта в котором не было найдено свойство; возвращает значение неизвестного или необъявленного свойства
        if (isset($strNumbers)) {
            $numbers = str_replace(["\n", "\r"], ' ', $strNumbers);
            $numbers = explode(' ', $numbers);
            $numbers = array_filter($numbers, function ($number) {
                return $number != '';
            });
            if (!$numbers) {
                $errors[] = "Пустая строка.";
            }
            foreach ($numbers as $number) {
                if (!is_numeric($number)) {
                    $errors[] = '"' . $number . '" не число!';
                }
            }
            if (!$errors) { //пустой массив кастуется как false
                sort($numbers);
            }
        }
        $this->render('sort', ['numbers' => $numbers, 'errors' => $errors]);
    }

    public function helloAction()
    {
        $message = 'Hello, World!';
        
        $this->render('hello', ['message' => $message]);
    }

    public function testAction()
    {
          ?><a href="\">На главную</a><br><?php
//        $city = City::getById(1);
//        $city->name = 'sdfsdf';
//        $city->save();
//        if (Application::getInstance()->session->isUserLoggedIn) {
//            echo '+';
//        } else { echo '-'; }
//        echo '<br><a href="\demo\hello">Назад</a>';
//        print_r(Application::getInstance()->user->getUser());

//        $newCity = new City();
//        $newCity->name = 'blabla';
//        $newCity->countryId = '1';
//        $newCity->save();

        $city = City::getById(1);
        print_r($city->getFields());
    }
}