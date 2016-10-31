<?php
namespace controllers;

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
        $city = City::getById(1);
        $city->name = 'sdfsdf';
        $city->save();
    }
}